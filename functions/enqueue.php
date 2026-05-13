<?php

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
        get_template_directory_uri() . '/styles/components/header.css',
        ['arehbo-theme'],
        wp_get_theme()->get('Version')
    );

    wp_enqueue_style(
        'arehbo-footer',
        get_template_directory_uri() . '/styles/components/footer.css',
        ['arehbo-theme'],
        wp_get_theme()->get('Version')
    );

    wp_enqueue_style(
        'arehbo-gravity-forms',
        get_template_directory_uri() . '/styles/components/gravity-forms.css',
        ['arehbo-theme'],
        wp_get_theme()->get('Version')
    );

    if (is_singular('post')) {
        wp_enqueue_style(
            'arehbo-blogs-block',
            get_template_directory_uri() . '/styles/blocks/blogs.css',
            ['arehbo-theme'],
            wp_get_theme()->get('Version')
        );
        wp_enqueue_style(
            'acf-block-cta',
            get_template_directory_uri() . '/styles/blocks/cta.css',
            ['arehbo-theme'],
            wp_get_theme()->get('Version')
        );
        wp_enqueue_style(
            'arehbo-single',
            get_template_directory_uri() . '/styles/pages/single.css',
            ['arehbo-blogs-block', 'acf-block-cta'],
            wp_get_theme()->get('Version')
        );
    }

    if (is_archive() || is_home()) {
        wp_enqueue_style(
            'arehbo-blogs-block',
            get_template_directory_uri() . '/styles/blocks/blogs.css',
            ['arehbo-theme'],
            wp_get_theme()->get('Version')
        );
        wp_enqueue_style(
            'acf-block-cta',
            get_template_directory_uri() . '/styles/blocks/cta.css',
            ['arehbo-theme'],
            wp_get_theme()->get('Version')
        );
        wp_enqueue_style(
            'arehbo-archive',
            get_template_directory_uri() . '/styles/pages/archive.css',
            ['arehbo-blogs-block', 'acf-block-cta'],
            wp_get_theme()->get('Version')
        );
    }

    if (is_singular('diensten')) {
        wp_enqueue_style(
            'arehbo-template-dienst',
            get_template_directory_uri() . '/styles/templates/template-dienst.css',
            ['arehbo-theme'],
            wp_get_theme()->get('Version')
        );
        wp_enqueue_style(
            'acf-block-usp-list',
            get_template_directory_uri() . '/styles/blocks/usp-list.css',
            [],
            wp_get_theme()->get('Version')
        );
    }

    if (is_singular('cursussen')) {
        wp_enqueue_style(
            'arehbo-template-cursus',
            get_template_directory_uri() . '/styles/templates/template-cursus.css',
            ['arehbo-theme'],
            wp_get_theme()->get('Version')
        );
    }

    if (is_singular('vacatures')) {
        wp_enqueue_style(
            'arehbo-single',
            get_template_directory_uri() . '/styles/pages/single.css',
            ['arehbo-theme'],
            wp_get_theme()->get('Version')
        );
    }

    if (is_page_template('templates/page-inschrijven.php')) {
        wp_enqueue_style(
            'arehbo-template-inschrijven',
            get_template_directory_uri() . '/styles/templates/template-inschrijven.css',
            ['arehbo-theme'],
            wp_get_theme()->get('Version')
        );
    }

    if (is_page_template('templates/page-inschrijven-form.php')) {
        wp_enqueue_style(
            'arehbo-template-inschrijven-form',
            get_template_directory_uri() . '/styles/templates/template-inschrijven-form.css',
            ['arehbo-theme'],
            wp_get_theme()->get('Version')
        );
    }

    if (is_page_template('templates/page-formulier.php')) {
        wp_enqueue_style(
            'arehbo-template-formulier',
            get_template_directory_uri() . '/styles/templates/template-formulier.css',
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
