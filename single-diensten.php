<?php

get_header();

while (have_posts()) : the_post();

    $page_title    = get_the_title();
    $background    = get_field('dienst_background') ?: 'light-blue';
    $show_reviews  = get_field('dienst_show_reviews');

    $show_breadcrumbs = get_field('dienst_show_breadcrumbs');
    if ($show_breadcrumbs === null || $show_breadcrumbs === '') {
        $show_breadcrumbs = true;
    }
    $show_breadcrumbs = (bool) $show_breadcrumbs;

    $hero_title    = get_field('dienst_title');
    $description   = get_field('dienst_description');
    $btn_text      = get_field('dienst_button_text');
    $btn_link      = get_field('dienst_button_link') ?: [];
    $img_id        = get_field('dienst_image');

    $hero_variant = $background === 'dark-blue' ? 'dark' : 'light';
    $bg_class     = ' dienst-hero-bg--' . esc_attr($background);

    $btn_url    = $btn_link['url']    ?? '#';
    $btn_target = $btn_link['target'] ?? '_self';

    $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'full') : '';
    $img_alt = $img_id ? (get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: $page_title) : '';

    $show_rekentool        = (bool) get_field('dienst_show_rekentool');
    $product_name          = get_field('dienst_product_name')       ?: '';
    $rekentool_tiers       = get_field('rekentool_tiers')           ?: [];
    $rekentool_btn_raw     = get_field('rekentool_button_link')     ?: [];
    $rekentool_btn_label   = get_field('rekentool_button_label')    ?: '';
    $rekentool_btn_variant = get_field('rekentool_button_variant')  ?: 'accent';
    $rekentool_btn_url     = $rekentool_btn_raw['url']    ?? '';
    $rekentool_btn_target  = $rekentool_btn_raw['target'] ?? '_self';

    $arrow_left   = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" focusable="false" fill="none"><path d="M19 12H5M11 18L5 12L11 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    $diensten_url = home_url('/diensten/');

?>

<main id="main-content" class="dienst-page">

    <div class="dienst-hero-bg<?= $bg_class; ?>">
    <div class="dienst-page__inner container">

        <div class="dienst-nav">

            <a class="dienst-back" href="<?= esc_url($diensten_url); ?>">
                <?= $arrow_left; ?>
                Terug naar alle diensten
            </a>

            <?php if ($show_breadcrumbs) : ?>
                <nav class="dienst-breadcrumbs" aria-label="Breadcrumb">
                    <a class="dienst-breadcrumbs__link" href="<?= esc_url(home_url('/')); ?>">Home</a>
                    <span class="dienst-breadcrumbs__sep" aria-hidden="true">/</span>
                    <span class="dienst-breadcrumbs__current" aria-current="page"><?= esc_html($page_title); ?></span>
                </nav>
            <?php endif; ?>

        </div>

        <hr class="dienst-divider">

        <div class="dienst-hero">

            <div class="dienst-hero__text">

                <?php if ($show_reviews) : ?>
                    <div class="dienst-hero__reviews">
                        <?php get_template_part('components/google-reviews', '', ['variant' => $hero_variant]); ?>
                    </div>
                <?php endif; ?>

                <?php if ($hero_title) : ?>
                    <h1 class="dienst-hero__title"><?= esc_html($hero_title); ?></h1>
                <?php endif; ?>

                <?php if ($description) : ?>
                    <div class="dienst-hero__description"><?= wp_kses_post($description); ?></div>
                <?php endif; ?>

                <?php if ($btn_text && $btn_url) : ?>
                    <?php get_template_part('components/button', '', [
                        'label'   => $btn_text,
                        'url'     => $btn_url,
                        'target'  => $btn_target,
                        'variant' => 'accent',
                        'icon'    => true,
                    ]); ?>
                <?php endif; ?>

            </div>

            <?php if ($img_url) : ?>
                <div class="dienst-hero__image-wrap">
                    <img
                        class="dienst-hero__image"
                        src="<?= esc_url($img_url); ?>"
                        alt="<?= esc_attr($img_alt); ?>"
                        width="635"
                        height="357"
                        loading="eager"
                    >
                </div>
            <?php endif; ?>

        </div><!-- .dienst-hero -->

    </div><!-- .dienst-page__inner -->
    </div><!-- .dienst-hero-bg -->

    <?php if ($show_rekentool) : ?>
        <?php get_template_part('components/rekentool', '', [
            'product_name'   => $product_name,
            'background'     => $hero_variant,
            'tiers'          => $rekentool_tiers,
            'button_label'   => $rekentool_btn_label,
            'button_url'     => $rekentool_btn_url,
            'button_target'  => $rekentool_btn_target,
            'button_variant' => $rekentool_btn_variant,
        ]); ?>
    <?php endif; ?>

    <?php if (has_blocks(get_the_content())) : ?>
        <div id="page-content" class="page-content">
            <?php the_content(); ?>
        </div>
    <?php endif; ?>

</main>

<?php
endwhile;

get_footer();
