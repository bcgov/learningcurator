<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\ActivitiesStep;
use Authorization\IdentityInterface;

/**
 * ActivitiesStep policy
 */
class ActivitiesStepPolicy
{
    /**
     * Check if $user can create ActivitiesStep
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivitiesStep $ActivitiesStep
     * @return bool
     */
    public function canAdd(IdentityInterface $user, ActivitiesStep $ActivitiesStep)
    {
        if($this->isAdmin($user, $ActivitiesStep)) {
            return true;
        } elseif($this->isCurator($user,$ActivitiesStep)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can update ActivitiesStep
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivitiesStep $ActivitiesStep
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, ActivitiesStep $ActivitiesStep)
    {
    }

    /**
     * Check if $user can delete ActivitiesStep
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivitiesStep $ActivitiesStep
     * @return bool
     */
    public function canDelete(IdentityInterface $user, ActivitiesStep $ActivitiesStep)
    {
    }

    /**
     * Check if $user can view ActivitiesStep
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivitiesStep $ActivitiesStep
     * @return bool
     */
    public function canView(IdentityInterface $user, ActivitiesStep $ActivitiesStep)
    {

    }

    /**
     * Check if $user can toggle requirement for an activity on a step
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivitiesStep $ActivitiesStep
     * @return bool
     */
    public function canRequiredToggle(IdentityInterface $user, ActivitiesStep $ActivitiesStep)
    {
        if($this->isAdmin($user, $ActivitiesStep)) {
            return true;
        } elseif($this->isCurator($user,$ActivitiesStep)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Check if $user can sort an activity on a step
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivitiesStep $ActivitiesStep
     * @return bool
     */
    public function canSort(IdentityInterface $user, ActivitiesStep $ActivitiesStep)
    {
        if($this->isAdmin($user, $ActivitiesStep)) {
            return true;
        } elseif($this->isCurator($user,$ActivitiesStep)) {
            return true;
        } else {
            return false;
        }
    }
    protected function isAdmin(IdentityInterface $user, ActivitiesStep $ActivitiesStep)
    {
        return $user->role_id === 5;
    }

    protected function isCurator(IdentityInterface $user, ActivitiesStep $ActivitiesStep)
    {
        return $user->role_id === 2;
    }

}
