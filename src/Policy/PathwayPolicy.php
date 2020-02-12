<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Pathway;
use Authorization\IdentityInterface;

/**
 * Pathway policy
 */
class PathwayPolicy
{
    /**
     * Check if $user can create Pathway
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Pathway $pathway
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Pathway $pathway)
    {
        return true;
    }

    /**
     * Check if $user can update Pathway
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Pathway $pathway
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, Pathway $pathway)
    {
    }

    /**
     * Check if $user can delete Pathway
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Pathway $pathway
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Pathway $pathway)
    {
    }

    /**
     * Check if $user can view Pathway
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Pathway $pathway
     * @return bool
     */
    public function canView(IdentityInterface $user, Pathway $pathway)
    {
    }
}
