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
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false">
                    <path fill="currentColor" d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/>
                </svg>
            </button>
            <button class="slider-nav__btn slider-nav__btn--next" aria-label="<?php esc_attr_e('Next slide', 'arehbo-theme'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false">
                    <path fill="currentColor" d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/>
                </svg>
            </button>
        </div>
        <div class="slider-nav__progress"></div>
    </div>

</div>
