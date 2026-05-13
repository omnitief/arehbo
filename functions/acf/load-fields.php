<?php

function arehbo_acf_load_gravityforms($field) {
    $field['choices'] = [];

    if (class_exists('GFAPI')) {
        $forms = GFAPI::get_forms();
        if (!empty($forms)) {
            foreach ($forms as $form) {
                $field['choices'][ $form['id'] ] = $form['title'];
            }
        }
    }

    if (empty($field['choices'])) {
        $field['choices'][''] = '— No forms found (install Gravity Forms) —';
    }

    return $field;
}

add_filter('acf/load_field/key=field_form_form_id',    'arehbo_acf_load_gravityforms');
add_filter('acf/load_field/key=field_cf_form_id',      'arehbo_acf_load_gravityforms');
add_filter('acf/load_field/key=field_inschr_form_id',  'arehbo_acf_load_gravityforms');
add_filter('acf/load_field/key=field_hb_form_id',      'arehbo_acf_load_gravityforms');

