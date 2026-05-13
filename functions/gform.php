<?php

add_filter('gform_submit_button', function($button, $form) {
    $label = $form['button']['text'] ?? __('Submit', 'arehbo-theme');
    $icon  = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="#ED6D05" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    return '<button type="submit" id="gform_submit_button_' . intval($form['id']) . '" class="gform_button arehbo-gf-btn">'
        . esc_html($label)
        . '<span class="arehbo-gf-btn__icon">' . $icon . '</span>'
        . '</button>';
}, 10, 2);

