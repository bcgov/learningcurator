<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PathwaysTopicsFixture
 */
class PathwaysTopicsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'pathway_id' => ['autoIncrement' => null, 'type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'precision' => null, 'comment' => null],
        'topic_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'precision' => null, 'comment' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['pathway_id', 'topic_id'], 'length' => []],
            'sqlite_autoindex_pathways_topics_1' => ['type' => 'unique', 'columns' => ['pathway_id', 'topic_id'], 'length' => []],
            'topic_id_fk' => ['type' => 'foreign', 'columns' => ['topic_id'], 'references' => ['topics', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'pathway_id_fk' => ['type' => 'foreign', 'columns' => ['pathway_id'], 'references' => ['pathways', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'pathway_id' => 1,
                'topic_id' => 1,
            ],
        ];
        parent::init();
    }
}
