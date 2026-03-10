<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\I18n\DateTime;
use Cake\Log\Log;
use Cake\ORM\Table;

/**
 * OrdersWorker command.
 */
class OrdersWorkerCommand extends Command
{
    protected Table $ordersTable;

    /**
     * Get the default command name.
     *
     * @return string
     */
    public static function defaultName(): string
    {
        return 'orders-worker';
    }

    /**
     * Get the command description.
     *
     * @return string
     */
    public static function getDescription(): string
    {
        return 'Ciagla obsluga kolejki zamowien pizzerii.';
    }

    /**
     * Hook method for defining this command's option parser.
     *
     * @link https://book.cakephp.org/5/en/console-commands/commands.html#defining-arguments-and-options
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        return parent::buildOptionParser($parser)
            ->setDescription(static::getDescription())
            ->addOption('once', [
                'boolean' => true,
                'help' => 'Przetworz tylko jedno zamowienie i zakoncz.',
            ])
            ->addOption('interval', [
                'short' => 'i',
                'default' => 600,
                'help' => 'Interwal petli w sekundach (domyslnie 600).',
            ])
            ->addOption('threshold', [
                'short' => 't',
                'default' => 5,
                'help' => 'Prog dlugiej kolejki do logowania ostrzezenia.',
            ]);
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return int|null|void The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $this->ordersTable = $this->fetchTable('Orders');
        $once = (bool)$args->getOption('once');
        $interval = max((int)$args->getOption('interval'), 1);
        $threshold = max((int)$args->getOption('threshold'), 1);

        $io->success(sprintf(
            'Start workera zamowien (once=%s, interval=%ds, threshold=%d).',
            $once ? 'true' : 'false',
            $interval,
            $threshold
        ));

        do {
            $this->processOneOrder($io, $threshold);

            if ($once) {
                break;
            }
            sleep($interval);
        } while (true);

        return self::CODE_SUCCESS;
    }

    private function processOneOrder(ConsoleIo $io, int $threshold): void
    {
        $queuedCount = $this->ordersTable->find()
            ->where(['status' => 'queued'])
            ->count();

        if ($queuedCount >= $threshold) {
            $message = sprintf(
                'Dluga kolejka zamowien: %d zamowien oczekuje na realizacje.',
                $queuedCount
            );
            Log::warning($message);
            $io->warning($message);
        }

        $nextOrder = $this->ordersTable->find()
            ->where(['status' => 'queued'])
            ->orderByAsc('created_at')
            ->first();

        if ($nextOrder === null) {
            $io->out('Brak zamowien do obslugi.');
            return;
        }

        $nextOrder->status = 'delivered';
        $nextOrder->delivered_at = DateTime::now();

        if ($this->ordersTable->save($nextOrder)) {
            $io->success(sprintf('Obsluzono zamowienie #%d.', (int)$nextOrder->id));
            return;
        }

        $io->error(sprintf('Nie udalo sie obsluzyc zamowienia #%d.', (int)$nextOrder->id));
    }
}
