<?php

function arehbo_reading_time($post_id = null) {
    $content    = get_post_field('post_content', $post_id ?: get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $minutes    = max(1, (int) round($word_count / 200));
    return $minutes . ' ' . ($minutes === 1 ? 'minuut' : 'minuten');
}

function get_spacing_class($space) {
    if (empty($space)) return '';

    $classes = [];

    if (!empty($space['top']) && $space['top'] !== 'none') {
        $classes[] = 'space-top-' . $space['top'];
    }

    if (!empty($space['bottom']) && $space['bottom'] !== 'none') {
        $classes[] = 'space-bottom-' . $space['bottom'];
    }

    return implode(' ', $classes);
}

function get_full_id($id) {
    if (empty($id)) return '';
    return 'id="' . esc_attr($id) . '"';
}

