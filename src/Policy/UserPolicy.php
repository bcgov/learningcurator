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
     * Check if $user can access main user index
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\User $resource
     * @return bool
     */
    public function canIndex(IdentityInterface $user, User $resource)
    {
        return $this->isAdmin($user, $resource);
    }
     /**
     * Check if $user can access main user index
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\User $resource
     * @return bool
     */
    public function canList(IdentityInterface $user, User $resource)
    {
        return $this->isAdmin($user, $resource);
    }

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
        if($this->isAdmin($user, $resource)) {
            return true;
        } elseif($this->isCurator($user,$resource)) {
            return true;
        } elseif($this->isLearner($user,$resource)) {
            return true;
        } else {
            return false;
        }
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
        if($this->isAdmin($user, $resource)) {
            return true;
        } else {
            return false;
        }
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
        if($this->isAdmin($user, $resource)) {
            return true;
        } elseif($this->isCurator($user,$resource)) {
            return true;
        } elseif($this->isLearner($user,$resource)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can view pathways
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\User $resource
     * @return bool
     */
    public function canPathways(IdentityInterface $user, User $resource)
    {
        return $this->isLearner($user, $resource);
    }
    /**
     * Check if $user can view bookmarks
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\User $resource
     * @return bool
     */
    public function canBookmarks(IdentityInterface $user, User $resource)
    {
        return $this->isLearner($user, $resource);
    }
    /**
     * Check if $user can view own reports
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\User $resource
     * @return bool
     */
    public function canReports(IdentityInterface $user, User $resource)
    {
        return $this->isLearner($user, $resource);
    }

    
    /**
     * Check if $user can view claimed activities
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\User $resource
     * @return bool
     */
    public function canClaimed(IdentityInterface $user, User $resource)
    {
        return $this->isLearner($user, $resource);
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
    protected function isCurator(IdentityInterface $user, User $resource)
    {
        //return $user->getIdentifier('role_id') === 5;
        return $user->role_id === 2;
    }







}
