<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdersFixture
 */
class OrdersFixture extends TestFixture
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
                'menu_item_id' => 1,
                'quantity' => 2,
                'email' => 'client@example.com',
                'delivery_address' => 'Testowa 1, Warszawa',
                'status' => 'queued',
                'created_at' => '2026-03-10 13:58:03',
                'delivered_at' => null,
            ],
        ];
        parent::init();
    }
}
