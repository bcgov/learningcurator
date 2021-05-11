<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ActivitiesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ActivitiesTable Test Case
 */
class ActivitiesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ActivitiesTable
     */
    protected $Activities;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Activities',
        'app.Statuses',
        'app.Ministries',
        'app.Users',
        'app.ActivityTypes',
        'app.Reports',
        'app.Competencies',
        'app.Steps',
        'app.Tags',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Activities') ? [] : ['className' => ActivitiesTable::class];
        $this->Activities = $this->getTableLocator()->get('Activities', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Activities);

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
