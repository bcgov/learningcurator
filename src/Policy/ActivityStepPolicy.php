<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\ActivityStep;
use Authorization\IdentityInterface;

/**
 * ActivityStep policy
 */
class ActivityStepPolicy
{
    /**
     * Check if $user can create ActivityStep
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivityStep $activityStep
     * @return bool
     */
    public function canCreate(IdentityInterface $user, ActivityStep $activityStep)
    {
    }

    /**
     * Check if $user can update ActivityStep
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivityStep $activityStep
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, ActivityStep $activityStep)
    {
    }

    /**
     * Check if $user can delete ActivityStep
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivityStep $activityStep
     * @return bool
     */
    public function canDelete(IdentityInterface $user, ActivityStep $activityStep)
    {
    }

    /**
     * Check if $user can view ActivityStep
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivityStep $activityStep
     * @return bool
     */
    public function canView(IdentityInterface $user, ActivityStep $activityStep)
    {
return true;
    }
}
