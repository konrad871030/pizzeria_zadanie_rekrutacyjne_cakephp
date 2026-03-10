<?php
/**
 * @var \Cake\Collection\CollectionInterface<\App\Model\Entity\MenuItem> $menuItems
 * @var \App\Model\Entity\Order $order
 * @var int $queuedCount
 * @var int $etaMinutes
 */
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<?= $this->Html->css('frontend') ?>

<div class="container py-4">
    <h2 class="h5 mb-3">Menu</h2>
    <div class="row g-3">
        <?php foreach ($menuItems as $item): ?>
            <?= $this->element('menu_item', ['item' => $item]) ?>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->element('order_form', ['order' => $order, 'menuItems' => $menuItems]) ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->Html->script('frontend') ?>
