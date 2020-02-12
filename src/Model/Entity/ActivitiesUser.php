<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ActivitiesUser Entity
 *
 * @property int $activity_id
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime|null $started
 * @property \Cake\I18n\FrozenTime|null $finished
 * @property int|null $liked
 * @property string|null $notes
 *
 * @property \App\Model\Entity\Activity $activity
 * @property \App\Model\Entity\User $user
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
        'started' => true,
        'finished' => true,
        'liked' => true,
        'notes' => true,
        'activity' => true,
        'user' => true,
    ];
}
