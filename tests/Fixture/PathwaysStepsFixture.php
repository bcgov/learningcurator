<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PathwaysStepsFixture
 */
class PathwaysStepsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'step_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pathway_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'date_start' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'date_complete' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'pathway_key' => ['type' => 'index', 'columns' => ['pathway_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['step_id', 'pathway_id'], 'length' => []],
            'pathways_steps_ibfk_1' => ['type' => 'foreign', 'columns' => ['step_id'], 'references' => ['steps', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'pathways_steps_ibfk_2' => ['type' => 'foreign', 'columns' => ['pathway_id'], 'references' => ['pathways', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
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
                'step_id' => 1,
                'pathway_id' => 1,
                'date_start' => '2020-01-28 22:27:54',
                'date_complete' => '2020-01-28 22:27:54',
            ],
        ];
        parent::init();
    }
}
