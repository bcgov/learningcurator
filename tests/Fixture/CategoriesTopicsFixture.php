<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CategoriesTopicsFixture
 */
class CategoriesTopicsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'category_id' => ['autoIncrement' => null, 'type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'precision' => null, 'comment' => null],
        'topic_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'precision' => null, 'comment' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['category_id', 'topic_id'], 'length' => []],
            'sqlite_autoindex_categories_topics_1' => ['type' => 'unique', 'columns' => ['category_id', 'topic_id'], 'length' => []],
            'topic_id_fk' => ['type' => 'foreign', 'columns' => ['topic_id'], 'references' => ['topics', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'category_id_fk' => ['type' => 'foreign', 'columns' => ['category_id'], 'references' => ['categories', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'category_id' => 1,
                'topic_id' => 1,
            ],
        ];
        parent::init();
    }
}
