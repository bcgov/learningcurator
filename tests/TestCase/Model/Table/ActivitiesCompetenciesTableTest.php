<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ActivitiesCompetenciesTable;
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
        $config = $this->getTableLocator()->exists('ActivitiesCompetencies') ? [] : ['className' => ActivitiesCompetenciesTable::class];
        $this->ActivitiesCompetencies = $this->getTableLocator()->get('ActivitiesCompetencies', $config);
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
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
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
