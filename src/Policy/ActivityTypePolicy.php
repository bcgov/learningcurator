<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\ActivityType;
use Authorization\IdentityInterface;

/**
 * ActivityType policy
 */
class ActivityTypePolicy
{
    /**
     * Check if $user can create ActivityType
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivityType $activityType
     * @return bool
     */
    public function canCreate(IdentityInterface $user, ActivityType $activityType)
    {
    }

    /**
     * Check if $user can update ActivityType
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivityType $activityType
     * @return bool
     */
    public function canEdit(IdentityInterface $user, ActivityType $activityType)
    {
	return true;
    }

    /**
     * Check if $user can delete ActivityType
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivityType $activityType
     * @return bool
     */
    public function canDelete(IdentityInterface $user, ActivityType $activityType)
    {
    }

    /**
     * Check if $user can view ActivityType
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivityType $activityType
     * @return bool
     */
    public function canView(IdentityInterface $user, ActivityType $activityType)
    {
return true;
    }
}
