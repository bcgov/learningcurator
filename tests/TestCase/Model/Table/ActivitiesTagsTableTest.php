<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ActivitiesTagsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ActivitiesTagsTable Test Case
 */
class ActivitiesTagsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ActivitiesTagsTable
     */
    protected $ActivitiesTags;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ActivitiesTags',
        'app.Activities',
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
        $config = $this->getTableLocator()->exists('ActivitiesTags') ? [] : ['className' => ActivitiesTagsTable::class];
        $this->ActivitiesTags = $this->getTableLocator()->get('ActivitiesTags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ActivitiesTags);

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
