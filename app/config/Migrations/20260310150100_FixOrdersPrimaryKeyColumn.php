<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class FixOrdersPrimaryKeyColumn extends AbstractMigration
{
    public function up(): void
    {
        if (!$this->hasTable('orders')) {
            return;
        }

        $ordersTable = $this->table('orders');
        if ($ordersTable->hasColumn('biginteger') && !$ordersTable->hasColumn('id')) {
            $this->execute('ALTER TABLE orders CHANGE biginteger id BIGINT AUTO_INCREMENT');
        }
    }

    public function down(): void
    {
        if (!$this->hasTable('orders')) {
            return;
        }

        $ordersTable = $this->table('orders');
        if ($ordersTable->hasColumn('id') && !$ordersTable->hasColumn('biginteger')) {
            $this->execute('ALTER TABLE orders CHANGE id biginteger INT AUTO_INCREMENT');
        }
    }
}
