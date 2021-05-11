<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pathway Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $color
 * @property string|null $description
 * @property string|null $objective
 * @property string|null $file_path
 * @property string|null $image_path
 * @property int|null $featured
 * @property int|null $topic_id
 * @property int|null $ministry_id
 * @property \Cake\I18n\FrozenTime $created
 * @property string $createdby
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $modifiedby
 * @property int|null $status_id
 * @property string|null $slug
 * @property string|null $estimated_time
 *
 * @property \App\Model\Entity\Topic $topic
 * @property \App\Model\Entity\Ministry $ministry
 * @property \App\Model\Entity\Status $status
 * @property \App\Model\Entity\Competency[] $competencies
 * @property \App\Model\Entity\Step[] $steps
 * @property \CakeDC\Users\Model\Entity\User[] $users
 */
class Pathway extends Entity
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
        'name' => true,
        'color' => true,
        'description' => true,
        'objective' => true,
        'file_path' => true,
        'image_path' => true,
        'featured' => true,
        'topic_id' => true,
        'ministry_id' => true,
        'created' => true,
        'createdby' => true,
        'modified' => true,
        'modifiedby' => true,
        'status_id' => true,
        'slug' => true,
        'estimated_time' => true,
        'topic' => true,
        'ministry' => true,
        'status' => true,
        'competencies' => true,
        'steps' => true,
        'users' => true,
    ];
}
