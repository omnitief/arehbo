<?php

function arehbo_register_taxonomies() {
    register_taxonomy('cursus_categorie', ['cursussen'], [
        'labels' => [
            'name'          => 'Cursus categorieën',
            'singular_name' => 'Cursus categorie',
            'search_items'  => 'Categorieën zoeken',
            'all_items'     => 'Alle categorieën',
            'edit_item'     => 'Categorie bewerken',
            'add_new_item'  => 'Nieuwe categorie toevoegen',
            'new_item_name' => 'Naam nieuwe categorie',
        ],
        'hierarchical' => true,
        'public'       => true,
        'show_in_rest' => true,
        'rewrite'      => ['slug' => 'cursus-categorie'],
    ]);

    register_taxonomy('dienst_categorie', ['diensten'], [
        'labels' => [
            'name'          => 'Dienst categorieën',
            'singular_name' => 'Dienst categorie',
            'search_items'  => 'Categorieën zoeken',
            'all_items'     => 'Alle categorieën',
            'edit_item'     => 'Categorie bewerken',
            'add_new_item'  => 'Nieuwe categorie toevoegen',
            'new_item_name' => 'Naam nieuwe categorie',
        ],
        'hierarchical' => true,
        'public'       => true,
        'show_in_rest' => true,
        'rewrite'      => ['slug' => 'dienst-categorie'],
    ]);
}

add_action('init', 'arehbo_register_taxonomies');

function arehbo_taxonomy_for_post_type($post_type) {
    $map = [
        'cursussen' => 'cursus_categorie',
        'diensten'  => 'dienst_categorie',
    ];
    return $map[$post_type] ?? '';
}

