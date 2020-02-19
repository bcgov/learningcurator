<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Authorization\IdentityInterface;

/**
 * User policy
 */
class UserPolicy
{
 
    /**
     * Check if $user can create User
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\User $resource
     * @return bool
     */
    public function canAdd(IdentityInterface $user, User $resource)
    {
        return $this->isAdmin($user, $resource);
	//return true;
    }

    /**
     * Check if $user can update User
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\User $resource
     * @return bool
     */
    public function canEdit(IdentityInterface $user, User $resource)
    {
        return $this->isAdmin($user, $resource);
    }

    /**
     * Check if $user can delete User
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\User $resource
     * @return bool
     */
    public function canDelete(IdentityInterface $user, User $resource)
    {
        return $this->isAdmin($user, $resource);
    }

    /**
     * Check if $user can view User
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\User $resource
     * @return bool
     */
    public function canView(IdentityInterface $user, User $resource)
    {
        return $this->isLearner($user, $resource);
	//return false;
    }

    /**
     * Check if $user can view home
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\User $resource
     * @return bool
     */
    public function canHome(IdentityInterface $user, User $resource)
    {
        return $this->isLearner($user, $resource);
	//return false;
    }

    protected function isLearner(IdentityInterface $user, User $resource)
    {
        return $resource->id === $user->getIdentifier();
    }


    protected function isAdmin(IdentityInterface $user, User $resource)
    {
        //return $user->getIdentifier('role_id') === 5;
        return $user->role_id === 5;
    }







}
