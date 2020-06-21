<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PathwaysTopicsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PathwaysTopicsTable Test Case
 */
class PathwaysTopicsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PathwaysTopicsTable
     */
    protected $PathwaysTopics;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.PathwaysTopics',
        'app.Pathways',
        'app.Topics',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PathwaysTopics') ? [] : ['className' => PathwaysTopicsTable::class];
        $this->PathwaysTopics = TableRegistry::getTableLocator()->get('PathwaysTopics', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->PathwaysTopics);

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
