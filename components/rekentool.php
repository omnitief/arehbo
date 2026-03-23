<?php

$product_name   = $args['product_name']   ?? '';
$background     = $args['background']     ?? 'light';
$tiers          = $args['tiers']          ?? [];
$button_label   = $args['button_label']   ?? '';
$button_url     = $args['button_url']     ?? '';
$button_target  = $args['button_target']  ?? '_self';
$button_variant = $args['button_variant'] ?? 'accent';

$is_dark = $background === 'dark';

$lowest_price_fmt = '';
if (!empty($tiers)) {
    $last = end($tiers);
    $val  = floatval(str_replace(',', '.', $last['tier_price'] ?? '0'));
    $lowest_price_fmt = ($val == floor($val))
        ? '€' . number_format($val, 0, ',', '.') . ',-'
        : '€' . number_format($val, 2, ',', '.');
}

$js_tiers = [];
foreach ($tiers as $t) {
    $js_tiers[] = [
        'min'   => intval($t['tier_min']   ?? 1),
        'max'   => intval($t['tier_max']   ?? 999),
        'price' => floatval(str_replace(',', '.', $t['tier_price'] ?? '0')),
    ];
}

?>

<section class="rekentool<?= $is_dark ? ' rekentool--dark' : ' rekentool--light'; ?>">
    <div class="container">
        <div class="rekentool__wrapper">
            <div class="container">

                <div class="rekentool__bar">

                    <div class="rekentool__left">
                        <span class="rekentool__title">Bereken uw prijs:</span>
                        <?php if ($lowest_price_fmt) : ?>
                            <span class="rekentool__vanaf">vanaf <?= esc_html($lowest_price_fmt); ?> per stuk</span>
                        <?php endif; ?>
                    </div>

                    <div class="rekentool__qty-wrap">
                        <button class="rekentool__btn rekentool__btn--decrease" type="button" aria-label="Verminder aantal">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" aria-hidden="true">
                                <path d="M5 12h14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <div class="rekentool__qty-wrapper">
                            <span class="rekentool__count" aria-live="polite">1</span>
                            <?php if ($product_name) : ?>
                                <span class="rekentool__product"><?= esc_html($product_name); ?></span>
                            <?php endif; ?>
                        </div>
                        <button class="rekentool__btn rekentool__btn--increase" type="button" aria-label="Verhoog aantal">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" aria-hidden="true">
                                <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                            </svg>
                        </button>
                    </div>

                    <div class="rekentool__right">
                        <span class="rekentool__current-price" aria-live="polite">-</span>
                        <span class="rekentool__per-stuk">per stuk</span>
                    </div>

                    <?php if ($button_label && $button_url) : ?>
                        <div class="rekentool__btn-wrap">
                            <?php get_template_part('components/button', '', [
                                'label'   => $button_label,
                                'url'     => $button_url,
                                'target'  => $button_target,
                                'variant' => $button_variant,
                                'icon'    => true,
                            ]); ?>
                        </div>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>
</section>

<script>
(function () {
    var tiers = <?= json_encode($js_tiers); ?>;

    function getUnitPrice(qty) {
        for (var i = 0; i < tiers.length; i++) {
            if (qty >= tiers[i].min && qty <= tiers[i].max) return tiers[i].price;
        }
        return tiers.length ? tiers[tiers.length - 1].price : 0;
    }

    function fmt(n) {
        var s = n.toFixed(2).replace('.', ',');
        return '\u20ac' + s;
    }

    document.querySelectorAll('.rekentool__bar').forEach(function (bar) {
        var qty          = 1;
        var countEl      = bar.querySelector('.rekentool__count');
        var currentPrice = bar.querySelector('.rekentool__current-price');
        var btnDec       = bar.querySelector('.rekentool__btn--decrease');
        var btnInc       = bar.querySelector('.rekentool__btn--increase');

        function render() {
            var price = getUnitPrice(qty);
            countEl.textContent = qty;
            if (currentPrice) currentPrice.textContent = fmt(price);
            btnDec.disabled = qty <= 1;
        }

        btnDec.addEventListener('click', function () { if (qty > 1)   { qty--; render(); } });
        btnInc.addEventListener('click', function () { if (qty < 999) { qty++; render(); } });

        render();
    });
}());
</script>
