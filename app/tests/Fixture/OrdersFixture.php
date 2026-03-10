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
                'biginteger' => 1,
                'menu_item_id' => 1,
                'quantity' => 1,
                'email' => 'Lorem ipsum dolor sit amet',
                'delivery_address' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor ',
                'created_at' => '2026-03-10 13:58:03',
                'delivered_at' => '2026-03-10 13:58:03',
            ],
        ];
        parent::init();
    }
}
