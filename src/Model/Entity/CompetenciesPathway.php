<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CompetenciesPathway Entity
 *
 * @property int $competency_id
 * @property int $pathway_id
 *
 * @property \App\Model\Entity\Competency $competency
 * @property \App\Model\Entity\Pathway $pathway
 */
class CompetenciesPathway extends Entity
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
        'competency' => true,
        'pathway' => true,
    ];
}
