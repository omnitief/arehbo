<?php get_header(); ?>

<?php

$post_id    = get_the_ID();
$page_title = get_the_title();
$img_url    = get_the_post_thumbnail_url($post_id, 'full');
$post_date  = date_i18n('j F Y', get_the_time('U'));

$uren    = get_field('uren', $post_id);
$locatie = get_field('locatie', $post_id);

$show_breadcrumbs = get_field('show_breadcrumbs', $post_id);
if ($show_breadcrumbs === null || $show_breadcrumbs === '') {
    $show_breadcrumbs = true;
}
$show_breadcrumbs = (bool) $show_breadcrumbs;

$crumb_title = mb_strlen($page_title) > 40
    ? mb_substr($page_title, 0, 40) . '...'
    : $page_title;

$background = 'light';

$arrow_left = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" focusable="false" fill="none"><path d="M19 12H5M11 18L5 12L11 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';

$vacatures_url = home_url('/vacatures/');
?>

<main class="single-post" id="main-content">

    <section class="single-hero"
        <?php if ($img_url) : ?>
            style="background-image: url('<?= esc_url($img_url); ?>');"
        <?php endif; ?>>

        <div class="single-hero__inner container">

            <div class="single-hero__nav">

                <a class="single-hero__back" href="<?= esc_url($vacatures_url); ?>">
                    <?= $arrow_left; ?>
                    Terug naar alle vacatures
                </a>

                <?php if ($show_breadcrumbs) : ?>
                    <nav class="single-hero__breadcrumbs" aria-label="Breadcrumb">
                        <a class="single-hero__crumb-link" href="<?= esc_url(home_url('/')); ?>">Home</a>
                        <span class="single-hero__crumb-sep" aria-hidden="true">/</span>
                        <a class="single-hero__crumb-link" href="<?= esc_url($vacatures_url); ?>">Vacatures</a>
                        <span class="single-hero__crumb-sep" aria-hidden="true">/</span>
                        <span class="single-hero__crumb-current" aria-current="page"><?= esc_html($crumb_title); ?></span>
                    </nav>
                <?php endif; ?>

            </div>

            <hr class="single-hero__sep">

            <h1 class="single-hero__title"><?= esc_html($page_title); ?></h1>

        </div>
    </section>

    <div class="single-body bg-<?= esc_attr($background); ?>">
        <div class="container">
            <div class="single-content">

                <?php if ($uren || $locatie || $post_date) : ?>
                    <div class="single-author">
                        <div class="single-author__right">
                            <?php if ($uren) : ?>
                                <div class="single-author__meta-item">
                                    <span class="single-author__meta-label">Uren:</span>
                                    <span class="single-author__meta-value"><?= esc_html($uren); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($locatie) : ?>
                                <div class="single-author__meta-item">
                                    <span class="single-author__meta-label">Locatie:</span>
                                    <span class="single-author__meta-value"><?= esc_html($locatie); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="single-author__meta-item">
                                <span class="single-author__meta-label">Geplaatst op:</span>
                                <span class="single-author__meta-value"><?= esc_html($post_date); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="single-entry">
                    <?php while (have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; ?>
                </div>

            </div>
        </div>
    </div>

</main>

<?php get_footer(); ?>
