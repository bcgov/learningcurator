<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PathwaysStepsTable;
use Cake\ORM\TableRegistry;
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
     * @var array
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
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PathwaysSteps') ? [] : ['className' => PathwaysStepsTable::class];
        $this->PathwaysSteps = TableRegistry::getTableLocator()->get('PathwaysSteps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PathwaysSteps);

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
