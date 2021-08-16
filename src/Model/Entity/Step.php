<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Step Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $image_path
 * @property int|null $featured
 * @property \Cake\I18n\FrozenTime $created
 * @property string $createdby
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $modifiedby
 *
 * @property \App\Model\Entity\Activity[] $activities
 * @property \App\Model\Entity\Pathway[] $pathways
 */
class Step extends Entity
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
        'description' => true,
        'image_path' => true,
        'status_id' => true,
        'featured' => true,
        'created' => true,
        'createdby' => true,
        'modified' => true,
        'modifiedby' => true,
        'activities' => true,
        'pathways' => true,
    ];
}
