<?php
declare(strict_types=1);

namespace App\Controller;

class FrontendController extends AppController
{
    public function index()
    {
        $menuItemsTable = $this->fetchTable('MenuItems');
        $ordersTable = $this->fetchTable('Orders');

        $menuItems = $menuItemsTable->find()
            ->orderByAsc('name')
            ->all();

        $order = $ordersTable->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['status'] = 'queued';
            $data['created_at'] = new \DateTimeImmutable();

            $order = $ordersTable->patchEntity($order, $data);
            if ($ordersTable->save($order)) {
                $this->Flash->success('Zamowienie zostalo przyjete.');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Nie udalo sie zapisac zamowienia.');
        }

        $queuedCount = $ordersTable->find()
            ->where(['status' => 'queued'])
            ->count();
        $etaMinutes = $this->calculateEtaMinutes($queuedCount);

        $this->set(compact('menuItems', 'order', 'queuedCount', 'etaMinutes'));
    }

    public function queueStats()
    {
        $this->request->allowMethod(['get']);
        $ordersTable = $this->fetchTable('Orders');
        $queuedCount = $ordersTable->find()->where(['status' => 'queued'])->count();
        $payload = [
            'queued_count' => $queuedCount,
            'eta_minutes' => $this->calculateEtaMinutes($queuedCount),
        ];

        return $this->response
            ->withType('application/json')
            ->withStringBody((string)json_encode($payload));
    }

    private function calculateEtaMinutes(int $queuedCount): int
    {
        return $queuedCount * 10;
    }
}
