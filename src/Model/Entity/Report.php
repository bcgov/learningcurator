<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Report Entity
 *
 * @property int $id
 * @property int $activity_id
 * @property int $user_id
 * @property string|null $issue
 * @property int|null $curator_id
 * @property string|null $response
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Activity $activity
 * @property \App\Model\Entity\User $user
 */
class Report extends Entity
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
        'issue' => true,
        'curator_id' => true,
        'response' => true,
        'created' => true,
        'activity' => true,
        'user' => true,
    ];
}
