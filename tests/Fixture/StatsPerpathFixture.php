<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StatsPerpathFixture
 */
class StatsPerpathFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'stats_perpath';
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
                'pathways_id' => 1,
                'steps' => 1,
                'activities' => 1,
                'follows' => 1,
                'launches' => 1,
                'created' => '2024-03-24 03:58:19',
            ],
        ];
        parent::init();
    }
}
