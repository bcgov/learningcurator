<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PathwaysStep Entity
 *
 * @property int $id
 * @property int $step_id
 * @property int $pathway_id
 * @property int|null $sortorder
 * @property \Cake\I18n\FrozenTime|null $date_start
 * @property \Cake\I18n\FrozenTime|null $date_complete
 *
 * @property \App\Model\Entity\Step $step
 * @property \App\Model\Entity\Pathway $pathway
 */
class PathwaysStep extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'step_id' => true,
        'pathway_id' => true,
        'sortorder' => true,
        'date_start' => true,
        'date_complete' => true,
        'step' => true,
        'pathway' => true,
    ];
}
