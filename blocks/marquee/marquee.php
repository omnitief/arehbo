<?php

$space  = get_spacing_class(get_field('space'));
$full_id = get_full_id(get_field('id'));
$title  = get_field('title');
$logos  = get_field('logos');

if (empty($title) && empty($logos)) {
    return;
}

$title_clean = trim(preg_replace('/<\/?p[^>]*>/', '', $title));

?>

<section <?= $full_id; ?> class="marquee-block">
    <div class="<?= esc_attr($space); ?>">
        <div class="container">

        <?php if ($title_clean) : ?>
            <h2 class="marquee-block__title"><?= wp_kses_post($title_clean); ?></h2>
        <?php endif; ?>

        <hr class="marquee-block__divider">

        <?php if (!empty($logos)) : ?>
            <div class="marquee-block__logos">
                <div class="marquee-block__track">

                    <?php foreach ($logos as $item) :
                        $logo_id = $item['logo'] ?? null;
                        if (!$logo_id) continue;
                        $logo_url = wp_get_attachment_image_url($logo_id, 'full');
                        $logo_alt = get_post_meta($logo_id, '_wp_attachment_image_alt', true) ?: '';
                    ?>
                        <img class="marquee-block__logo" src="<?= esc_url($logo_url); ?>" alt="<?= esc_attr($logo_alt); ?>" loading="lazy">
                    <?php endforeach; ?>

                    <?php foreach ($logos as $item) :
                        $logo_id = $item['logo'] ?? null;
                        if (!$logo_id) continue;
                        $logo_url = wp_get_attachment_image_url($logo_id, 'full');
                    ?>
                        <img class="marquee-block__logo" src="<?= esc_url($logo_url); ?>" alt="" aria-hidden="true" loading="lazy">
                    <?php endforeach; ?>

                </div>
            </div>
        <?php endif; ?>

        </div>
    </div>
</section>
