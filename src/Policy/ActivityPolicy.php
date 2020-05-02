<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Activity;
use Authorization\IdentityInterface;

/**
 * Activity policy
 */
class ActivityPolicy
{
    /**
     * Check if $user can create Activity
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Activity $activity
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Activity $activity)
    {
        if($this->isAdmin($user, $activity)) {
            return true;
        } elseif($this->isCurator($user,$activity)) {
            return true;
        } else {
            return false;
        }


    }

    /**
     * Check if $user can update Activity
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Activity $activity
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Activity $activity)
    {
        if($this->isAdmin($user, $activity)) {
            return true;
        } elseif($this->isCurator($user,$activity)) {
            return true;
        } else {
            return false;
        }


    }

    /**
     * Check if $user can import Activity
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Activity $activity
     * @return bool
     */
    public function canActivityImport(IdentityInterface $user, Activity $activity)
    {
        if($this->isAdmin($user, $activity)) {
            return true;
        } elseif($this->isCurator($user,$activity)) {
            return true;
        } else {
            return false;
        }


    }

    /**
     * Check if $user can delete Activity
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Activity $activity
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Activity $activity)
    {
        if($this->isAdmin($user, $activity)) {
            return true;
        } else {
            return false;
        }


    }

    /**
     * Check if $user can view Activity
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Activity $activity
     * @return bool
     */
    public function canView(IdentityInterface $user, Activity $activity)
    {
        return true;
    }

    /**
     * Check if $user can like Activity
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Activity $activity
     * @return bool
     */
    public function canLike(IdentityInterface $user, Activity $activity)
    {
        return true;
    }



    protected function isCurator(IdentityInterface $user, Activity $activity)
    {
        return $user->role_id === 2;
    }

    protected function isAdmin(IdentityInterface $user, Activity $activity)
    {
        return $user->role_id === 5;
    }



}
