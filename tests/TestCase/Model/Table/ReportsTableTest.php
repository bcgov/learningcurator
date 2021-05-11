<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReportsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReportsTable Test Case
 */
class ReportsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReportsTable
     */
    protected $Reports;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Reports',
        'app.Activities',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Reports') ? [] : ['className' => ReportsTable::class];
        $this->Reports = $this->getTableLocator()->get('Reports', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Reports);

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
