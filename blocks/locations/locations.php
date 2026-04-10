<?php

$space    = get_spacing_class(get_field('space'));
$full_id  = get_full_id(get_field('id'));

$title    = get_field('loc_title');
$desc     = get_field('loc_description');
$btn_text = get_field('loc_button_text');
$btn_link = get_field('loc_button_link') ?: [];

$btn_url    = $btn_link['url']    ?? '';
$btn_target = $btn_link['target'] ?? '_self';

$map_url = get_template_directory_uri() . '/blocks/locations/map-nl.svg';

?>

<section <?= $full_id; ?> class="locations-block">
    <div class="<?= esc_attr($space); ?>">
        <div class="locations-block__layout">

            <div class="locations-block__left">

                <?php if ($title) : ?>
                    <h2 class="locations-block__title"><?= esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if ($desc) : ?>
                    <div class="locations-block__description">
                        <?= wp_kses_post($desc); ?>
                    </div>
                <?php endif; ?>

                <?php if ($btn_text && $btn_url) : ?>
                    <div class="locations-block__btn-wrap">
                        <?php get_template_part('components/button', '', [
                            'label'   => $btn_text,
                            'url'     => $btn_url,
                            'target'  => $btn_target,
                            'variant' => 'accent',
                            'icon'    => true,
                        ]); ?>
                    </div>
                <?php endif; ?>

            </div>

            <div class="locations-block__right" aria-hidden="true">
                <div class="locations-block__map-wrap">
                    <img src="<?= esc_url($map_url); ?>" alt="" aria-hidden="true" class="locations-block__map-img">
                </div>
            </div>

        </div>
    </div>
</section>
