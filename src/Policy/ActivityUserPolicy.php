<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\ActivityUser;
use Authorization\IdentityInterface;

/**
 * ActivityUser policy
 */
class ActivityUserPolicy
{
    /**
     * Check if $user can create ActivityUser
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivityUser $activityUser
     * @return bool
     */
    public function canClaim(IdentityInterface $user, ActivityUser $activityUser)
    {
	return true;
    }


    /**
     * Check if $user can create ActivityUser
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivityUser $activityUser
     * @return bool
     */
    public function canCreate(IdentityInterface $user, ActivityUser $activityUser)
    {
    }

    /**
     * Check if $user can update ActivityUser
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivityUser $activityUser
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, ActivityUser $activityUser)
    {
    }

    /**
     * Check if $user can delete ActivityUser
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivityUser $activityUser
     * @return bool
     */
    public function canDelete(IdentityInterface $user, ActivityUser $activityUser)
    {
    }

    /**
     * Check if $user can view ActivityUser
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivityUser $activityUser
     * @return bool
     */
    public function canView(IdentityInterface $user, ActivityUser $activityUser)
    {
    }
}
