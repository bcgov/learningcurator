<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Activity Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $hyperlink
 * @property string|null $description
 * @property string|null $licensing
 * @property string|null $moderator_notes
 * @property string|null $isbn
 * @property int|null $status_id
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property int|null $featured
 * @property int|null $moderation_flag
 * @property string|null $file_path
 * @property string|null $image_path
 * @property int|null $hours
 * @property int|null $recommended
 * @property int|null $ministry_id
 * @property int|null $category_id
 * @property int|null $approvedby_id
 * @property \Cake\I18n\FrozenTime $created
 * @property int $createdby_id
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $modifiedby_id
 * @property int $activity_types_id
 *
 * @property \App\Model\Entity\Status $status
 * @property \App\Model\Entity\Ministry $ministry
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\User[] $users
 * @property \App\Model\Entity\ActivityType $activity_type
 * @property \App\Model\Entity\Competency[] $competencies
 * @property \App\Model\Entity\Step[] $steps
 * @property \App\Model\Entity\Tag[] $tags
 */
class Activity extends Entity
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
        'hyperlink' => true,
        'description' => true,
        'licensing' => true,
        'moderator_notes' => true,
        'isbn' => true,
        'status_id' => true,
        'meta_title' => true,
        'meta_description' => true,
        'featured' => true,
        'moderation_flag' => true,
        'file_path' => true,
        'image_path' => true,
        'hours' => true,
        'recommended' => true,
        'ministry_id' => true,
        'category_id' => true,
        'approvedby_id' => true,
        'created' => true,
        'createdby_id' => true,
        'modified' => true,
        'modifiedby_id' => true,
        'activity_types_id' => true,
        'status' => true,
        'ministry' => true,
        'category' => true,
        'users' => true,
        'activity_type' => true,
        'competencies' => true,
        'steps' => true,
        'tags' => true,
    ];
}
