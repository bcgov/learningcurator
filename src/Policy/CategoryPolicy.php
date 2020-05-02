<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Category;
use Authorization\IdentityInterface;

/**
 * Category policy
 */
class CategoryPolicy
{
    /**
     * Check if $user can create Category
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Category $category
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Category $category)
    {
        if($this->isAdmin($user, $category)) {
            return true;
        } elseif($this->isCurator($user,$category)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can update Category
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Category $category
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Category $category)
    {
        if($this->isAdmin($user, $category)) {
            return true;
        } elseif($this->isCurator($user,$category)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can delete Category
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Category $category
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Category $category)
    {
        if($this->isAdmin($user, $category)) {
            return true;
        } elseif($this->isCurator($user,$category)) {
            return false;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can view Category
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Category $category
     * @return bool
     */
    public function canView(IdentityInterface $user, Category $category)
    {
        // skipped at controller level
    }

    protected function isCurator(IdentityInterface $user, Category $category)
    {
        return $user->role_id === 2;
    }

    protected function isAdmin(IdentityInterface $user, Category $category  )
    {
        return $user->role_id === 5;
    }
}
