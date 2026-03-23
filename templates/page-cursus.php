<?php
/*
 * Template Name: Cursus
 */

get_header();

$page_title  = get_the_title();
$background  = get_field('cursus_background') ?: 'light-blue';
$hero_title  = get_field('cursus_title');
$description = get_field('cursus_description');
$img_id      = get_field('cursus_image');
$cursussen   = get_field('cursussen') ?: [];

$bg_class = ' cursus-hero-bg--' . esc_attr($background);

$img_url = $img_id ? wp_get_attachment_image_url($img_id, 'full') : '';
$img_alt = $img_id ? (get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: $page_title) : '';

?>

<main id="main-content" class="cursus-page">

    <div class="cursus-hero-bg<?= $bg_class; ?>">
    <div class="cursus-page__inner container">

        <nav class="cursus-breadcrumbs" aria-label="Breadcrumb">
            <a class="cursus-breadcrumbs__link" href="<?= esc_url(home_url('/')); ?>">Home</a>
            <span class="cursus-breadcrumbs__sep" aria-hidden="true">/</span>
            <span class="cursus-breadcrumbs__current" aria-current="page"><?= esc_html($page_title); ?></span>
        </nav>

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

    <?php if (!empty($cursussen)) : ?>
        <div class="cursus-cards cursus-cards--<?= esc_attr($background); ?><?= $background === 'dark-blue' ? ' cursus-cards--dark' : ''; ?>">
            <div class="container">

                <?php foreach ($cursussen as $cursus) :
                    $cursus_id   = $cursus->ID;
                    $kosten      = get_field('kosten',              $cursus_id);
                    $locatie     = get_field('locatie',             $cursus_id);
                    $duur        = get_field('duur',                $cursus_id);
                    $inschrijven = get_field('inschrijven_url',     $cursus_id);
                    $el_label    = get_field('eigen_locatie_label', $cursus_id) ?: 'OP EIGEN LOCATIE';
                    $el_link     = get_field('eigen_locatie_link',  $cursus_id) ?: [];
                    $el_url      = $el_link['url']    ?? '#';
                    $el_target   = $el_link['target'] ?? '_self';
                ?>
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
                        <?php get_template_part('components/button', '', [
                            'label'   => 'DIRECT INSCHRIJVEN',
                            'url'     => $inschrijven ?: '#',
                            'target'  => '_blank',
                            'variant' => 'accent',
                            'icon'    => true,
                        ]); ?>

                        <?php get_template_part('components/button', '', [
                            'label'   => $el_label,
                            'url'     => $el_url,
                            'target'  => $el_target,
                            'variant' => 'outline',
                            'icon'    => false,
                        ]); ?>
                    </div>

                </article>
                <?php endforeach; ?>

            </div>
        </div>
    <?php endif; ?>

    <?php get_template_part('components/colorbar'); ?>

    <?php while (have_posts()) : the_post(); ?>
        <?php if (has_blocks(get_the_content())) : ?>
            <div id="page-content" class="page-content">
                <?php the_content(); ?>
            </div>
        <?php endif; ?>
    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
