<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ActivitiesStep Entity
 *
 * @property int $activity_id
 * @property int $step_id
 * @property int|null $required
 * @property int|null $steporder
 *
 * @property \App\Model\Entity\Activity $activity
 * @property \App\Model\Entity\Step $step
 */
class ActivitiesStep extends Entity
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
        'required' => true,
        'steporder' => true,
        'activity' => true,
        'step' => true,
    ];
}
