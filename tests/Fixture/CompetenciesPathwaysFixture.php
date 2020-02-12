<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CompetenciesPathwaysFixture
 */
class CompetenciesPathwaysFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'competency_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pathway_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'competencies_pathways_ibfk_1' => ['type' => 'index', 'columns' => ['pathway_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['competency_id', 'pathway_id'], 'length' => []],
            'competencies_pathways_ibfk_1' => ['type' => 'foreign', 'columns' => ['pathway_id'], 'references' => ['pathways', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'competencies_pathways_ibfk_2' => ['type' => 'foreign', 'columns' => ['competency_id'], 'references' => ['competencies', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'competency_id' => 1,
                'pathway_id' => 1,
            ],
        ];
        parent::init();
    }
}
