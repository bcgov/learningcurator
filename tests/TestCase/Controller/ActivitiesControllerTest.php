<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\ActivitiesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ActivitiesController Test Case
 *
 * @uses \App\Controller\ActivitiesController
 */
class ActivitiesControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
        'app.ActivitiesUsers',
        'app.ActivitiesCompetencies',
        'app.ActivitiesSteps',
        'app.ActivitiesTags',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
