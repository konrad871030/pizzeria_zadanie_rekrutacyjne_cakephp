<?php
/**
 * @var \App\Model\Entity\MenuItem $item
 */
?>
<div class="col-12 col-md-6 col-lg-4">
    <div class="card h-100 shadow-sm">
        <img
            src="<?= h($this->Url->build('/img/menu/' . rawurlencode($item->image_name))) ?>"
            class="card-img-top menu-card-image"
            alt="<?= h($item->name) ?>"
        >
        <div class="card-body d-flex flex-column">
            <h3 class="h6 card-title mb-1"><?= h($item->name) ?></h3>
            <p class="small text-muted mb-3"><?= h($item->ingredients) ?></p>
            <div class="mt-auto d-flex justify-content-between align-items-center">
                <p class="fw-bold mb-0"><?= number_format($item->price_cents / 100, 2, ',', ' ') ?> PLN</p>
                <button
                    class="btn btn-success btn-sm order-from-card"
                    type="button"
                    data-menu-item-id="<?= (int)$item->id ?>"
                >
                    Zamow
                </button>
            </div>
        </div>
    </div>
</div>
