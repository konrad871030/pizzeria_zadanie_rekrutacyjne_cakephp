<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MenuItemsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MenuItemsTable Test Case
 */
class MenuItemsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MenuItemsTable
     */
    protected $MenuItems;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.MenuItems',
        'app.Orders',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MenuItems') ? [] : ['className' => MenuItemsTable::class];
        $this->MenuItems = $this->getTableLocator()->get('MenuItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->MenuItems);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\MenuItemsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
