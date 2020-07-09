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
        if($this->isAdmin($user, $activitiesBookmark)) {
            return true;
        } elseif($this->isCurator($user,$activitiesBookmark)) {
            return true;
        } elseif($this->isLearner($user,$activitiesBookmark)) {
            return true;
        } else {
            return false;
        }
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
    protected function isLearner(IdentityInterface $user, ActivitiesBookmark $activitiesBookmark)
    {
        return $activitiesBookmark->user_id === $user->getIdentifier();
    }
    protected function isCurator(IdentityInterface $user, ActivitiesBookmark $activitiesBookmark)
    {
        return $user->role_id === 2;
    }

    protected function isAdmin(IdentityInterface $user, ActivitiesBookmark $activitiesBookmark)
    {
        return $user->role_id === 5;
    }

}
