(function () {
    'use strict';

    function parseTiers(bar) {
        var raw = bar.getAttribute('data-tiers') || '[]';
        try {
            var tiers = JSON.parse(raw);
            return Array.isArray(tiers) ? tiers : [];
        } catch (e) {
            return [];
        }
    }

    function getUnitPrice(tiers, qty) {
        for (var i = 0; i < tiers.length; i++) {
            if (qty >= tiers[i].min && qty <= tiers[i].max) return tiers[i].price;
        }
        return tiers.length ? tiers[tiers.length - 1].price : 0;
    }

    function fmt(n) {
        var s = n.toFixed(2).replace('.', ',');
        return '\u20ac' + s;
    }

    document.querySelectorAll('.rekentool__bar[data-tiers]').forEach(function (bar) {
        var tiers = parseTiers(bar);
        if (!tiers.length) return;

        var qty          = 1;
        var countEl      = bar.querySelector('.rekentool__count');
        var currentPrice = bar.querySelector('.rekentool__current-price');
        var btnDec       = bar.querySelector('.rekentool__btn--decrease');
        var btnInc       = bar.querySelector('.rekentool__btn--increase');

        function render() {
            var price = getUnitPrice(tiers, qty);
            if (countEl) countEl.textContent = qty;
            if (currentPrice) currentPrice.textContent = fmt(price);
            if (btnDec) btnDec.disabled = qty <= 1;
        }

        if (btnDec) btnDec.addEventListener('click', function () { if (qty > 1)   { qty--; render(); } });
        if (btnInc) btnInc.addEventListener('click', function () { if (qty < 999) { qty++; render(); } });

        render();
    });
}());

