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
    public function canEdit(IdentityInterface $user, Pathway $pathway)
    {
        if($this->isAdmin($user, $pathway)) {
            return true;
        } elseif($this->isCurator($user,$pathway)) {
            return true;
        } else {
            return false;
        }

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



    protected function isCurator(IdentityInterface $user, Pathway $pathway)
    {
        //return $user->getIdentifier('role_id') === 5;
        return $user->role_id === 2;
    }

    protected function isAdmin(IdentityInterface $user, Pathway $pathway)
    {
        //return $user->getIdentifier('role_id') === 5;
        return $user->role_id === 5;
    }


}
