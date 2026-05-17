<?php
/*
 * Template Name: Cursuskalender
 */

get_header();

$page_title  = get_the_title();
$hero_title  = get_field('inschr_title');
$description = get_field('inschr_description');
$img_id      = get_field('inschr_image');

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

$form_page_posts = get_posts([
    'post_type'      => 'page',
    'meta_key'       => '_wp_page_template',
    'meta_value'     => 'templates/page-inschrijven-form.php',
    'posts_per_page' => 1,
    'fields'         => 'ids',
]);
$form_page_url = !empty($form_page_posts) ? get_permalink($form_page_posts[0]) : '';

$demo_cards = [
    [
        'status'    => 'vol',
        'name'      => 'BHV cursus',
        'available' => 0,
        'days_count'=> 3,
        'location'  => 'Amsterdam',
        'days' => [
            ['label' => 'Dagdeel 1 (maandag)',  'date' => '11-05-2026', 'time' => '08:30 tot 16:30'],
            ['label' => 'Dagdeel 2 (dinsdag)',  'date' => '12-05-2026', 'time' => '08:30 tot 16:30'],
            ['label' => 'Dagdeel 3 (woensdag)', 'date' => '13-05-2026', 'time' => '08:30 tot 16:30'],
        ],
        'dates_ts' => [
            mktime(0, 0, 0, 5, 11, 2026),
            mktime(0, 0, 0, 5, 12, 2026),
            mktime(0, 0, 0, 5, 13, 2026),
        ],
    ],
    [
        'status'    => 'bijna-vol',
        'name'      => 'BHV cursus',
        'available' => 2,
        'days_count'=> 5,
        'location'  => 'Rotterdam',
        'prijs'     => '533,- per cursist',
        'days' => [
            ['label' => 'Dagdeel 1 (maandag)',   'date' => '18-05-2026', 'time' => '08:30 tot 16:30'],
            ['label' => 'Dagdeel 2 (dinsdag)',   'date' => '19-05-2026', 'time' => '08:30 tot 16:30'],
            ['label' => 'Dagdeel 3 (woensdag)',  'date' => '20-05-2026', 'time' => '08:30 tot 16:30'],
            ['label' => 'Dagdeel 4 (donderdag)', 'date' => '21-05-2026', 'time' => '08:30 tot 16:30'],
            ['label' => 'Dagdeel 5 (vrijdag)',   'date' => '22-05-2026', 'time' => '08:30 tot 16:30'],
        ],
        'dates_ts' => [
            mktime(0, 0, 0, 5, 18, 2026),
            mktime(0, 0, 0, 5, 19, 2026),
            mktime(0, 0, 0, 5, 20, 2026),
            mktime(0, 0, 0, 5, 21, 2026),
            mktime(0, 0, 0, 5, 22, 2026),
        ],
    ],
    [
        'status'    => 'beschikbaar',
        'name'      => 'Reanimatiecursus',
        'available' => 12,
        'days_count'=> 2,
        'location'  => 'Ede',
        'prijs'     => '533,- per cursist',
        'days' => [
            ['label' => 'Dagdeel 1 (donderdag)', 'date' => '28-05-2026', 'time' => '09:00 tot 17:00'],
            ['label' => 'Dagdeel 2 (vrijdag)',   'date' => '29-05-2026', 'time' => '09:00 tot 17:00'],
        ],
        'dates_ts' => [
            mktime(0, 0, 0, 5, 28, 2026),
            mktime(0, 0, 0, 5, 29, 2026),
        ],
    ],
];

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

        <div class="inschr-hero">

            <div class="inschr-hero__text">
                <?php if ($hero_title) : ?>
                    <h1 class="inschr-hero__title"><?= esc_html($hero_title); ?></h1>
                <?php endif; ?>
                <?php if ($description) : ?>
                    <div class="inschr-hero__description"><?= wp_kses_post($description); ?></div>
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
            <div class="inschr-filter">
                <div class="inschr-filter__left">
                    <span class="inschr-filter__title">Waar bent u naar opzoek?</span>
                    <span class="inschr-filter__desc">Selecteer categorieën</span>
                </div>
                <div class="inschr-filter__right">
                    <button class="inschr-filter__btn is-active" type="button">Alle cursussen</button>
                    <button class="inschr-filter__btn" type="button">BHV</button>
                </div>
            </div>
        </div>
    </div>

    <div class="inschr-cards-bg<?= $bg_class; ?>">
    <div class="inschr-cards container">

        <?php foreach ($demo_cards as $card_index => $card) :
            $status   = $card['status'];
            $avail    = $card['available'];
            $days     = $card['days'];
            $dates_ts = $card['dates_ts'];
            $first_ts = $dates_ts[0] ?? null;

            $badge_url = '';
            if ($status !== 'vol' && $form_page_url) {
                $badge_url = add_query_arg([
                    'course'      => $card['name'],
                    'locatie'     => $card['location'],
                    'beschikbaar' => $card['available'],
                    'prijs'       => $card['prijs'] ?? '',
                    'dagdelen'    => base64_encode(wp_json_encode($card['days'])),
                ], $form_page_url);
            }
            $badge_tag   = $badge_url ? 'a' : 'div';
            $badge_attrs = $badge_url ? ' href="' . esc_url($badge_url) . '"' : '';
        ?>

        <article class="course-card course-card--<?= esc_attr($status); ?>">

            <aside class="course-card__dates">
                <?php if ($first_ts) : ?>
                    <div class="course-card__date-big"><?= esc_html(arehbo_format_nl_date($first_ts)); ?></div>
                    <hr class="course-card__dates-sep">
                <?php endif; ?>
                <ul class="course-card__dates-meta">
                    <?php if ($card['location']) : ?>
                        <li class="course-card__meta-item">
                            <?= $icon_location; ?>
                            <span><?= esc_html($card['location']); ?></span>
                        </li>
                    <?php endif; ?>
                    <li class="course-card__meta-item">
                        <?= $icon_calendar; ?>
                        <span><?= esc_html($card['days_count']); ?> <?= $card['days_count'] === 1 ? 'lesdag' : 'lesdagen'; ?></span>
                    </li>
                </ul>
            </aside>

            <div class="course-card__main">
                <h3 class="course-card__name"><?= esc_html($card['name']); ?></h3>
                <hr class="course-card__main-sep">
                <ul class="course-card__lesdagen">
                    <?php foreach ($days as $i => $dag) : ?>
                        <li class="course-card__lesdag">
                            <span class="course-card__lesdag-label">Lesdag <?= esc_html($i + 1); ?></span>
                            <span class="course-card__lesdag-date">
                                <?= $icon_calendar; ?>
                                <span><?= esc_html(arehbo_format_nl_date($dates_ts[$i] ?? null)); ?></span>
                            </span>
                            <span class="course-card__lesdag-time">
                                <?= $icon_clock; ?>
                                <span><?= esc_html($dag['time']); ?></span>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="course-card__action">
                <<?= $badge_tag; ?> class="course-card__badge"<?= $badge_attrs; ?>>
                    <span class="course-card__badge-text"><?= $status === 'vol' ? 'VOLGEBOEKT' : 'INSCHRIJVEN'; ?></span>
                    <?php if ($status !== 'vol') : ?>
                        <span class="course-card__badge-icon">
                            <?= $icon_arrow; ?>
                        </span>
                    <?php endif; ?>
                </<?= $badge_tag; ?>>
                <span class="course-card__plekken">
                    <?php if ($status === 'vol') : ?>
                        Geen plekken beschikbaar
                    <?php else : ?>
                        <?= esc_html($avail); ?> <?= $avail === 1 ? 'plek' : 'plekken'; ?> beschikbaar
                    <?php endif; ?>
                </span>
            </div>

        </article>

        <?php endforeach; ?>

    </div>
    </div>

</main>

<?php get_footer(); ?>
