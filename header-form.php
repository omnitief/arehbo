<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$logo_id   = get_field('logo', 'option');
$logo_url  = $logo_id ? wp_get_attachment_image_url($logo_id, 'full') : '';
$logo_alt  = $logo_id ? (get_post_meta($logo_id, '_wp_attachment_image_alt', true) ?: get_bloginfo('name')) : get_bloginfo('name');

$cursuskalender_page = function_exists('arehbo_option_page_link_post') ? arehbo_option_page_link_post('cursuskalender_page') : null;

if ($cursuskalender_page) {
    $back_url = get_permalink($cursuskalender_page);
} else {
    $inschrijven_page = get_page_by_path('inschrijven');
    $back_url         = $inschrijven_page ? get_permalink($inschrijven_page) : home_url('/');
}

$icon_arrow_left = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="none" aria-hidden="true"><path d="M19 12H5M5 12L11 18M5 12L11 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
?>

<header class="site-header site-header--form bg-light-blue" role="banner">
    <div class="site-header__bar">
        <div class="site-header__inner site-header__inner--form">

            <a class="site-header-form__back" href="<?= esc_url($back_url); ?>">
                <?= $icon_arrow_left; ?>
                <span>Terug naar overzicht</span>
            </a>

            <a class="site-header__logo site-header__logo--center" href="<?= esc_url(home_url('/')); ?>" aria-label="<?= esc_attr(get_bloginfo('name')); ?>">
                <?php if ($logo_url) : ?>
                    <img src="<?= esc_url($logo_url); ?>" alt="<?= esc_attr($logo_alt); ?>" height="40" loading="eager">
                <?php else : ?>
                    <?= esc_html(get_bloginfo('name')); ?>
                <?php endif; ?>
            </a>

            <span class="site-header-form__spacer" aria-hidden="true"></span>

        </div>
    </div>
</header>
