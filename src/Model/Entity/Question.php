<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Question Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $slug
 * @property string|null $content
 * @property int|null $status_id
 * @property \Cake\I18n\FrozenTime $created
 * @property string $createdby_id
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $modifiedby_id
 *
 * @property \App\Model\Entity\Status $status
 * @property \CakeDC\Users\Model\Entity\User $user
 */
class Question extends Entity
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
        'title' => true,
        'slug' => true,
        'content' => true,
        'status_id' => true,
        'created' => true,
        'createdby_id' => true,
        'modified' => true,
        'modifiedby_id' => true,
        'status' => true,
        'user' => true,
    ];
}
