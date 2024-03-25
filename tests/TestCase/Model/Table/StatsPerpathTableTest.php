<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StatsPerpathTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StatsPerpathTable Test Case
 */
class StatsPerpathTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\StatsPerpathTable
     */
    protected $StatsPerpath;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.StatsPerpath',
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
        $config = $this->getTableLocator()->exists('StatsPerpath') ? [] : ['className' => StatsPerpathTable::class];
        $this->StatsPerpath = $this->getTableLocator()->get('StatsPerpath', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->StatsPerpath);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\StatsPerpathTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\StatsPerpathTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
