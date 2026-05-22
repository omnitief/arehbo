<?php

get_header();

$content = get_field('blocks_404_content', 'option');
$button  = get_field('blocks_404_button', 'option');

?>

<main id="main-content" class="page-404">
    <div class="page-404__inner container">

        <?php get_template_part('components/breadcrumbs', null, [
            'current_label' => '404',
        ]); ?>

        <hr class="page-404-divider">

        <div class="page-404__content">
            <div class="page-404__wysiwyg">
                <?= wp_kses_post($content); ?>
            </div>

            <?php if (!empty($button['url']) && !empty($button['title'])) : ?>
                <div class="page-404__cta">
                    <?php get_template_part('components/button', '', [
                        'label'   => $button['title'],
                        'url'     => $button['url'],
                        'target'  => $button['target'] ?? '_self',
                        'variant' => 'accent',
                        'icon'    => true,
                    ]); ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>

<?php get_footer(); ?>
