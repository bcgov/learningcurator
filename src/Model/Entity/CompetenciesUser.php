<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CompetenciesUser Entity
 *
 * @property int $competency_id
 * @property int $user_id
 * @property string|null $priority
 *
 * @property \App\Model\Entity\Competency $competency
 * @property \App\Model\Entity\User $user
 */
class CompetenciesUser extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'priority' => true,
        'competency' => true,
        'user' => true,
    ];
}
