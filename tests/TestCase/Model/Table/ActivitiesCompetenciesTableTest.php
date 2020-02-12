<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ActivitiesCompetenciesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ActivitiesCompetenciesTable Test Case
 */
class ActivitiesCompetenciesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ActivitiesCompetenciesTable
     */
    protected $ActivitiesCompetencies;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ActivitiesCompetencies',
        'app.Activities',
        'app.Competencies',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ActivitiesCompetencies') ? [] : ['className' => ActivitiesCompetenciesTable::class];
        $this->ActivitiesCompetencies = TableRegistry::getTableLocator()->get('ActivitiesCompetencies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ActivitiesCompetencies);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
