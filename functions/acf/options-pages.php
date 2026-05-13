<?php

if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => 'Header',
        'menu_title' => 'Header',
        'menu_slug'  => 'header-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
        'icon_url'   => 'dashicons-layout',
        'position'   => 60,
    ]);

    acf_add_options_page([
        'page_title' => 'Footer',
        'menu_title' => 'Footer',
        'menu_slug'  => 'footer-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
        'icon_url'   => 'dashicons-align-center',
        'position'   => 61,
    ]);

    acf_add_options_page([
        'page_title' => 'Blokken',
        'menu_title' => 'Blokken',
        'menu_slug'  => 'blocks-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
        'icon_url'   => 'dashicons-block-default',
        'position'   => 62,
    ]);
}
