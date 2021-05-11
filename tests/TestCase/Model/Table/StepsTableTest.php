<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StepsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StepsTable Test Case
 */
class StepsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\StepsTable
     */
    protected $Steps;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Steps',
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
        $config = $this->getTableLocator()->exists('Steps') ? [] : ['className' => StepsTable::class];
        $this->Steps = $this->getTableLocator()->get('Steps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Steps);

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
