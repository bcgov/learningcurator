<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Step;
use Authorization\IdentityInterface;

/**
 * Step policy
 */
class StepPolicy
{
    /**
     * Check if $user can create Step
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Step $step
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Step $step)
    {
        if($this->isAdmin($user, $step)) {
            return true;
        } elseif($this->isCurator($user,$step)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can update Step
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Step $step
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Step $step)
    {
        if($this->isAdmin($user, $step)) {
            return true;
        } elseif($this->isCurator($user,$step)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can delete Step
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Step $step
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Step $step)
    {
        if($this->isAdmin($user, $step)) {
            return true;
        } elseif($this->isCurator($user,$step)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can view Step
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Step $step
     * @return bool
     */
    public function canView(IdentityInterface $user, Step $step)
    {
        return true;
    }

    /**
     * Check if $user can get status of Step
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Step $step
     * @return bool
     */
    public function canStatus(IdentityInterface $user, Step $step)
    {
        return true;
    }


    protected function isCurator(IdentityInterface $user, Step $step)
    {
        //return $user->getIdentifier('role_id') === 5;
        return $user->role_id === 2;
    }

    protected function isAdmin(IdentityInterface $user, Step $step)
    {
        //return $user->getIdentifier('role_id') === 5;
        return $user->role_id === 5;
    }



}
