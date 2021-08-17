<?php
declare(strict_types=1);

/**
 * Copyright 2010 - 2019, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2018, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace CakeDC\Users\Model\Behavior;

use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventDispatcherTrait;
use Cake\Utility\Hash;
use CakeDC\Users\Exception\AccountNotActiveException;
use CakeDC\Users\Exception\MissingEmailException;
use CakeDC\Users\Exception\UserNotActiveException;
use CakeDC\Users\Plugin;
use CakeDC\Users\Traits\RandomStringTrait;
use DateTime;
use InvalidArgumentException;

/**
 * Covers social features
 */
class SocialBehavior extends BaseTokenBehavior
{
    use EventDispatcherTrait;
    use RandomStringTrait;

    /**
     * Username field it can be modified via config
     *
     * @var string
     */
    protected $_username = 'username';

    /**
     * Initialize an action instance
     *
     * @param array $config Configuration options passed to the constructor
     * @return void
     */
    public function initialize(array $config): void
    {
        if (isset($config['username'])) {
            $this->_username = $config['username'];
        }

        parent::initialize($config);
    }

    /**
     * Performs social login
     *
     * @param array $data Array social login.
     * @param array $options Array option data.
     * @throws \InvalidArgumentException
     * @throws \CakeDC\Users\Exception\UserNotActiveException
     * @throws \CakeDC\Users\Exception\AccountNotActiveException
     * @return bool|\Cake\Datasource\EntityInterface|mixed
     */
    public function socialLogin(array $data, array $options)
    {
        $reference = $data['id'] ?? null;
        $existingAccount = $this->_table->SocialAccounts->find()
                ->where([
                    'SocialAccounts.reference' => $reference,
                    'SocialAccounts.provider' => $data['provider'] ?? null,
                ])
                ->contain(['Users'])
                ->first();
        if (empty($existingAccount->user)) {
            $user = $this->_createSocialUser($data, $options);
            if (!empty($user->social_accounts[0])) {
                $existingAccount = $user->social_accounts[0];
            } else {
                //@todo: what if we don't have a social account after createSocialUser?
                throw new InvalidArgumentException(
                    __d('cake_d_c/users', 'Unable to login user with reference {0}', $reference)
                );
            }
        } else {
            $user = $existingAccount->user;
            $accountData = $this->extractAccountData($data);
            $this->_table->SocialAccounts->patchEntity($existingAccount, $accountData);
            $this->_table->SocialAccounts->save($existingAccount);
            $event = $this->dispatchEvent(Plugin::EVENT_SOCIAL_LOGIN_EXISTING_ACCOUNT, [
                'userEntity' => $user,
                'data' => $data,
            ]);

            if ($event->getResult() instanceof EntityInterface) {
                $user = $this->_table->save($event->getResult());
            }
        }
        if (!empty($existingAccount)) {
            if (!$existingAccount->active) {
                throw new AccountNotActiveException([
                    $existingAccount->provider,
                    $existingAccount->reference,
                ]);
            }
            if (!$user->active) {
                throw new UserNotActiveException([
                    $existingAccount->provider,
                    $existingAccount->$user,
                ]);
            }
        }

        return $user;
    }

    /**
     * Creates social user, populate the user data based on the social login data first and save it
     *
     * @param array $data Array social user.
     * @param array $options Array option data.
     * @throws \CakeDC\Users\Exception\MissingEmailException
     * @return bool|\Cake\Datasource\EntityInterface|mixed result of the save operation
     */
    protected function _createSocialUser($data, $options = [])
    {
        $useEmail = $options['use_email'] ?? null;
        $validateEmail = $options['validate_email'] ?? null;
        $tokenExpiration = $options['token_expiration'] ?? null;
        $existingUser = null;
        $email = $data['email'] ?? null;
        if ($useEmail && empty($email)) {
            throw new MissingEmailException(__d('cake_d_c/users', 'Email not present'));
        } else {
            $existingUser = $this->_table->find('existingForSocialLogin', compact('email'))->first();
        }

        $user = $this->_populateUser($data, $existingUser, $useEmail, $validateEmail, $tokenExpiration);

        $event = $this->dispatchEvent(Plugin::EVENT_BEFORE_SOCIAL_LOGIN_USER_CREATE, [
            'userEntity' => $user,
            'data' => $data,
        ]);
        $result = $event->getResult();
        if ($result instanceof EntityInterface) {
            $user = $result;
        }

        $this->_table->isValidateEmail = $validateEmail;
        $result = $this->_table->save($user);

        return $result;
    }

    /**
     * Build new user entity either by using an existing user or extracting the data from the social login
     * data to create a new one
     *
     * @param array $data Array social login.
     * @param \Cake\Datasource\EntityInterface $existingUser user data.
     * @param string $useEmail email to use.
     * @param string $validateEmail email to validate.
     * @param string $tokenExpiration token_expires data.
     * @return \Cake\Datasource\EntityInterface
     * @todo refactor
     */
    protected function _populateUser($data, $existingUser, $useEmail, $validateEmail, $tokenExpiration)
    {
        
        $accountData = $this->extractAccountData($data);
        $accountData['active'] = true;

        $dataValidated = $data['validated'] ?? null;

        if (empty($existingUser)) {

            $firstName = $data['first_name'] ?? null;
            $lastName = $data['last_name'] ?? null;

            if (!empty($firstName) && !empty($lastName)) {
                $userData['first_name'] = $firstName;
                $userData['last_name'] = $lastName;
            } else {

                //
                // The default code here split the full name by 
                // spaces, but that doesn't work for our usecase, 
                // where we have the monstrosity of:
                // 
                // Haggett, Allan PSA:EX
                // 
                // where just splitting by spaces is NOT a good strategy
                // (and resulted in the first/last names being flipped)
                // 
                // Start by splitting on the comma to get the last name
                // in the [0] position, then split the [1] by the :EX
                // 
                $name = explode(',', $data['full_name'] ?? '');
                $first = explode(':EX', $name[1]);
                //
                // This should result in $first[0] being "Allan PSA"
                // or "David W CITZ" so, now we explode on known Ministries
                // PSA and CITZ to start with to see if we can isolate and 
                // assign.
                //
                $psa = explode('PSA', $first[0]);
                $citz = explode('CITZ', $first[0]);
                // We are of course mapping ministries to our own table
                // completely manually at this point; hopefully, AzureAD
                // will provide this value directly in the future (maybe
                // it already does and I'm just not calling the correct thing)
                // and we can ditch this; in the meantime, we start with
                // the imperfect method so that we can at least show that
                // we considered how to do this.
                if(!empty($psa[0])) {
                    $fn = $psa[0];
                    $ministry = 2;
                } elseif(!empty($citz[0])) {
                    $fn = $citz[0];
                    $ministry = 3;
                } else {
                    $fn = $first[0];
                    $ministry = 1;
                }
                $userData['first_name'] = $fn;
                $userData['last_name'] = $name[0];
                $userData['ministry_id'] = $ministry;
                
            }
            $userData['username'] = $data['username'] ?? null;
            $username = $userData['username'] ?? null;
            if (empty($username)) {
                $dataEmail = $data['email'] ?? null;
                if (!empty($dataEmail)) {
                    $email = explode('@', $dataEmail);
                    $userData['username'] = Hash::get($email, 0);
                } else {
                    $firstName = $userData['first_name'] ?? null;
                    $lastName = $userData['last_name'] ?? null;
                    $userData['username'] = strtolower($firstName . $lastName);
                    $userData['username'] = preg_replace('/[^A-Za-z0-9]/i', '', $userData['username'] ?? null);
                }
            }

            $userData['username'] = $this->generateUniqueUsername($userData['username'] ?? null);
            if ($useEmail) {
                $userData['email'] = $data['email'] ?? null;
                if (empty($dataValidated)) {
                    $accountData['active'] = false;
                }
            }

            $userData['password'] = $this->randomString();
            $userData['avatar'] = $data['avatar'] ?? null;
            $userData['validated'] = !empty($dataValidated);
            $userData['tos_date'] = date('Y-m-d H:i:s');
            $userData['gender'] = $data['gender'] ?? null;
            $userData['social_accounts'][] = $accountData;

            $userData['additional_data'] = $data['raw']['oid'];


            $user = $this->_table->newEntity($userData);
            $user = $this->_updateActive($user, false, $tokenExpiration);
        } else {
            if ($useEmail && empty($dataValidated)) {
                $accountData['active'] = false;
            }
            $user = $existingUser;
        }
        $socialAccount = $this->_table->SocialAccounts->newEntity($accountData);
        //ensure provider is present in Entity
        $socialAccount['provider'] = $data['provider'] ?? null;
        $user['social_accounts'] = [$socialAccount];
        $user['role'] = Configure::read('Users.Registration.defaultRole') ?: 'user';

        return $user;
    }

    /**
     * Checks if username exists and generate a new one
     *
     * @param string $username username data.
     * @return string
     */
    public function generateUniqueUsername($username)
    {
        $i = 0;
        while (true) {
            $existingUsername = $this->_table->find()
                ->where([$this->_table->aliasField($this->_username) => $username])
                ->count();
            if ($existingUsername > 0) {
                $username = $username . $i;
                $i++;
                continue;
            }
            break;
        }

        return $username;
    }

    /**
     * Prepare a query to retrieve existing entity for social login
     *
     * @param \Cake\ORM\Query $query The base query.
     * @param array $options Find options with email key.
     * @return \Cake\ORM\Query
     */
    public function findExistingForSocialLogin(\Cake\ORM\Query $query, array $options)
    {
        return $query->where([
            $this->_table->aliasField('email') => $options['email'],
        ]);
    }

    /**
     * Extract the account data to insert/update
     *
     * @param array $data Social data.
     * @throws \Exception
     * @return array
     */
    protected function extractAccountData(array $data)
    {
        $accountData = [];
        $accountData['username'] = $data['username'] ?? null;
        $accountData['reference'] = $data['id'] ?? null;
        $accountData['avatar'] = $data['avatar'] ?? null;
        $accountData['link'] = $data['link'] ?? null;

        if ($accountData['avatar'] ?? null) {
            $accountData['avatar'] = str_replace('normal', 'square', $accountData['avatar']);
        }
        $accountData['description'] = $data['bio'] ?? null;
        $accountData['token'] = $data['credentials']['token'] ?? null;
        $accountData['token_secret'] = $data['credentials']['secret'] ?? null;
        $expires = $data['credentials']['expires'] ?? null;
        if (!empty($expires)) {
            $expiresTime = new DateTime();
            $accountData['token_expires'] = $expiresTime->setTimestamp($expires)->format('Y-m-d H:i:s');
        } else {
            $accountData['token_expires'] = null;
        }
        $accountData['data'] = serialize($data['raw'] ?? null);

        return $accountData;
    }
}
