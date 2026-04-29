<?php

$slides = $args['slides'] ?? [];
$layout = $args['layout'] ?? 'photo';

if (empty($slides)) {
    return;
}

?>

<div class="slider slider--<?= esc_attr($layout); ?>">

    <div class="swiper">
        <div class="swiper-wrapper">
            <?php foreach ($slides as $slide_html) : ?>
                <div class="swiper-slide"><?= $slide_html; ?></div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="slider-nav">
        <div class="slider-nav__arrows">
            <button class="slider-nav__btn slider-nav__btn--prev" aria-label="<?php esc_attr_e('Previous slide', 'arehbo-theme'); ?>">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                    <path d="M16 10H4M4 10L9 5M4 10L9 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <button class="slider-nav__btn slider-nav__btn--next" aria-label="<?php esc_attr_e('Next slide', 'arehbo-theme'); ?>">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                    <path d="M4 10H16M16 10L11 5M16 10L11 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
        <div class="slider-nav__progress"></div>
    </div>

</div>
