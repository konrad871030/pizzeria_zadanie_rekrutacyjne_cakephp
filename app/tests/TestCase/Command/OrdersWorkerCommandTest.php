<?php
declare(strict_types=1);

namespace App\Test\TestCase\Command;

use App\Command\OrdersWorkerCommand;
use Cake\ORM\Table;
use Cake\Console\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Command\OrdersWorkerCommand Test Case
 *
 * @link \App\Command\OrdersWorkerCommand
 */
class OrdersWorkerCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

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

    public function testDefaultName(): void
    {
        $this->assertSame('orders-worker', OrdersWorkerCommand::defaultName());
    }

    public function testGetDescription(): void
    {
        $this->assertSame(
            'Ciagla obsluga kolejki zamowien pizzerii.',
            OrdersWorkerCommand::getDescription()
        );
    }

    public function testExecuteProcessesQueuedOrderInOnceMode(): void
    {
        $this->exec('orders-worker --once --threshold 999');
        $this->assertExitSuccess();
        $this->assertOutputContains('Obsluzono zamowienie #1.');

        /** @var \App\Model\Entity\Order $order */
        $order = $this->ordersTable->get(1);
        $this->assertSame('delivered', $order->status);
        $this->assertNotNull($order->delivered_at);
    }

    public function testExecuteOutputsInfoWhenQueueIsEmpty(): void
    {
        /** @var \App\Model\Entity\Order $order */
        $order = $this->ordersTable->get(1);
        $order->status = 'delivered';
        $order->delivered_at = new \Cake\I18n\DateTime();
        $this->ordersTable->saveOrFail($order);

        $this->exec('orders-worker --once --threshold 999');
        $this->assertExitSuccess();
        $this->assertOutputContains('Brak zamowien do obslugi.');
    }

    public function testExecuteLogsLongQueueWarningWhenThresholdReached(): void
    {
        $this->exec('orders-worker --once --threshold 1');
        $this->assertExitSuccess();
        $this->assertErrorContains('Dluga kolejka zamowien: 1 zamowien oczekuje na realizacje.');
    }
}
