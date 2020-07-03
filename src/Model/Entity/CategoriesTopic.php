<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CategoriesTopic Entity
 *
 * @property int $category_id
 * @property int $topic_id
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Topic $topic
 */
class CategoriesTopic extends Entity
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
        'category' => true,
        'topic' => true,
    ];
}
