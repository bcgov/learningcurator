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
 * @property string|null $approvedby_id
 * @property \Cake\I18n\FrozenTime $created
 * @property string $createdby_id
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $modifiedby_id
 * @property int $activity_types_id
 * @property string|null $estimated_time
 * @property string|null $slug
 *
 * @property \App\Model\Entity\Status $status
 * @property \App\Model\Entity\Ministry $ministry
 * @property \CakeDC\Users\Model\Entity\User[] $users
 * @property \App\Model\Entity\ActivityType $activity_type
 * @property \App\Model\Entity\Report[] $reports
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
        'approvedby_id' => true,
        'created' => true,
        'createdby_id' => true,
        'modified' => true,
        'modifiedby_id' => true,
        'activity_types_id' => true,
        'estimated_time' => true,
        'slug' => true,
        'status' => true,
        'ministry' => true,
        'users' => true,
        'activity_type' => true,
        'reports' => true,
        'competencies' => true,
        'steps' => true,
        'tags' => true,
    ];
    protected function _getTagString()
    {
        if (isset($this->_fields['tag_string'])) {
            return $this->_fields['tag_string'];
        }
        if (empty($this->tags)) {
            return '';
        }
        $tags = new Collection($this->tags);
        $str = $tags->reduce(function ($string, $tag) {
            return $string . $tag->name . ', ';
        }, '');
        return trim($str, ', ');
    }
}
