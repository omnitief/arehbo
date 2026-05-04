<?php

get_header();

while (have_posts()) : the_post();

    $page_title  = get_the_title();
    $background  = get_field('cursus_background') ?: 'light-blue';
    $hero_title  = get_field('cursus_title') ?: $page_title;
    $description = get_field('cursus_description');
    $img_id      = get_field('cursus_image');

    $kosten      = get_field('kosten');
    $locatie     = get_field('locatie');
    $duur        = get_field('duur');
    $inschrijven = get_field('inschrijven_url');
    $el_label    = get_field('eigen_locatie_label') ?: 'OP EIGEN LOCATIE';
    $el_link     = get_field('eigen_locatie_link') ?: [];
    $el_url      = $el_link['url']    ?? '#';
    $el_target   = $el_link['target'] ?? '_self';

    $show_breadcrumbs = get_field('show_breadcrumbs');
    if ($show_breadcrumbs === null || $show_breadcrumbs === '') {
        $show_breadcrumbs = true;
    }
    $show_breadcrumbs = (bool) $show_breadcrumbs;

    $bg_class = ' cursus-hero-bg--' . esc_attr($background);

    if (!$img_id) {
        $img_id = get_post_thumbnail_id();
    }

    $img_url = $img_id ? wp_get_attachment_image_url($img_id, 'full') : '';
    $img_alt = $img_id ? (get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: $page_title) : '';

    $arrow_left    = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" focusable="false" fill="none"><path d="M19 12H5M11 18L5 12L11 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    $cursussen_url = home_url('/cursussen/');

?>

<main id="main-content" class="cursus-page">

    <div class="cursus-hero-bg<?= $bg_class; ?>">
    <div class="cursus-page__inner container">

        <div class="cursus-nav">

            <a class="cursus-back" href="<?= esc_url($cursussen_url); ?>">
                <?= $arrow_left; ?>
                Terug naar alle cursussen
            </a>

            <?php if ($show_breadcrumbs) : ?>
                <nav class="cursus-breadcrumbs" aria-label="Breadcrumb">
                    <a class="cursus-breadcrumbs__link" href="<?= esc_url(home_url('/')); ?>">Home</a>
                    <span class="cursus-breadcrumbs__sep" aria-hidden="true">/</span>
                    <span class="cursus-breadcrumbs__current" aria-current="page"><?= esc_html($page_title); ?></span>
                </nav>
            <?php endif; ?>

        </div>

        <hr class="cursus-divider">

        <div class="cursus-hero">

            <div class="cursus-hero__text">

                <?php if ($hero_title) : ?>
                    <h1 class="cursus-hero__title"><?= esc_html($hero_title); ?></h1>
                <?php endif; ?>

                <?php if ($description) : ?>
                    <div class="cursus-hero__description"><?= wp_kses_post($description); ?></div>
                <?php endif; ?>

            </div>

            <?php if ($img_url) : ?>
                <div class="cursus-hero__image-wrap">
                    <img
                        class="cursus-hero__image"
                        src="<?= esc_url($img_url); ?>"
                        alt="<?= esc_attr($img_alt); ?>"
                        width="635"
                        height="357"
                        loading="eager"
                    >
                </div>
            <?php endif; ?>

        </div><!-- .cursus-hero -->

    </div><!-- .cursus-page__inner -->
    </div><!-- .cursus-hero-bg -->

    <?php if ($kosten || $locatie || $duur || $inschrijven) : ?>
        <div class="cursus-cards cursus-cards--<?= esc_attr($background); ?><?= $background === 'dark-blue' ? ' cursus-cards--dark' : ''; ?>">
            <div class="container">

                <article class="cursus-card">

                    <div class="cursus-card__left">
                        <div class="cursus-card__meta">
                            <?php if ($kosten) : ?>
                                <div class="cursus-card__meta-item">
                                    <span class="cursus-card__meta-label">Kosten (excl. BTW):</span>
                                    <span class="cursus-card__meta-value"><?= esc_html($kosten); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($locatie) : ?>
                                <div class="cursus-card__meta-item">
                                    <span class="cursus-card__meta-label">Locatie:</span>
                                    <span class="cursus-card__meta-value"><?= esc_html($locatie); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($duur) : ?>
                                <div class="cursus-card__meta-item">
                                    <span class="cursus-card__meta-label">Duur:</span>
                                    <span class="cursus-card__meta-value"><?= esc_html($duur); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="cursus-card__right">
                        <?php if ($inschrijven) : ?>
                            <?php get_template_part('components/button', '', [
                                'label'   => 'DIRECT INSCHRIJVEN',
                                'url'     => $inschrijven,
                                'target'  => '_blank',
                                'variant' => 'accent',
                                'icon'    => true,
                            ]); ?>
                        <?php endif; ?>

                        <?php if ($el_url && $el_url !== '#') : ?>
                            <?php get_template_part('components/button', '', [
                                'label'   => $el_label,
                                'url'     => $el_url,
                                'target'  => $el_target,
                                'variant' => 'outline',
                                'icon'    => false,
                            ]); ?>
                        <?php endif; ?>
                    </div>

                </article>

            </div>
        </div>
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
