<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ActivitiesTagsFixture
 */
class ActivitiesTagsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'activity_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'tag_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'tags_activities_ibfk_1' => ['type' => 'index', 'columns' => ['activity_id'], 'length' => []],
            'tags_activities_ibfk_2' => ['type' => 'index', 'columns' => ['tag_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'tags_activities_ibfk_2' => ['type' => 'foreign', 'columns' => ['tag_id'], 'references' => ['tags', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'tags_activities_ibfk_1' => ['type' => 'foreign', 'columns' => ['activity_id'], 'references' => ['activities', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'activity_id' => 1,
                'tag_id' => 1,
            ],
        ];
        parent::init();
    }
}
