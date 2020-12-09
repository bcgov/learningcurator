<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         1.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Authentication\Authenticator;

use Authentication\Identifier\IdentifierInterface;
use Psr\Http\Message\ServerRequestInterface;
use Cake\Cache\Engine\RedisEngine;

/**
 * Idir Authenticator
 *
 * Authenticates an identity based on a REMOTE_USER environment variable supplied by 
 * SiteMinder, which sits in front of the server.
 */
class IdirAuthenticator extends AbstractAuthenticator implements StatelessInterface
{

    /**
     * Authenticates the identity contained in a REMOTE_USER environment variable supplied by 
     * SiteMinder, which sits in front of the server.
     * Will use the `config.userModel`, and `config.fields`to find a matching record in the 
     * `config.userModel`. Will return false if there is no post data, either username or password 
     * is missing, or if the scope conditions have not been met.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request The request that contains login information.
     * @return \Authentication\Authenticator\ResultInterface
     */
    public function authenticate(ServerRequestInterface $request): ResultInterface
    {

        //$foobar = Cache::read('session');
        
        $idir = env('REMOTE_USER');
		$idir = strtolower(str_replace('IDIR\\','',$idir));
		

        $user = $this->_identifier->identify([
            IdentifierInterface::CREDENTIAL_TOKEN => $idir,
        ]);

        if (empty($user)) {
            return new Result(null, Result::FAILURE_IDENTITY_NOT_FOUND, $this->_identifier->getErrors());
        }

        return new Result($user, Result::SUCCESS);
    }

    /**
     * No-op method.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request A request object.
     * @return void
     */
    public function unauthorizedChallenge(ServerRequestInterface $request): void
    {
    }
}
