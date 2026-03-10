<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use Cake\ORM\Table;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\FrontendController Test Case
 *
 * @link \App\Controller\FrontendController
 */
class FrontendControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.MenuItems',
        'app.Orders',
    ];

    protected Table $ordersTable;

    protected function setUp(): void
    {
        parent::setUp();
        $this->ordersTable = $this->getTableLocator()->get('Orders');
    }

    public function testIndex(): void
    {
        $this->get('/');
        $this->assertResponseOk();
        $this->assertResponseContains('Menu');
        $this->assertResponseContains('Nowe zamowienie');
    }

    public function testQueueStats(): void
    {
        $this->get('/queue-stats');
        $this->assertResponseOk();
        $this->assertContentType('application/json');
        $this->assertResponseContains('"queued_count":1');
        $this->assertResponseContains('"eta_minutes":10');
    }

    public function testCreateOrderWithPost(): void
    {
        $this->enableCsrfToken();
        $beforeCount = $this->ordersTable->find()->count();

        $this->post('/', [
            'menu_item_id' => 1,
            'quantity' => 2,
            'email' => 'integration@test.pl',
            'delivery_address' => 'Testowa 5, Krakow',
        ]);

        $this->assertResponseSuccess();
        $this->assertRedirect('/');
        $afterCount = $this->ordersTable->find()->count();
        $this->assertSame($beforeCount + 1, $afterCount);

        $last = $this->ordersTable->find()->orderByDesc('id')->firstOrFail();
        $this->assertSame('queued', $last->status);
    }
}
