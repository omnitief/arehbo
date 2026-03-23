<?php

$space       = get_spacing_class(get_field('space'));
$full_id     = get_full_id(get_field('id'));
$image_id    = get_field('image');
$image_url   = $image_id ? wp_get_attachment_image_url($image_id, 'full') : '';
$image_alt   = $image_id ? (get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: '') : '';
$image_label = get_field('image_label');
$title       = get_field('title');
$description = get_field('description');
$buttons     = array_slice((array) get_field('buttons'), 0, 2);

if (empty($title)) {
    return;
}

?>

<section <?= $full_id; ?> class="cta">
    <div class="<?= esc_attr($space); ?>">
        <div class="container">
        <div class="cta__grid">

            <?php if ($image_url) : ?>
                <div class="cta__media">
                    <img
                        class="cta__image"
                        src="<?= esc_url($image_url); ?>"
                        alt="<?= esc_attr($image_alt); ?>"
                        width="440"
                        height="362"
                        loading="lazy"
                    >
                    <?php if ($image_label) : ?>
                        <span class="cta__badge"><?= esc_html($image_label); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="cta__content">

                <div class="cta__text">
                    <h2 class="cta__title"><?= esc_html($title); ?></h2>
                    <?php if ($description) : ?>
                        <p class="cta__description"><?= esc_html($description); ?></p>
                    <?php endif; ?>
                </div>

                <?php if (!empty($buttons)) : ?>
                    <div class="cta__buttons">
                        <?php foreach ($buttons as $btn) :
                            $label   = $btn['label']   ?? '';
                            $url     = $btn['url']     ?? '';
                            $variant = $btn['variant'] ?? 'default';

                            if (empty($label) || empty($url)) continue;
                        ?>
                            <?php get_template_part('components/button', '', [
                                'label'   => $label,
                                'url'     => $url,
                                'variant' => $variant,
                            ]); ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>

        </div>
        </div>
    </div>
</section>
