<?php

$label   = $args['label']   ?? '';
$url     = $args['url']     ?? '';
$target  = $args['target']  ?? '_self';
$variant = $args['variant'] ?? 'accent';
$icon    = $args['icon']    ?? true;

if (empty($label) || empty($url)) {
    return;
}

$is_external = $target === '_blank';
$classes     = 'btn btn--' . esc_attr($variant) . ($icon ? ' btn--icon' : '');
?>

<a
    href="<?php echo esc_url($url); ?>"
    class="<?php echo $classes; ?>"
    <?php if ($is_external) : ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>
>
    <?php echo esc_html($label); ?>
    <?php if ($icon) : ?>
        <span class="btn__icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none">
                <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
    <?php endif; ?>
</a>
