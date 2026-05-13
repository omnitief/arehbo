<?php

$link    = get_field('link');
$variant = get_field('variant') ?: 'accent';
$icon    = $variant !== 'outline';

if (empty($link) || empty($link['url'])) {
    return;
}

get_template_part('components/button', '', [
    'label'   => $link['title'] ?? '',
    'url'     => $link['url'],
    'target'  => $link['target'] ?? '_self',
    'variant' => $variant,
    'icon'    => $icon,
]);
