<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CompetenciesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CompetenciesTable Test Case
 */
class CompetenciesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CompetenciesTable
     */
    protected $Competencies;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Competencies',
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
        $config = TableRegistry::getTableLocator()->exists('Competencies') ? [] : ['className' => CompetenciesTable::class];
        $this->Competencies = TableRegistry::getTableLocator()->get('Competencies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Competencies);

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
