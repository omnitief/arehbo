<?php

add_filter('gform_submit_button', function($button, $form) {
    $label = $form['button']['text'] ?? __('Submit', 'arehbo-theme');
    $icon  = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="#ED6D05" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    return '<button type="submit" id="gform_submit_button_' . intval($form['id']) . '" class="gform_button arehbo-gf-btn">'
        . esc_html($label)
        . '<span class="arehbo-gf-btn__icon">' . $icon . '</span>'
        . '</button>';
}, 10, 2);

function arehbo_gf_get_attr_from_html($html, $attr) {
    if (!is_string($html) || $html === '') return '';
    if (!preg_match('/\b' . preg_quote($attr, '/') . '\\s*=\\s*(["\'])(.*?)\\1/i', $html, $m)) return '';
    return $m[2] ?? '';
}

function arehbo_gf_buttonify_input($button_html, $type, $extra_class = '') {
    $label = arehbo_gf_get_attr_from_html($button_html, 'value');
    $id    = arehbo_gf_get_attr_from_html($button_html, 'id');
    $class = arehbo_gf_get_attr_from_html($button_html, 'class');

    $attrs = [];
    if (preg_match_all('/(\\w[\\w:-]*)\\s*=\\s*(["\'])(.*?)\\2/', $button_html, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $pair) {
            $name  = strtolower($pair[1]);
            $value = $pair[3];
            if ($name === 'type' || $name === 'value') continue;
            $attrs[$name] = $value;
        }
    }

    $class_parts = array_filter(array_map('trim', explode(' ', (string) $class)));
    foreach (array_filter(array_map('trim', explode(' ', (string) $extra_class))) as $c) {
        $class_parts[] = $c;
    }
    $class_parts[] = 'arehbo-gf-btn';
    $attrs['class'] = implode(' ', array_values(array_unique($class_parts)));

    if ($id) $attrs['id'] = $id;

    $attr_string = '';
    foreach ($attrs as $name => $value) {
        if ($value === '') continue;
        $attr_string .= ' ' . esc_attr($name) . '="' . esc_attr($value) . '"';
    }

    $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="#ED6D05" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    if ($label === '') {
        $label = __('Volgende', 'arehbo-theme');
    }

    return '<button type="' . esc_attr($type) . '"' . $attr_string . '>'
        . esc_html($label)
        . '<span class="arehbo-gf-btn__icon">' . $icon . '</span>'
        . '</button>';
}

add_filter('gform_next_button', function($button, $form) {
    return arehbo_gf_buttonify_input($button, 'button', 'gform_button gform_next_button');
}, 10, 2);
