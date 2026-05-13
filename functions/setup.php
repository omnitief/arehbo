<?php

add_filter('show_admin_bar', '__return_false');

function arehbo_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('editor-styles');
}

add_action('after_setup_theme', 'arehbo_theme_setup');

