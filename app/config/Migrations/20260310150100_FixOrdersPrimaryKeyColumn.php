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
            $ordersTable->renameColumn('biginteger', 'id')->update();
        }
    }

    public function down(): void
    {
        if (!$this->hasTable('orders')) {
            return;
        }

        $ordersTable = $this->table('orders');
        if ($ordersTable->hasColumn('id') && !$ordersTable->hasColumn('biginteger')) {
            $ordersTable->renameColumn('id', 'biginteger')->update();
        }
    }
}
