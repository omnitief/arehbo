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

function arehbo_today_hours($schedule) {
    if (empty($schedule) || !is_array($schedule)) return null;
    $now_day = (int) current_time('N');
    foreach ($schedule as $row) {
        if ((int) ($row['day'] ?? 0) === $now_day) {
            return $row;
        }
    }
    return null;
}

function arehbo_is_open_now($schedule) {
    if (empty($schedule) || !is_array($schedule)) {
        return false;
    }

    $now_day  = (int) current_time('N');
    $now_time = current_time('H:i');

    foreach ($schedule as $row) {
        $day = (int) ($row['day'] ?? 0);
        if ($day !== $now_day) continue;

        if (!empty($row['closed'])) return false;

        $open  = $row['open']  ?? '';
        $close = $row['close'] ?? '';
        if (!$open || !$close) return false;

        return ($now_time >= $open && $now_time < $close);
    }

    return false;
}

function arehbo_format_nl_date($timestamp) {
    if (empty($timestamp)) return '';

    $days_short = [
        'Monday'    => 'Ma.',
        'Tuesday'   => 'Di.',
        'Wednesday' => 'Wo.',
        'Thursday'  => 'Do.',
        'Friday'    => 'Vr.',
        'Saturday'  => 'Za.',
        'Sunday'    => 'Zo.',
    ];

    $months = [
        1  => 'januari', 2  => 'februari', 3  => 'maart',     4  => 'april',
        5  => 'mei',     6  => 'juni',     7  => 'juli',      8  => 'augustus',
        9  => 'september', 10 => 'oktober', 11 => 'november', 12 => 'december',
    ];

    $dow   = $days_short[date('l', $timestamp)] ?? '';
    $day   = (int) date('j', $timestamp);
    $month = $months[(int) date('n', $timestamp)] ?? '';
    $year  = date('Y', $timestamp);

    return trim("{$dow} {$day} {$month} {$year}");
}

