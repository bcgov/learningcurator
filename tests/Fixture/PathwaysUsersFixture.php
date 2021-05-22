<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PathwaysUsersFixture
 */
class PathwaysUsersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user_id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'pathway_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'status_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => '1', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'date_start' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        'date_complete' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => ''],
        '_indexes' => [
            'pathways_users_ibfk_1' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'pathways_users_ibfk_2' => ['type' => 'index', 'columns' => ['pathway_id'], 'length' => []],
            'pathways_users_ibfk_3' => ['type' => 'index', 'columns' => ['status_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'pathways_users_ibfk_3' => ['type' => 'foreign', 'columns' => ['status_id'], 'references' => ['statuses', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'pathways_users_ibfk_2' => ['type' => 'foreign', 'columns' => ['pathway_id'], 'references' => ['pathways', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'pathways_users_ibfk_1' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'user_id' => '2e15726e-b491-40d6-ac3d-7a24196171ab',
                'pathway_id' => 1,
                'status_id' => 1,
                'date_start' => '2021-05-22 03:58:55',
                'date_complete' => '2021-05-22 03:58:55',
            ],
        ];
        parent::init();
    }
}
