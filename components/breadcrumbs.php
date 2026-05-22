<?php

$current_label = $args['current_label'] ?? '';
if (!$current_label) {
    $current_label = is_404() ? '404' : wp_get_document_title();
}

$is_rankmath = function_exists('rank_math_the_breadcrumbs');

if ($is_rankmath) {
    ob_start();
    // Rank Math will output its own markup; we wrap it so existing styling can be applied via CSS below.
    rank_math_the_breadcrumbs();
    $rm_html = trim(ob_get_clean());
    if ($rm_html) : ?>
        <nav class="breadcrumbs breadcrumbs--rankmath" aria-label="Breadcrumb">
            <?= $rm_html; ?>
        </nav>
        <?php
        return;
    endif;
}
?>

<nav class="breadcrumbs" aria-label="Breadcrumb">
    <a class="breadcrumbs__link" href="<?= esc_url(home_url('/')); ?>">Home</a>
    <span class="breadcrumbs__sep" aria-hidden="true">/</span>
    <span class="breadcrumbs__current" aria-current="page"><?= esc_html($current_label); ?></span>
</nav>
