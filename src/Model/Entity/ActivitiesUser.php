<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ActivitiesUser Entity
 *
 * @property int $id
 * @property int $activity_id
 * @property string $user_id
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Activity $activity
 * @property \CakeDC\Users\Model\Entity\User $user
 */
class ActivitiesUser extends Entity
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
        'activity_id' => true,
        'user_id' => true,
        'step_id' => true,
        'created' => true,
        'activity' => true,
        'user' => true,
    ];
}
