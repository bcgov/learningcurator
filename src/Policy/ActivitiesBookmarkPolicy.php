<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\ActivitiesBookmark;
use Authorization\IdentityInterface;

/**
 * ActivitiesBookmark policy
 */
class ActivitiesBookmarkPolicy
{
    /**
     * Check if $user can create ActivitiesBookmark
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivitiesBookmark $activitiesBookmark
     * @return bool
     */
    public function canAdd(IdentityInterface $user, ActivitiesBookmark $activitiesBookmark)
    {
        return true;
    }

    /**
     * Check if $user can update ActivitiesBookmark
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivitiesBookmark $activitiesBookmark
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, ActivitiesBookmark $activitiesBookmark)
    {
    }

    /**
     * Check if $user can delete ActivitiesBookmark
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivitiesBookmark $activitiesBookmark
     * @return bool
     */
    public function canDelete(IdentityInterface $user, ActivitiesBookmark $activitiesBookmark)
    {
    }

    /**
     * Check if $user can view ActivitiesBookmark
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\ActivitiesBookmark $activitiesBookmark
     * @return bool
     */
    public function canView(IdentityInterface $user, ActivitiesBookmark $activitiesBookmark)
    {
    }
}
