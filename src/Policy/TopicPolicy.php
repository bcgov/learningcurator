<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Topic;
use Authorization\IdentityInterface;

/**
 * Topic policy
 */
class TopicPolicy
{
    /**
     * Check if $user can create Topic
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Topic $topic
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Topic $topic)
    {
        if($this->isAdmin($user, $topic)) {
            return true;
        } elseif($this->isCurator($user,$topic)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can update Topic
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Topic $topic
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Topic $topic)
    {
        if($this->isAdmin($user, $topic)) {
            return true;
        } elseif($this->isCurator($user,$topic)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can delete Topic
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Topic $topic
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Topic $topic)
    {
        if($this->isAdmin($user, $topic)) {
            return true;
        } elseif($this->isCurator($user,$topic)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can view Topic
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Topic $topic
     * @return bool
     */
    public function canView(IdentityInterface $user, Topic $topic)
    {
        return true;
    }

    
    protected function isCurator(IdentityInterface $user, Topic $topic)
    {
        return $user->role_id === 2;
    }

    protected function isAdmin(IdentityInterface $user, Topic $topic)
    {
        return $user->role_id === 5;
    }
}
