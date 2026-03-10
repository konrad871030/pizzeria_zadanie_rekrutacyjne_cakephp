<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateMenuItemsAndOrders extends AbstractMigration
{
    public function up(): void
    {
        if (!$this->hasTable('menu_items')) {
            $this->table('menu_items', ['id' => 'id'])
                ->addColumn('name', 'string', ['limit' => 120, 'null' => false])
                ->addColumn('price_cents', 'integer', ['null' => false])
                ->addColumn('ingredients', 'string', ['limit' => 500, 'null' => false, 'default' => ''])
                ->addColumn('image_name', 'string', ['limit' => 255, 'null' => false, 'default' => ''])
                ->create();
        }

        if (!$this->hasTable('orders')) {
            $this->table('orders', ['id' => 'biginteger'])
                ->addColumn('menu_item_id', 'integer', ['null' => false])
                ->addColumn('quantity', 'integer', ['null' => false])
                ->addColumn('email', 'string', ['limit' => 180, 'null' => false])
                ->addColumn('delivery_address', 'string', ['limit' => 255, 'null' => false])
                ->addColumn('status', 'string', ['limit' => 20, 'null' => false])
                ->addColumn('created_at', 'datetime', ['null' => false])
                ->addColumn('delivered_at', 'datetime', ['null' => true, 'default' => null])
                ->addIndex(['status', 'created_at'], ['name' => 'idx_orders_status_created_at'])
                ->addForeignKey('menu_item_id', 'menu_items', 'id', [
                    'constraint' => 'fk_orders_menu_item',
                    'delete' => 'RESTRICT',
                    'update' => 'CASCADE',
                ])
                ->create();
        }

        $menuItems = [
            ['name' => 'Margherita', 'price_cents' => 2800, 'ingredients' => 'Sos pomidorowy, mozzarella, bazylia', 'image_name' => 'margherita.png'],
            ['name' => 'Capricciosa', 'price_cents' => 3400, 'ingredients' => 'Sos pomidorowy, mozzarella, szynka, pieczarki', 'image_name' => 'capricciosa.png'],
            ['name' => 'Pepperoni', 'price_cents' => 3600, 'ingredients' => 'Sos pomidorowy, mozzarella, pepperoni', 'image_name' => 'pepperoni.png'],
            ['name' => 'Diavola', 'price_cents' => 3700, 'ingredients' => 'Sos pomidorowy, mozzarella, salami piccante, chili', 'image_name' => 'diavola.png'],
            ['name' => 'Funghi', 'price_cents' => 3300, 'ingredients' => 'Sos pomidorowy, mozzarella, pieczarki', 'image_name' => 'funghi.png'],
            ['name' => 'Quattro Formaggi', 'price_cents' => 3900, 'ingredients' => 'Mozzarella, gorgonzola, parmezan, provolone', 'image_name' => 'quattro_formaggi.png'],
            ['name' => 'Hawajska', 'price_cents' => 3500, 'ingredients' => 'Sos pomidorowy, mozzarella, szynka, ananas', 'image_name' => 'hawajska.png'],
            ['name' => 'Wiejska', 'price_cents' => 4100, 'ingredients' => 'Sos pomidorowy, mozzarella, kielbasa, cebula, ogorek', 'image_name' => 'wiejska.png'],
        ];

        $table = $this->table('menu_items');
        $existing = (int)$this->fetchRow('SELECT COUNT(*) AS count FROM menu_items')['count'];
        if ($existing === 0) {
            $table->insert($menuItems)->saveData();
        }
    }

    public function down(): void
    {
        if ($this->hasTable('orders')) {
            $this->table('orders')->drop()->save();
        }
        if ($this->hasTable('menu_items')) {
            $this->table('menu_items')->drop()->save();
        }
    }
}
