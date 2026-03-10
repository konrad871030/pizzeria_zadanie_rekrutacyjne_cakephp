<?php
/**
 * @var \App\Model\Entity\Order $order
 * @var \Cake\Collection\CollectionInterface<\App\Model\Entity\MenuItem> $menuItems
 */
?>
<div class="offcanvas offcanvas-end" tabindex="-1" id="orderOffcanvas" aria-labelledby="orderOffcanvasLabel">
    <div class="offcanvas-header">
        <h2 class="offcanvas-title h5" id="orderOffcanvasLabel">Nowe zamowienie</h2>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?= $this->Form->create($order, ['class' => 'row g-3']) ?>
        <div class="col-12">
            <?= $this->Form->control('menu_item_id', [
                'id' => 'order-menu-item-id',
                'label' => 'Rodzaj pizzy',
                'options' => $menuItems->combine('id', function ($item) {
                    return $item->name . ' - ' . number_format($item->price_cents / 100, 2, ',', ' ') . ' PLN';
                })->toArray(),
                'class' => 'form-select',
                'empty' => 'Wybierz pizze',
            ]) ?>
        </div>
        <div class="col-12">
            <?= $this->Form->control('quantity', [
                'label' => 'Ilosc',
                'type' => 'number',
                'min' => 1,
                'value' => 1,
                'class' => 'form-control',
            ]) ?>
        </div>
        <div class="col-12">
            <?= $this->Form->control('email', [
                'label' => 'Adres e-mail',
                'type' => 'email',
                'class' => 'form-control',
            ]) ?>
        </div>
        <div class="col-12">
            <?= $this->Form->control('delivery_address', [
                'label' => 'Adres dostawy',
                'class' => 'form-control',
            ]) ?>
        </div>
        <div class="col-12">
            <button class="btn btn-success w-100" type="submit">Zloz zamowienie</button>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
