<?php get_header(); ?>

<?php

$post_id     = get_the_ID();
$blog_title  = get_the_title();
$img_url     = get_the_post_thumbnail_url($post_id, 'full');
$post_date   = date_i18n('j F Y', get_the_time('U'));
$read_time   = arehbo_reading_time($post_id);

$crumb_title = mb_strlen($blog_title) > 40
    ? mb_substr($blog_title, 0, 40) . '...'
    : $blog_title;

$background = get_field('background', $post_id) ?: 'light';

$show_breadcrumbs = get_field('show_breadcrumbs', $post_id);
if ($show_breadcrumbs === null || $show_breadcrumbs === '') {
    $show_breadcrumbs = true;
}
$show_breadcrumbs = (bool) $show_breadcrumbs;

$author_raw  = get_field('blog_author', $post_id);
if ($author_raw instanceof WP_Post) {
    $author_post = $author_raw;
} elseif (is_numeric($author_raw) && $author_raw > 0) {
    $author_post = get_post((int) $author_raw);
} else {
    $raw_id      = get_post_meta($post_id, 'blog_author', true);
    $author_post = $raw_id ? get_post((int) $raw_id) : null;
}

$author_name    = $author_post ? get_the_title($author_post) : '';
$author_img_id  = ($author_post && $author_post->ID) ? get_post_thumbnail_id($author_post->ID) : 0;
$author_img_url = $author_img_id
    ? wp_get_attachment_image_url($author_img_id, [62, 62])
    : '';
$author_img_alt = $author_img_id
    ? (get_post_meta($author_img_id, '_wp_attachment_image_alt', true) ?: $author_name)
    : $author_name;

$arrow_left = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" focusable="false" fill="none"><path d="M19 12H5M11 18L5 12L11 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';

$blogs_url = ($page_for_posts = get_option('page_for_posts'))
    ? get_permalink($page_for_posts)
    : home_url('/');
?>

<main class="single-post" id="main-content">

    <section class="single-hero"
        <?php if ($img_url) : ?>
            style="background-image: url('<?= esc_url($img_url); ?>');"
        <?php endif; ?>>

        <div class="single-hero__inner container">

            <div class="single-hero__nav">

                <a class="single-hero__back" href="<?= esc_url($blogs_url); ?>">
                    <?= $arrow_left; ?>
                    Terug naar alle blogs
                </a>

                <?php if ($show_breadcrumbs) : ?>
                    <nav class="single-hero__breadcrumbs" aria-label="Breadcrumb">
                        <a class="single-hero__crumb-link" href="<?= esc_url(home_url('/')); ?>">Home</a>
                        <span class="single-hero__crumb-sep" aria-hidden="true">/</span>
                        <a class="single-hero__crumb-link" href="<?= esc_url($blogs_url); ?>">Blogs</a>
                        <span class="single-hero__crumb-sep" aria-hidden="true">/</span>
                        <span class="single-hero__crumb-current" aria-current="page"><?= esc_html($crumb_title); ?></span>
                    </nav>
                <?php endif; ?>

            </div>

            <hr class="single-hero__sep">

            <h1 class="single-hero__title"><?= esc_html($blog_title); ?></h1>

        </div>
    </section>

    <div class="single-body bg-<?= esc_attr($background); ?>">
        <div class="container">
            <div class="single-content">

                <div class="single-author">

                    <?php if ($author_name) : ?>
                        <div class="single-author__left">
                            <?php if ($author_img_url) : ?>
                                <img
                                    class="single-author__avatar"
                                    src="<?= esc_url($author_img_url); ?>"
                                    alt="<?= esc_attr($author_img_alt); ?>"
                                    width="62"
                                    height="62"
                                    loading="lazy"
                                >
                            <?php endif; ?>
                            <div class="single-author__info">
                                <span class="single-author__label">Geschreven door:</span>
                                <span class="single-author__name"><?= esc_html($author_name); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="single-author__right">
                        <div class="single-author__meta-item">
                            <span class="single-author__meta-label">Geplaatst op:</span>
                            <span class="single-author__meta-value"><?= esc_html($post_date); ?></span>
                        </div>
                        <div class="single-author__meta-item">
                            <span class="single-author__meta-label">Leestijd:</span>
                            <span class="single-author__meta-value"><?= esc_html($read_time); ?></span>
                        </div>
                    </div>

                </div>

                <div class="single-entry">
                    <?php the_content(); ?>
                </div>

            </div>
        </div>
    </div>

</main>

<?php get_footer(); ?>
