<?php

$layout    = get_field('layout') ?: 'hero';
$bg_id     = get_field('background_image');
$video_id  = get_field('background_video');
$title     = get_field('title');
$cards     = get_field('cards') ?: [];
$scroll    = get_field('scroll_target');

$bg_url    = $bg_id    ? wp_get_attachment_image_url($bg_id, 'full') : '';
$video_url = $video_id ? wp_get_attachment_url($video_id)            : '';
$cards     = array_slice($cards, 0, 3);

?>

<div class="hero-banner hero-banner--<?= esc_attr($layout); ?>">

    <?php if ($layout === 'hero') : ?>

        <section class="hb-hero"
            <?php if ($bg_url && !$video_url) : ?>
                style="background-image: url('<?= esc_url($bg_url); ?>');"
            <?php endif; ?>>

            <?php if ($video_url) : ?>
                <video class="hb-hero__video" autoplay muted loop playsinline>
                    <source src="<?= esc_url($video_url); ?>" type="video/<?= esc_attr(pathinfo($video_url, PATHINFO_EXTENSION)); ?>">
                </video>
            <?php endif; ?>

            <div class="hb-hero__inner container">

                <?php if ($title) : ?>
                    <h1 class="hb-hero__title"><?= esc_html($title); ?></h1>
                <?php endif; ?>

                <?php if (!empty($cards)) : ?>
                    <div class="hb-hero__cards">
                        <?php foreach ($cards as $card) :
                            $card_title  = $card['card_title'] ?? '';
                            $card_link   = $card['card_link'] ?? [];
                            $link_url    = $card_link['url'] ?? '#';
                            $link_target = $card_link['target'] ?? '_self';
                            if (empty($card_title)) continue;
                        ?>
                            <a class="hb-card"
                                href="<?= esc_url($link_url); ?>"
                                <?php if ($link_target === '_blank') echo 'target="_blank" rel="noopener noreferrer"'; ?>
                            >
                                <span class="hb-card__title"><?= esc_html($card_title); ?></span>
                                <span class="hb-card__arrow" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none">
                                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($scroll) : ?>
                    <div class="hb-scroll-row">
                        <div class="hb-scroll">
                            <span class="hb-scroll__label">Scroll verder</span>
                            <a class="hb-scroll__btn"
                                href="#<?= esc_attr(ltrim($scroll, '#')); ?>"
                                aria-label="Scroll verder naar inhoud"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" aria-hidden="true">
                                    <path d="M12 5v14M5 13l7 7 7-7" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </section>

        <?php get_template_part('components/colorbar'); ?>

    <?php endif; ?>

</div>
