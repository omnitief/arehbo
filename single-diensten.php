<?php

get_header();

while (have_posts()) : the_post();

    $page_title    = get_the_title();
    $background    = get_field('dienst_background') ?: 'light-blue';
    $show_reviews  = get_field('dienst_show_reviews');
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

?>

<main id="main-content" class="dienst-page">

    <div class="dienst-hero-bg<?= $bg_class; ?>">
    <div class="dienst-page__inner container">

        <nav class="dienst-breadcrumbs" aria-label="Breadcrumb">
            <a class="dienst-breadcrumbs__link" href="<?= esc_url(home_url('/')); ?>">Home</a>
            <span class="dienst-breadcrumbs__sep" aria-hidden="true">/</span>
            <span class="dienst-breadcrumbs__current" aria-current="page"><?= esc_html($page_title); ?></span>
        </nav>

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

    <?php if (has_blocks(get_the_content())) : ?>
        <div id="page-content" class="page-content">
            <?php the_content(); ?>
        </div>
    <?php endif; ?>

</main>

<?php
endwhile;

get_footer();
