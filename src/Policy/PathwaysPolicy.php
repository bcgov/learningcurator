<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Pathways;
use Authorization\IdentityInterface;

/**
 * Pathways policy
 */
class PathwaysPolicy
{
    /**
     * Check if $user can create Pathways
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Pathways $pathways
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Pathways $pathways)
    {
        return true;
    }

    /**
     * Check if $user can update Pathways
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Pathways $pathways
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, Pathways $pathways)
    {
    }

    /**
     * Check if $user can delete Pathways
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Pathways $pathways
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Pathways $pathways)
    {
    }

    /**
     * Check if $user can view Pathways
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Pathways $pathways
     * @return bool
     */
    public function canView(IdentityInterface $user, Pathways $pathways)
    {
    }
}
