<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PathwaysUser Entity
 *
 * @property int $user_id
 * @property int $pathway_id
 * @property int|null $status_id
 * @property \Cake\I18n\FrozenTime|null $date_start
 * @property \Cake\I18n\FrozenTime|null $date_complete
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Pathway $pathway
 * @property \App\Model\Entity\Status $status
 */
class PathwaysUser extends Entity
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
        'status_id' => true,
        'date_start' => true,
        'date_complete' => true,
        'user' => true,
        'pathway' => true,
        'status' => true,
    ];
}
