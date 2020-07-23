<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Report;
use Authorization\IdentityInterface;

/**
 * Report policy
 */
class ReportPolicy
{
    /**
     * Check if $user can view a list of all Reports
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Report $report
     * @return bool
     */
    public function canIndex(IdentityInterface $user, Report $report)
    {
        if($this->isAdmin($user, $report)) {
            return true;
        } elseif($this->isCurator($user,$report)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can create Report
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Report $report
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Report $report)
    {
        if($this->isAdmin($user, $report)) {
            return true;
        } elseif($this->isCurator($user,$report)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can update Report
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Report $report
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, Report $report)
    {
        if($this->isAdmin($user, $report)) {
            return true;
        } elseif($this->isCurator($user,$report)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can delete Report
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Report $report
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Report $report)
    {
        if($this->isAdmin($user, $report)) {
            return true;
        } elseif($this->isCurator($user,$report)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if $user can view Report
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Report $report
     * @return bool
     */
    public function canView(IdentityInterface $user, Report $report)
    {
        if($this->isAdmin($user, $report)) {
            return true;
        } elseif($this->isCurator($user,$report)) {
            return true;
        } else {
            return false;
        }
    }

    protected function isCurator(IdentityInterface $user, Report $report)
    {
        //return $user->getIdentifier('role_id') === 5;
        return $user->role_id === 2;
    }

    protected function isAdmin(IdentityInterface $user, Report $report)
    {
        //return $user->getIdentifier('role_id') === 5;
        return $user->role_id === 5;
    }
}
