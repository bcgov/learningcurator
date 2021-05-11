<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MinistriesTable;
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
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Ministries') ? [] : ['className' => MinistriesTable::class];
        $this->Ministries = $this->getTableLocator()->get('Ministries', $config);
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
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
