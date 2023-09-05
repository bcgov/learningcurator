<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PathwaysStepsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PathwaysStepsTable Test Case
 */
class PathwaysStepsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PathwaysStepsTable
     */
    protected $PathwaysSteps;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PathwaysSteps',
        'app.Steps',
        'app.Pathways',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PathwaysSteps') ? [] : ['className' => PathwaysStepsTable::class];
        $this->PathwaysSteps = $this->getTableLocator()->get('PathwaysSteps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PathwaysSteps);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PathwaysStepsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PathwaysStepsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
