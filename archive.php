<?php get_header(); ?>

<?php
$queried       = get_queried_object();
$archive_title = __('Blogs', 'arehbo-theme');

if (isset($queried->labels->name) && $queried->labels->name) {
    $archive_title = $queried->labels->name;
} elseif (isset($queried->name) && $queried->name) {
    $archive_title = $queried->name;
}

$archive_desc  = isset($queried->description) ? $queried->description : '';

$arrow_white = '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><path d="M4 10H16M16 10L11 5M16 10L11 15" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
?>

<main id="main-content" class="archive-page">

    <div class="archive-hero bg-light">
        <div class="archive-hero__inner container">

            <nav class="archive-breadcrumbs" aria-label="Breadcrumb">
                <a class="archive-breadcrumbs__link" href="<?= esc_url(home_url('/')); ?>">Home</a>
                <span class="archive-breadcrumbs__sep" aria-hidden="true">/</span>
                <a class="archive-breadcrumbs__link" href="<?= esc_url(home_url('/blogs')); ?>">Blogs</a>
                <span class="archive-breadcrumbs__sep" aria-hidden="true">/</span>
                <span class="archive-breadcrumbs__current" aria-current="page"><?= esc_html($archive_title); ?></span>
            </nav>

            <hr class="archive-hero__divider">

            <h1 class="archive-hero__title"><?= esc_html($archive_title); ?></h1>

            <?php if ($archive_desc) : ?>
                <p class="archive-hero__desc"><?= esc_html($archive_desc); ?></p>
            <?php endif; ?>

        </div>
    </div>

    <div class="archive-posts bg-light">
        <div class="container">

            <?php if (have_posts()) : ?>

                <div class="blogs__grid">
                    <?php while (have_posts()) : the_post();
                        $post_id      = get_the_ID();
                        $post_url     = get_permalink();
                        $post_title   = get_the_title();
                        $post_excerpt = wp_trim_words(
                            get_the_excerpt() ?: strip_tags(get_the_content()),
                            30,
                            '...'
                        );

                        $image_id  = get_post_thumbnail_id($post_id);
                        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'large') : '';
                        $image_alt = $image_id ? (get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: esc_attr($post_title)) : '';

                        $word_count   = str_word_count(strip_tags(get_post_field('post_content', $post_id)));
                        $reading_mins = max(1, (int) ceil($word_count / 200));
                    ?>

                        <article class="blog-card">

                            <a
                                class="blog-card__link"
                                href="<?= esc_url($post_url); ?>"
                                aria-label="<?= esc_attr($post_title); ?>"
                            ></a>

                            <?php if ($image_url) : ?>
                                <div class="blog-card__image-wrap">
                                    <img
                                        class="blog-card__image"
                                        src="<?= esc_url($image_url); ?>"
                                        alt="<?= esc_attr($image_alt); ?>"
                                        width="565"
                                        height="400"
                                        loading="lazy"
                                    >
                                    <div class="blog-card__reading-time" aria-label="Leestijd">
                                        <span>Leestijd: <?= $reading_mins; ?> minuten</span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="blog-card__body">

                                <h2 class="blog-card__title"><?= esc_html($post_title); ?></h2>

                                <?php if ($post_excerpt) : ?>
                                    <p class="blog-card__excerpt"><?= esc_html($post_excerpt); ?></p>
                                <?php endif; ?>

                                <div class="blog-card__btn-wrap">
                                    <span class="blog-card__btn-label" aria-hidden="true">LEES VERDER</span>
                                    <span class="blog-card__btn" aria-hidden="true"><?= $arrow_white; ?></span>
                                </div>

                            </div>

                        </article>

                    <?php endwhile; ?>
                </div>

                <?php
                $pagination = paginate_links([
                    'type'      => 'array',
                    'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="16" height="16" fill="none" aria-hidden="true"><path d="M16 10H4M4 10L9 5M4 10L9 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                    'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" width="16" height="16" fill="none" aria-hidden="true"><path d="M4 10H16M16 10L11 5M16 10L11 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                ]);
                if ($pagination) : ?>
                    <nav class="blog-pagination" aria-label="Paginering">
                        <?php foreach ($pagination as $link) : ?>
                            <?= $link; ?>
                        <?php endforeach; ?>
                    </nav>
                <?php endif; ?>

            <?php else : ?>
                <p class="archive-empty">Geen blogs gevonden.</p>
            <?php endif; ?>

        </div>
    </div>

</main>

<?php get_footer(); ?>
