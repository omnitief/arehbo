<?php
/*
 * Template Name: Formulier
 */

get_header();

$page_title  = get_the_title();
$background  = get_field('formulier_background') ?: 'light';
$title       = get_field('formulier_title');
$description = get_field('formulier_description');
$buttons     = get_field('formulier_buttons') ?: [];
$img_id      = get_field('formulier_image');
$form_id     = get_field('formulier_form_id');

$img_url = $img_id ? wp_get_attachment_image_url($img_id, 'full') : '';
$img_alt = $img_id ? (get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: $page_title) : '';

$bg_class = ($background === 'dark') ? 'bg-dark' : 'bg-light';

$arrow_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="none" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';

?>

<main id="main-content" class="formulier-page <?= esc_attr($bg_class); ?>">

    <div class="formulier-page__inner container">

        <nav class="formulier-breadcrumbs" aria-label="Breadcrumb">
            <a class="formulier-breadcrumbs__link" href="<?= esc_url(home_url('/')); ?>">Home</a>
            <span class="formulier-breadcrumbs__sep" aria-hidden="true">/</span>
            <span class="formulier-breadcrumbs__current" aria-current="page"><?= esc_html($page_title); ?></span>
        </nav>

        <hr class="formulier-divider">

        <div class="formulier-grid">

            <div class="formulier-left">

                <?php if ($title) : ?>
                    <h1 class="formulier-title"><?= esc_html($title); ?></h1>
                <?php endif; ?>

                <?php if ($description) : ?>
                    <div class="formulier-description">
                        <?= wp_kses_post($description); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($buttons)) : ?>
                    <div class="formulier-buttons">
                        <?php foreach (array_slice($buttons, 0, 2) as $btn) :
                            $btn_text   = $btn['btn_text']  ?? '';
                            $btn_link   = $btn['btn_link']  ?? [];
                            $btn_style  = $btn['btn_style'] ?? 'primary';
                            $btn_url    = $btn_link['url']    ?? '';
                            $btn_target = $btn_link['target'] ?? '_self';
                            if (empty($btn_text) || empty($btn_url)) continue;
                            $variant = ($btn_style === 'outline') ? 'outline' : 'accent';
                        ?>
                            <?php get_template_part('components/button', '', [
                                'label'   => $btn_text,
                                'url'     => $btn_url,
                                'target'  => $btn_target,
                                'variant' => $variant,
                                'icon'    => true,
                            ]); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($img_url) : ?>
                    <div class="formulier-image-wrap">
                        <img
                            class="formulier-image"
                            src="<?= esc_url($img_url); ?>"
                            alt="<?= esc_attr($img_alt); ?>"
                            loading="lazy"
                        >
                    </div>
                <?php endif; ?>

            </div><!-- .formulier-left -->

            <div class="formulier-form-card <?= $background === 'dark' ? 'formulier-form-card--dark' : ''; ?>">

                <?php if ($form_id) : ?>
                    <div class="formulier-form-card__body">
                        <?= do_shortcode('[gravityforms id="' . intval($form_id) . '" ajax="true"]'); ?>
                    </div>
                <?php else : ?>
                    <p class="formulier-form-card__empty">No form selected.</p>
                <?php endif; ?>

            </div><!-- .formulier-form-card -->

        </div><!-- .formulier-grid -->

    </div><!-- .formulier-page__inner -->

    <?php get_template_part('components/colorbar'); ?>

    <?php while (have_posts()) : the_post(); ?>
        <div id="page-content" class="page-content">
            <?php the_content(); ?>
        </div>
    <?php endwhile; ?>

</main>

<?php get_footer(); ?>
