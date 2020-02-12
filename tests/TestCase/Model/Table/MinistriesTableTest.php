<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MinistriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MinistriesTable Test Case
 */
class MinistriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MinistriesTable
     */
    protected $Ministries;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Ministries',
        'app.Activities',
        'app.Pathways',
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
        $config = TableRegistry::getTableLocator()->exists('Ministries') ? [] : ['className' => MinistriesTable::class];
        $this->Ministries = TableRegistry::getTableLocator()->get('Ministries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Ministries);

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
}
