<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CompetenciesPathwaysTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CompetenciesPathwaysTable Test Case
 */
class CompetenciesPathwaysTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CompetenciesPathwaysTable
     */
    protected $CompetenciesPathways;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CompetenciesPathways',
        'app.Competencies',
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
        $config = TableRegistry::getTableLocator()->exists('CompetenciesPathways') ? [] : ['className' => CompetenciesPathwaysTable::class];
        $this->CompetenciesPathways = TableRegistry::getTableLocator()->get('CompetenciesPathways', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CompetenciesPathways);

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
