<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Status;
use Authorization\IdentityInterface;

/**
 * Status policy
 */
class StatusPolicy
{
    /**
     * Check if $user can create Status
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Status $status
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Status $status)
    {
        if($this->isAdmin($user, $status)) {
            return true;
        } elseif($this->isCurator($user,$status)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can update Status
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Status $status
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, Status $status)
    {
        if($this->isAdmin($user, $status)) {
            return true;
        } elseif($this->isCurator($user,$status)) {
            return false;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can delete Status
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Status $status
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Status $status)
    {
        if($this->isAdmin($user, $status)) {
            return true;
        } elseif($this->isCurator($user,$status)) {
            return false;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can view Status
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Status $status
     * @return bool
     */
    public function canView(IdentityInterface $user, Status $status)
    {
        if($this->isAdmin($user, $status)) {
            return true;
        } elseif($this->isCurator($user,$status)) {
            return true;
        } else {
            return false;
        }
    }

    protected function isCurator(IdentityInterface $user, Status $status)
    {
        return $user->role_id === 2;
    }

    protected function isAdmin(IdentityInterface $user, Status $status)
    {
        return $user->role_id === 5;
    }
}
