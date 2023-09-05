<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PathwaysStepsFixture
 */
class PathwaysStepsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'step_id' => 1,
                'pathway_id' => 1,
                'sortorder' => 1,
                'date_start' => '2023-09-05 00:00:24',
                'date_complete' => '2023-09-05 00:00:24',
            ],
        ];
        parent::init();
    }
}
