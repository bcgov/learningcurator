<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PathwaysUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PathwaysUsersTable Test Case
 */
class PathwaysUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PathwaysUsersTable
     */
    protected $PathwaysUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PathwaysUsers',
        'app.Users',
        'app.Pathways',
        'app.Statuses',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PathwaysUsers') ? [] : ['className' => PathwaysUsersTable::class];
        $this->PathwaysUsers = TableRegistry::getTableLocator()->get('PathwaysUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PathwaysUsers);

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
