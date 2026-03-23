<?php
/*
 * Template Name: Standard
 */

get_header();

$media       = get_field('hero_bg_media');
$title       = get_field('hero_title');
$cards       = get_field('hero_cards') ?: [];
$show_scroll = get_field('hero_show_scroll');

$media_url  = $media['url']       ?? '';
$media_mime = $media['mime_type'] ?? '';
$is_video   = str_starts_with($media_mime, 'video/');
$is_image   = str_starts_with($media_mime, 'image/');
$cards      = array_slice($cards, 0, 3);

?>

<main id="main-content">

    <section class="page-hero"
        <?php if ($is_image) : ?>
            style="background-image: url('<?= esc_url($media_url); ?>');"
        <?php endif; ?>>

        <?php if ($is_video) : ?>
            <video class="page-hero__video" autoplay muted loop playsinline>
                <source src="<?= esc_url($media_url); ?>" type="<?= esc_attr($media_mime); ?>">
            </video>
        <?php endif; ?>

        <div class="page-hero__inner container">

            <?php if ($title) : ?>
                <h1 class="page-hero__title"><?= esc_html($title); ?></h1>
            <?php endif; ?>

            <?php if (!empty($cards)) : ?>
                <div class="page-hero__cards">
                    <?php foreach ($cards as $card) :
                        $card_title  = $card['card_title'] ?? '';
                        $card_link   = $card['card_link'] ?? [];
                        $link_url    = $card_link['url'] ?? '#';
                        $link_target = $card_link['target'] ?? '_self';
                        if (empty($card_title)) continue;
                    ?>
                        <a class="ph-card"
                            href="<?= esc_url($link_url); ?>"
                            <?php if ($link_target === '_blank') echo 'target="_blank" rel="noopener noreferrer"'; ?>
                        >
                            <span class="ph-card__title"><?= esc_html($card_title); ?></span>
                            <span class="ph-card__btn-wrap">
                                <span class="ph-card__btn-label">BEKIJKEN</span>
                                <span class="ph-card__arrow" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none">
                                        <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($show_scroll) : ?>
                <div class="page-hero__scroll-row">
                    <div class="page-hero__scroll">
                        <span class="page-hero__scroll-label">Scroll verder</span>
                        <a class="page-hero__scroll-btn"
                            href="#page-content"
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

    <?php while (have_posts()) : the_post(); ?>
        <div id="page-content" class="page-content">
            <?php the_content(); ?>
        </div>
    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
