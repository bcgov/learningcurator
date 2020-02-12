<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Category Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $image_path
 * @property string|null $color
 * @property string|null $featured
 * @property \Cake\I18n\FrozenTime $created
 * @property int $createdby
 *
 * @property \App\Model\Entity\Activity[] $activities
 * @property \App\Model\Entity\Pathway[] $pathways
 */
class Category extends Entity
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
        'description' => true,
        'image_path' => true,
        'color' => true,
        'featured' => true,
        'created' => true,
        'createdby' => true,
        'activities' => true,
        'pathways' => true,
    ];
}
