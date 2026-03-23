<?php

$items     = $args['items']     ?? [];
$show_icon = $args['show_icon'] ?? false;
$label     = $args['label']     ?? __('Key features', 'arehbo-theme');

if (empty($items)) return;

?>
<ul class="usp-list__items" aria-label="<?= esc_attr($label); ?>">
    <?php foreach ($items as $item) :
        $text    = $item['text'] ?? '';
        $icon_id = $show_icon ? ($item['icon'] ?? null) : null;
        if (empty($text)) continue;

        $icon_url   = $icon_id ? wp_get_attachment_image_url($icon_id, [24, 24]) : null;
        $icon_alt   = $icon_id ? get_post_meta($icon_id, '_wp_attachment_image_alt', true) : '';
        $icon_title = $icon_id ? get_the_title($icon_id) : '';
    ?>
        <li class="usp-item">

            <?php if ($show_icon) : ?>
                <span class="usp-item__icon" aria-hidden="true">
                    <?php if ($icon_url) : ?>
                        <img
                            src="<?= esc_url($icon_url); ?>"
                            alt="<?= esc_attr($icon_alt); ?>"
                            title="<?= esc_attr($icon_title); ?>"
                            width="24"
                            height="24"
                        >
                    <?php else : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" focusable="false">
                            <path fill="currentColor" d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    <?php endif; ?>
                </span>
            <?php endif; ?>

            <span class="usp-item__text"><?= esc_html($text); ?></span>

        </li>
    <?php endforeach; ?>
</ul>
