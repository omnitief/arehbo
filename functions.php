<?php

add_filter('show_admin_bar', '__return_false');

function arehbo_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('editor-styles');
}

add_action('after_setup_theme', 'arehbo_theme_setup');


function arehbo_register_blocks() {
    foreach (glob(__DIR__ . '/blocks/*', GLOB_ONLYDIR) as $block_dir) {
        register_block_type($block_dir);
    }
}

add_action('init', 'arehbo_register_blocks');


if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'Header',
        'menu_title' => 'Header',
        'menu_slug'  => 'header-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
        'icon_url'   => 'dashicons-layout',
        'position'   => 2,
    ]);

    acf_add_options_page([
        'page_title' => 'Footer',
        'menu_title' => 'Footer',
        'menu_slug'  => 'footer-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
        'icon_url'   => 'dashicons-align-center',
        'position'   => 3,
    ]);
}


function arehbo_enqueue_styles() {
    wp_enqueue_style(
        'blinker',
        'https://fonts.googleapis.com/css2?family=Blinker:wght@400;600;700&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        null
    );

    wp_enqueue_style(
        'arehbo-theme',
        get_stylesheet_uri(),
        ['blinker', 'swiper'],
        wp_get_theme()->get('Version')
    );

    wp_enqueue_style(
        'arehbo-header',
        get_template_directory_uri() . '/header.css',
        ['arehbo-theme'],
        wp_get_theme()->get('Version')
    );

    wp_enqueue_style(
        'arehbo-footer',
        get_template_directory_uri() . '/footer.css',
        ['arehbo-theme'],
        wp_get_theme()->get('Version')
    );

    wp_enqueue_style(
        'arehbo-gravity-forms',
        get_template_directory_uri() . '/gravity-forms.css',
        ['arehbo-theme'],
        wp_get_theme()->get('Version')
    );

    if (is_singular('post')) {
        wp_enqueue_style(
            'arehbo-single',
            get_template_directory_uri() . '/single.css',
            ['arehbo-theme'],
            wp_get_theme()->get('Version')
        );
    }

    if (is_archive() || is_home()) {
        wp_enqueue_style(
            'arehbo-blogs-block',
            get_template_directory_uri() . '/blocks/blogs/style.css',
            ['arehbo-theme'],
            wp_get_theme()->get('Version')
        );
        wp_enqueue_style(
            'arehbo-archive',
            get_template_directory_uri() . '/archive.css',
            ['arehbo-blogs-block'],
            wp_get_theme()->get('Version')
        );
    }

    if (is_page_template('templates/page-standard.php')) {
        wp_enqueue_style(
            'arehbo-template-standard',
            get_template_directory_uri() . '/template-standard.css',
            ['arehbo-theme'],
            wp_get_theme()->get('Version')
        );
    }

    if (is_page_template('templates/page-dienst.php')) {
        wp_enqueue_style(
            'arehbo-template-dienst',
            get_template_directory_uri() . '/template-dienst.css',
            ['arehbo-theme'],
            wp_get_theme()->get('Version')
        );
    }

    if (is_page_template('templates/page-inschrijven.php')) {
        wp_enqueue_style(
            'arehbo-template-inschrijven',
            get_template_directory_uri() . '/template-inschrijven.css',
            ['arehbo-theme'],
            wp_get_theme()->get('Version')
        );
    }

    if (is_page_template('templates/page-inschrijven-form.php')) {
        wp_enqueue_style(
            'arehbo-template-inschrijven-form',
            get_template_directory_uri() . '/template-inschrijven-form.css',
            ['arehbo-theme'],
            wp_get_theme()->get('Version')
        );
    }

    if (is_page_template('templates/page-cursus.php')) {
        wp_enqueue_style(
            'arehbo-template-cursus',
            get_template_directory_uri() . '/template-cursus.css',
            ['arehbo-theme'],
            wp_get_theme()->get('Version')
        );
    }

    if (is_page_template('templates/page-formulier.php')) {
        wp_enqueue_style(
            'arehbo-template-formulier',
            get_template_directory_uri() . '/template-formulier.css',
            ['arehbo-theme'],
            wp_get_theme()->get('Version')
        );
    }

    wp_enqueue_script(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        null,
        true
    );

    wp_enqueue_script(
        'arehbo-header',
        get_template_directory_uri() . '/header.js',
        [],
        wp_get_theme()->get('Version'),
        true
    );
}

add_action('wp_enqueue_scripts', 'arehbo_enqueue_styles');


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


add_filter('gform_submit_button', function($button, $form) {
    $label = $form['button']['text'] ?? __('Submit', 'arehbo-theme');
    $icon  = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" fill="none" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="#ED6D05" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    return '<button type="submit" id="gform_submit_button_' . intval($form['id']) . '" class="gform_button arehbo-gf-btn">'
        . esc_html($label)
        . '<span class="arehbo-gf-btn__icon">' . $icon . '</span>'
        . '</button>';
}, 10, 2);


function arehbo_register_post_types() {
    register_post_type('cursussen', [
        'labels' => [
            'name'          => 'Cursussen',
            'singular_name' => 'Cursus',
            'add_new_item'  => 'Nieuwe cursus toevoegen',
            'edit_item'     => 'Cursus bewerken',
            'view_item'     => 'Cursus bekijken',
            'search_items'  => 'Cursussen zoeken',
        ],
        'public'       => true,
        'has_archive'  => false,
        'show_in_rest' => true,
        'supports'     => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite'      => ['slug' => 'cursussen', 'with_front' => false],
        'menu_icon'    => 'dashicons-welcome-learn-more',
    ]);

    register_post_type('diensten', [
        'labels' => [
            'name'          => 'Diensten',
            'singular_name' => 'Dienst',
            'add_new_item'  => 'Nieuwe dienst toevoegen',
            'edit_item'     => 'Dienst bewerken',
            'view_item'     => 'Dienst bekijken',
            'search_items'  => 'Diensten zoeken',
        ],
        'public'       => true,
        'has_archive'  => false,
        'show_in_rest' => true,
        'supports'     => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite'      => ['slug' => 'diensten', 'with_front' => false],
        'menu_icon'    => 'dashicons-hammer',
    ]);

    register_post_type('vacatures', [
        'labels' => [
            'name'          => 'Vacatures',
            'singular_name' => 'Vacature',
            'add_new_item'  => 'Nieuwe vacature toevoegen',
            'edit_item'     => 'Vacature bewerken',
            'view_item'     => 'Vacature bekijken',
            'search_items'  => 'Vacatures zoeken',
        ],
        'public'       => true,
        'has_archive'  => false,
        'show_in_rest' => true,
        'supports'     => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite'      => ['slug' => 'vacatures', 'with_front' => false],
        'menu_icon'    => 'dashicons-businessperson',
    ]);

    register_post_type('medewerkers', [
        'labels' => [
            'name'          => 'Medewerkers',
            'singular_name' => 'Medewerker',
            'add_new_item'  => 'Nieuwe medewerker toevoegen',
            'edit_item'     => 'Medewerker bewerken',
            'view_item'     => 'Medewerker bekijken',
            'search_items'  => 'Medewerkers zoeken',
        ],
        'public'            => false,
        'has_archive'       => false,
        'publicly_queryable'=> false,
        'exclude_from_search' => true,
        'show_in_rest'      => true,
        'show_ui'           => true,
        'show_in_nav_menus' => false,
        'supports'          => ['title', 'thumbnail'],
        'rewrite'           => false,
        'menu_icon'         => 'dashicons-groups',
    ]);
}

add_action('init', 'arehbo_register_post_types');


function arehbo_register_taxonomies() {
    register_taxonomy('categorie', ['cursussen', 'diensten', 'vacatures'], [
        'labels' => [
            'name'              => 'Categorieën',
            'singular_name'     => 'Categorie',
            'search_items'      => 'Categorieën zoeken',
            'all_items'         => 'Alle categorieën',
            'edit_item'         => 'Categorie bewerken',
            'add_new_item'      => 'Nieuwe categorie toevoegen',
            'new_item_name'     => 'Naam nieuwe categorie',
        ],
        'hierarchical' => true,
        'public'       => true,
        'show_in_rest' => true,
        'rewrite'      => ['slug' => 'categorie'],
    ]);
}

add_action('init', 'arehbo_register_taxonomies');


add_action('wp_enqueue_scripts', function () {
    if (is_page_template('templates/page-dienst.php')) {
        wp_enqueue_style(
            'acf-block-usp-list',
            get_template_directory_uri() . '/blocks/usp-list/style.css',
            [],
            wp_get_theme()->get('Version')
        );
    }
});


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


add_action('pre_get_posts', function ($query) {
    if (!is_admin() && $query->is_main_query() && ($query->is_archive() || $query->is_home())) {
        $query->set('posts_per_page', 6);
    }
});

add_filter('upload_mimes', function ($mimes) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
});

add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {
    if (!$data['type']) {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if ($ext === 'svg' || $ext === 'svgz') {
            $data['type'] = 'image/svg+xml';
            $data['ext']  = $ext;
        }
    }
    return $data;
}, 10, 4);
