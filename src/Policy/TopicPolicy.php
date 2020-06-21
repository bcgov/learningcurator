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
        return true;
    }

    /**
     * Check if $user can update Topic
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Topic $topic
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, Topic $topic)
    {
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
}
