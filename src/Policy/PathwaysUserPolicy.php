<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\PathwaysUser;
use Authorization\IdentityInterface;

/**
 * PathwaysUser policy
 */
class PathwaysUserPolicy
{
    /**
     * Check if $user can create PathwaysUser
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\PathwaysUser $pathwaysUser
     * @return bool
     */
    public function canAdd(IdentityInterface $user, PathwaysUser $pathwaysUser)
    {
        return true;
    }

    /**
     * Check if $user can update PathwaysUser
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\PathwaysUser $pathwaysUser
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, PathwaysUser $pathwaysUser)
    {
    }

    /**
     * Check if $user can delete PathwaysUser
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\PathwaysUser $pathwaysUser
     * @return bool
     */
    public function canDelete(IdentityInterface $user, PathwaysUser $pathwaysUser)
    {
    }

    /**
     * Check if $user can view PathwaysUser
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\PathwaysUser $pathwaysUser
     * @return bool
     */
    public function canView(IdentityInterface $user, PathwaysUser $pathwaysUser)
    {
    }
}
