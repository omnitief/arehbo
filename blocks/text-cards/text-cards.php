<?php

$space      = get_spacing_class(get_field('space'));
$full_id    = get_full_id(get_field('id'));
$background = get_field('tc_background') ?: 'dark';

$title       = get_field('tc_title');
$description = get_field('tc_description');
$button_raw  = get_field('tc_button') ?: [];
$btn_style   = get_field('tc_button_style') ?: 'default';
$cards       = get_field('tc_cards') ?: [];

$btn_url    = $button_raw['url']    ?? '';
$btn_label  = $button_raw['title']  ?? '';
$btn_target = $button_raw['target'] ?? '_self';

?>

<section <?= $full_id; ?> class="text-cards-block text-cards-block--<?= esc_attr($background); ?>">
    <div class="<?= esc_attr($space); ?>">
        <div class="text-cards-block__layout container">

            <div class="text-cards-block__left">

                <?php if ($title) : ?>
                    <h2 class="text-cards-block__title"><?= esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if ($description) : ?>
                    <p class="text-cards-block__description"><?= nl2br(esc_html($description)); ?></p>
                <?php endif; ?>

                <?php if ($btn_url && $btn_label) : ?>
                    <div class="text-cards-block__btn-wrap">
                        <?php get_template_part('components/button', '', [
                            'label'  => $btn_label,
                            'url'    => $btn_url,
                            'target' => $btn_target,
                            'variant' => $btn_style,
                            'icon'   => true,
                        ]); ?>
                    </div>
                <?php endif; ?>

            </div>

            <?php if ($cards) : ?>
                <div class="text-cards-block__cards">
                    <?php foreach ($cards as $card) :
                        $card_title = $card['card_title'] ?? '';
                        $card_desc  = $card['card_description'] ?? '';
                    ?>
                        <div class="text-cards-block__card">

                            <div class="text-cards-block__card-header">
                                <span class="text-cards-block__card-icon" aria-hidden="true"></span>
                                <?php if ($card_title) : ?>
                                    <h3 class="text-cards-block__card-title"><?= esc_html($card_title); ?></h3>
                                <?php endif; ?>
                            </div>

                            <?php if ($card_desc) : ?>
                                <p class="text-cards-block__card-description"><?= nl2br(esc_html($card_desc)); ?></p>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
