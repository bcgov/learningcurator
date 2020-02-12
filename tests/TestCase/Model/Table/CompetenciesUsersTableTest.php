<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CompetenciesUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CompetenciesUsersTable Test Case
 */
class CompetenciesUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CompetenciesUsersTable
     */
    protected $CompetenciesUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CompetenciesUsers',
        'app.Competencies',
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
        $config = TableRegistry::getTableLocator()->exists('CompetenciesUsers') ? [] : ['className' => CompetenciesUsersTable::class];
        $this->CompetenciesUsers = TableRegistry::getTableLocator()->get('CompetenciesUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CompetenciesUsers);

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
