<?php
/*
 * Template Name: Formulier
 */

get_header();

$page_title  = get_the_title();
$title       = get_field('formulier_title');
$description = get_field('formulier_description');
$buttons     = get_field('formulier_buttons') ?: [];
$form_id     = get_field('formulier_form_id');

?>

<main id="main-content" class="formulier-page">

    <div class="formulier-page__inner container">

        <nav class="formulier-breadcrumbs" aria-label="Breadcrumb">
            <a class="formulier-breadcrumbs__link" href="<?= esc_url(home_url('/')); ?>">Home</a>
            <span class="formulier-breadcrumbs__sep" aria-hidden="true">/</span>
            <span class="formulier-breadcrumbs__current" aria-current="page"><?= esc_html($page_title); ?></span>
        </nav>

        <hr class="formulier-divider">

        <div class="formulier-stack">

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
                    <?php foreach (array_slice($buttons, 0, 2) as $i => $btn) :
                        $link    = $btn['link'] ?? [];
                        $label   = $link['title'] ?? '';
                        $url     = $link['url'] ?? '';
                        $target  = $link['target'] ?? '_self';
                        $variant = $btn['variant'] ?? ($i === 0 ? 'accent' : 'outline');
                        if (empty($label) || empty($url)) continue;
                    ?>
                        <?php get_template_part('components/button', '', [
                            'label'   => $label,
                            'url'     => $url,
                            'target'  => $target,
                            'variant' => $variant,
                            'icon'    => true,
                        ]); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="formulier-form-card">

                <?php if ($form_id) : ?>
                    <div class="formulier-form-card__body">
                        <?= do_shortcode('[gravityforms id="' . intval($form_id) . '" ajax="true"]'); ?>
                    </div>
                <?php else : ?>
                    <p class="formulier-form-card__empty">No form selected.</p>
                <?php endif; ?>

            </div><!-- .formulier-form-card -->

        </div><!-- .formulier-stack -->

        <?php while (have_posts()) : the_post(); ?>
            <div id="page-content" class="page-content">
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>

    </div><!-- .formulier-page__inner -->

</main>

<?php get_footer(); ?>
