<?php
/*
 * Template Name: Cursuskalender
 */

get_header();

$page_title  = get_the_title();
$hero_title  = get_field('inschr_title');
$description = get_field('inschr_description');
$img_id      = get_field('inschr_image');
$usps        = get_field('inschr_usps');

$bg_class = ' bg-light';
$img_url  = $img_id ? wp_get_attachment_image_url($img_id, 'full') : '';
$img_alt  = $img_id ? (get_post_meta($img_id, '_wp_attachment_image_alt', true) ?: $page_title) : '';

$icon_user     = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>';
$icon_calendar = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/></svg>';
$icon_location = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>';
$icon_clock    = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>';
$icon_arrow    = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
$icon_close    = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26" fill="currentColor" aria-hidden="true"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>';
$icon_chevron  = '<svg class="course-card__chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" aria-hidden="true" focusable="false" fill="none"><path d="M4 9L12 17L20 9" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
$icon_phone    = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79a15.05 15.05 0 006.59 6.59l2.2-2.2a1 1 0 011.02-.24c1.12.37 2.33.57 3.57.57a1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1c0 1.24.2 2.45.57 3.57a1 1 0 01-.24 1.02l-2.21 2.2z"/></svg>';
$icon_email    = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>';

$phone     = get_field('footer_contact_phone', 'option');
$email     = get_field('footer_contact_email', 'option');
$schedule  = get_field('openingstijden', 'option');
$is_open   = arehbo_is_open_now($schedule);
$today     = arehbo_today_hours($schedule);
$next_open = arehbo_next_open_hours($schedule);

$categories = get_terms([
    'taxonomy'   => 'cursus_categorie',
    'hide_empty' => false,
]);
if (is_wp_error($categories)) {
    $categories = [];
}

?>

<main id="main-content" class="inschr-page">

    <div class="inschr-hero-bg<?= $bg_class; ?>">
    <div class="inschr-page__inner container">

        <nav class="inschr-breadcrumbs" aria-label="Breadcrumb">
            <a class="inschr-breadcrumbs__link" href="<?= esc_url(home_url('/')); ?>">Home</a>
            <span class="inschr-breadcrumbs__sep" aria-hidden="true">/</span>
            <span class="inschr-breadcrumbs__current" aria-current="page"><?= esc_html($page_title); ?></span>
        </nav>

        <hr class="inschr-divider">

        <div class="inschr-hero<?= !$img_url ? ' inschr-hero--no-image' : ''; ?>">

            <div class="inschr-hero__text">
                <?php if ($hero_title) : ?>
                    <h1 class="inschr-hero__title"><?= esc_html($hero_title); ?></h1>
                <?php endif; ?>
                <?php if ($description) : ?>
                    <div class="inschr-hero__description"><?= wp_kses_post($description); ?></div>
                <?php endif; ?>
                <?php if (!empty($usps)) : ?>
                    <div class="inschr-usps">
                        <?php get_template_part('components/usp-items', '', [
                            'items'     => $usps,
                            'show_icon' => true,
                        ]); ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($img_url) : ?>
                <div class="inschr-hero__image-wrap">
                    <img class="inschr-hero__image" src="<?= esc_url($img_url); ?>" alt="<?= esc_attr($img_alt); ?>" width="635" height="357" loading="eager">
                </div>
            <?php endif; ?>

        </div>

    </div>
    </div>

    <div class="inschr-filter-bg<?= $bg_class; ?>">
        <div class="inschr-filter-wrap container">
            <div class="inschr-filter-card">

                <div class="inschr-filter">
                    <div class="inschr-filter__left">
                        <span class="inschr-filter__title">Waar bent u naar opzoek?</span>
                        <span class="inschr-filter__desc">Selecteer categorieën</span>
                    </div>
                    <div class="inschr-filter__selects">
                        <div class="inschr-filter__select-wrap">
                            <select class="inschr-filter__select" id="inschr-filter-cat" data-role="categorie">
                                <option value="">Selecteer een categorie</option>
                                <?php foreach ($categories as $cat) : ?>
                                    <option value="<?= esc_attr($cat->slug); ?>"><?= esc_html($cat->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="inschr-filter__select-wrap">
                            <select class="inschr-filter__select" id="inschr-filter-cursus" data-role="cursus" disabled>
                                <option value="">Selecteer eerst een categorie</option>
                            </select>
                        </div>
                    </div>
                </div>

                <?php if ($phone || $email || !empty($schedule)) : ?>
                    <div class="inschr-contactbar">
                        <span class="inschr-contactbar__intro">Vragen? Neem gerust contact op</span>

                        <div class="inschr-contactbar__group">
                            <?php if (!empty($schedule)) :
                                $today_open  = $today['open'] ?? '';
                                $today_close = $today['close'] ?? '';
                                $nl_days = [1 => 'Maandag', 2 => 'Dinsdag', 3 => 'Woensdag', 4 => 'Donderdag', 5 => 'Vrijdag', 6 => 'Zaterdag', 7 => 'Zondag'];

                                if (!$is_open && $next_open) {
                                    $offset = (int) $next_open['offset'];
                                    if ($offset === 0) {
                                        $next_label = 'Vandaag';
                                    } elseif ($offset === 1) {
                                        $next_label = 'Morgen';
                                    } else {
                                        $next_label = $nl_days[$next_open['day']] ?? '';
                                    }
                                }
                            ?>
                                <span class="inschr-contactbar__status inschr-contactbar__status--<?= $is_open ? 'open' : 'closed'; ?>">
                                    <span class="inschr-contactbar__dot" aria-hidden="true"></span>
                                    <span>
                                        <?php if ($is_open) : ?>
                                            Bereikbaar van <?= esc_html($today_open); ?> tot <?= esc_html($today_close); ?>
                                        <?php elseif ($next_open) : ?>
                                            <?= esc_html($next_label); ?> bereikbaar van <?= esc_html($next_open['open']); ?> tot <?= esc_html($next_open['close']); ?>
                                        <?php endif; ?>
                                    </span>
                                </span>
                            <?php endif; ?>

                            <?php if ($phone) : ?>
                                <a class="inschr-contactbar__item" href="tel:<?= esc_attr(preg_replace('/\s+/', '', $phone)); ?>">
                                    <?= esc_html($phone); ?>
                                </a>
                            <?php endif; ?>

                            <?php if ($email) : ?>
                                <a class="inschr-contactbar__item" href="mailto:<?= esc_attr($email); ?>">
                                    <?= esc_html($email); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <div class="inschr-cards-bg<?= $bg_class; ?>">
    <div class="inschr-cards-wrap container">

        <div class="inschr-cards__placeholder" data-inschr-placeholder>
            <h3 class="inschr-cards__empty-title">Selecteer een categorie</h3>
            <p>Na uw eerste filterselectie laten we de beschikbare cursussen zien.</p>
        </div>

        <div class="inschr-cards__empty" hidden data-inschr-empty-state>
            <h3 class="inschr-cards__empty-title">Geen cursussen gevonden</h3>
            <p>
                Er zijn geen cursussen gevonden voor deze filter.
                Probeer een andere selectie of neem contact op
                <?php if ($email) : ?>
                    via <a href="mailto:<?= esc_attr($email); ?>"><?= esc_html($email); ?></a>
                <?php else : ?>
                    met ons
                <?php endif; ?>
                <?php if ($phone) : ?>
                    of bel <a href="tel:<?= esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?= esc_html($phone); ?></a>
                <?php endif; ?>.
            </p>
        </div>

        <div class="inschr-cards" data-inschr-cards></div>

    </div>
    </div>

</main>

<?php get_footer(); ?>
