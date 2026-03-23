<?php

$title          = $args['title']          ?? '';
$description    = $args['description']    ?? '';
$button         = $args['button']         ?? null;
$button_variant = $args['button_variant'] ?? 'default';

if (empty($title) && empty($description) && empty($button)) {
    return;
}

?>

<?php if ($title) : ?>
    <h2 class="text-content__title"><?php echo esc_html($title); ?></h2>
<?php endif; ?>

<?php if ($description) : ?>
    <div class="text-content__description">
        <?php echo wp_kses_post($description); ?>
    </div>
<?php endif; ?>

<?php if ($button && !empty($button['url'])) : ?>
    <div class="text-content__cta">
        <?php get_template_part('components/button', '', [
            'label'   => $button['title'],
            'url'     => $button['url'],
            'target'  => $button['target'] ?? '_self',
            'variant' => $button_variant,
        ]); ?>
    </div>
<?php endif; ?>
