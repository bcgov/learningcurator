<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pathway Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $color
 * @property string|null $description
 * @property string|null $objective
 * @property string|null $file_path
 * @property string|null $image_path
 * @property int|null $featured
 * @property int|null $category_id
 * @property int|null $ministry_id
 * @property \Cake\I18n\FrozenTime $created
 * @property int $createdby
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $modifiedby
 * @property int|null $status_id
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Ministry $ministry
 * @property \App\Model\Entity\Competency[] $competencies
 * @property \App\Model\Entity\Step[] $steps
 * @property \App\Model\Entity\User[] $users
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
        'slug' => true,
        'color' => true,
        'description' => true,
        'objective' => true,
        'file_path' => true,
        'image_path' => true,
        'featured' => true,
        'category_id' => true,
        'ministry_id' => true,
        'created' => true,
        'createdby' => true,
        'modified' => true,
        'modifiedby' => true,
        'category' => true,
        'ministry' => true,
        'competencies' => true,
        'steps' => true,
        'topics' => true,
        'users' => true,
        'status_id' => true,
        'estimated_time' => true,
    ];
}
