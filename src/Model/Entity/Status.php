<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Status Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property \Cake\I18n\FrozenTime $created
 * @property string $createdby
 *
 * @property \App\Model\Entity\Activity[] $activities
 * @property \App\Model\Entity\Pathway[] $pathways
 * @property \App\Model\Entity\PathwaysUser[] $pathways_users
 */
class Status extends Entity
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
        'created' => true,
        'createdby' => true,
        'activities' => true,
        'pathways' => true,
        'pathways_users' => true,
    ];
}
