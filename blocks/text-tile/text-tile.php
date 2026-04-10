<?php

$space       = get_spacing_class(get_field('space'));
$full_id     = get_full_id(get_field('id'));
$background  = get_field('background') ?: 'light';
$description = get_field('description');
$button      = get_field('button');

$bg_map   = ['dark' => 'bg-dark', 'light' => 'bg-light'];
$bg_class = $bg_map[$background] ?? 'bg-light';

if (empty($description) && empty($button)) {
    return;
}

?>

<section <?= $full_id; ?> class="text-tile <?= esc_attr($bg_class); ?>">
    <div class="<?= esc_attr($space); ?>">
        <div class="container">

        <?php if ($description) : ?>
            <div class="text-tile__description">
                <?php echo wp_kses_post($description); ?>
            </div>
        <?php endif; ?>

        <?php if ($button && !empty($button['url'])) : ?>
            <div class="text-tile__cta">
                <?php get_template_part('components/button', '', [
                    'label'   => $button['title'],
                    'url'     => $button['url'],
                    'target'  => $button['target'] ?? '_self',
                    'variant' => 'default',
                ]); ?>
            </div>
        <?php endif; ?>

        </div>
    </div>
</section>
