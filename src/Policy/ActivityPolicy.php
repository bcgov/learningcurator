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
        // All logged in users can create articles.
        return true;
    }

    /**
     * Check if $user can update Activity
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Activity $activity
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, Activity $activity)
    {
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
    }
}
