<?php

add_action('pre_get_posts', function ($query) {
    if (!is_admin() && $query->is_main_query() && ($query->is_archive() || $query->is_home())) {
        $query->set('posts_per_page', 6);
    }
});

