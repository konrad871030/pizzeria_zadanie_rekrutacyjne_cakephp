const orderOffcanvasEl = document.getElementById('orderOffcanvas');
const orderMenuItemSelect = document.getElementById('order-menu-item-id');
const queuedCountEl = document.getElementById('queued-count');
const etaMinutesEl = document.getElementById('eta-minutes');

if (orderOffcanvasEl && orderMenuItemSelect) {
    const orderOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(orderOffcanvasEl);

    document.querySelectorAll('.order-from-card').forEach((button) => {
        button.addEventListener('click', () => {
            orderMenuItemSelect.value = button.dataset.menuItemId;
            orderOffcanvas.show();
        });
    });
}

const updateStats = async () => {
    if (!queuedCountEl || !etaMinutesEl) {
        return;
    }

    try {
        const response = await fetch('/queue-stats', { headers: { Accept: 'application/json' } });
        if (!response.ok) {
            return;
        }

        const data = await response.json();
        queuedCountEl.textContent = `W kolejce: ${data.queued_count}`;
        etaMinutesEl.textContent = `ETA: ${data.eta_minutes} min`;
    } catch (e) {
        // Celowo ignorujemy chwilowe problemy sieciowe.
    }
};

setInterval(updateStats, 5000);
