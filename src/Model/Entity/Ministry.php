<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ministry Entity
 *
 * @property int $id
 * @property string $name
 * @property string $elm_learner_group
 * @property string|null $description
 * @property string|null $hyperlink
 * @property string|null $image_path
 * @property string|null $color
 * @property int|null $featured
 *
 * @property \App\Model\Entity\Activity[] $activities
 * @property \App\Model\Entity\Pathway[] $pathways
 * @property \App\Model\Entity\User[] $users
 */
class Ministry extends Entity
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
        'elm_learner_group' => true,
        'description' => true,
        'hyperlink' => true,
        'image_path' => true,
        'color' => true,
        'featured' => true,
        'activities' => true,
        'pathways' => true,
        'users' => true,
    ];
}
