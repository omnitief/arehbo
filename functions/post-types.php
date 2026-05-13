<?php

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
        'public'              => false,
        'has_archive'         => false,
        'publicly_queryable'  => false,
        'exclude_from_search' => true,
        'show_in_rest'        => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => false,
        'supports'            => ['title', 'thumbnail'],
        'rewrite'             => false,
        'menu_icon'           => 'dashicons-groups',
    ]);
}

add_action('init', 'arehbo_register_post_types');

