<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Tag;
use Authorization\IdentityInterface;

/**
 * Tag policy
 */
class TagPolicy
{
    /**
     * Check if $user can create Tag
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Tag $tag
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Tag $tag)
    {
        if($this->isAdmin($user, $tag)) {
            return true;
        } elseif($this->isCurator($user,$tag)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can update Tag
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Tag $tag
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Tag $tag)
    {
        if($this->isAdmin($user, $tag)) {
            return true;
        } elseif($this->isCurator($user,$tag)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can delete Tag
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Tag $tag
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Tag $tag)
    {
        if($this->isAdmin($user, $tag)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can view Tag
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Tag $tag
     * @return bool
     */
    public function canView(IdentityInterface $user, Tag $tag)
    {
        return true;
    }

    protected function isCurator(IdentityInterface $user, Tag $tag)
    {
        return $user->role_id === 2;
    }

    protected function isAdmin(IdentityInterface $user, Tag $tag)
    {
        return $user->role_id === 5;
    }
}
