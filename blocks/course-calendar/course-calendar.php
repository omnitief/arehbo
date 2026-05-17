<?php

$space   = get_spacing_class(get_field('space'));
$full_id = get_full_id(get_field('id'));
$title   = get_field('title');

global $wpdb, $post;

$course_post_id = $post ? $post->ID : get_the_ID();
$course_id      = $course_post_id ? get_field('id_visual_systems', $course_post_id) : '';
$course_name    = $course_post_id ? get_the_title($course_post_id) : '';
$course_loc     = $course_post_id ? get_field('locatie', $course_post_id) : '';

$appointments = [];
if ($course_id) {
    $appointments = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT appointment_id, start_date, end_date, room, location, places_left
            FROM {$wpdb->prefix}custom_visualsystems_appointments
            WHERE course_id = %s
            AND parent_id = 0
            ORDER BY start_date ASC",
            $course_id
        ),
        ARRAY_A
    );
}

$phone = get_field('footer_contact_phone', 'option');
$email = get_field('footer_contact_email', 'option');

$form_page_posts = get_posts([
    'post_type'      => 'page',
    'meta_key'       => '_wp_page_template',
    'meta_value'     => 'templates/page-inschrijven-form.php',
    'posts_per_page' => 1,
    'fields'         => 'ids',
]);
$form_page_url = !empty($form_page_posts) ? get_permalink($form_page_posts[0]) : '';

$icon_user     = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>';
$icon_calendar = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z"/></svg>';
$icon_location = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>';
$icon_clock    = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>';
$icon_arrow    = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="none" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
$icon_close    = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" height="26" fill="currentColor" aria-hidden="true"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>';
$icon_chevron  = '<svg class="course-card__chevron" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="14" height="14" aria-hidden="true" focusable="false" fill="none"><path d="M4 9L12 17L20 9" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';

$cards = [];
foreach ($appointments as $appointment) {

    $appointment_id = (int) $appointment['appointment_id'];
    $places_left    = max(0, (int) $appointment['places_left']);

    $sibling_dates = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT start_date, end_date
            FROM {$wpdb->prefix}custom_visualsystems_appointments
            WHERE parent_id = %d
            ORDER BY start_date ASC",
            $appointment_id
        ),
        ARRAY_A
    );

    $all_dates = array_merge(
        [['start_date' => $appointment['start_date'], 'end_date' => $appointment['end_date']]],
        $sibling_dates
    );

    $time_label = date_i18n('H:i', $appointment['start_date']) . ' tot ' . date_i18n('H:i', $appointment['end_date']);

    $days = [];
    foreach ($all_dates as $i => $date_row) {
        $weekday = date_i18n('l', $date_row['start_date']);
        $days[] = [
            'label' => 'Dagdeel ' . ($i + 1) . ' (' . $weekday . ')',
            'date'  => date_i18n('d-m-Y', $date_row['start_date']),
            'time'  => $time_label,
        ];
    }

    if ($places_left === 0) {
        $status = 'vol';
    } elseif ($places_left < 4) {
        $status = 'bijna-vol';
    } else {
        $status = 'beschikbaar';
    }

    $cards[] = [
        'status'      => $status,
        'name'        => $course_name,
        'available'   => $places_left,
        'days_count'  => count($all_dates),
        'location'    => $course_loc,
        'days'        => $days,
        'dates_ts'    => array_map(fn($d) => $d['start_date'], $all_dates),
        'appointment' => $appointment_id,
    ];
}

?>

<section <?= $full_id; ?> class="course-calendar bg-light">
    <div class="<?= esc_attr($space); ?>">
        <div class="container">

            <?php if ($title) : ?>
                <h2 class="course-calendar__title"><?= esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if (empty($cards)) : ?>

                <div class="course-calendar__empty">
                    <p>
                        Sorry, momenteel hebben we geen cursus vrij waarop aangemeld kan worden.
                        Toch aanmelden? Stuur een mail naar
                        <?php if ($email) : ?>
                            <a href="mailto:<?= esc_attr($email); ?>"><?= esc_html($email); ?></a>
                        <?php else : ?>
                            ons
                        <?php endif; ?>,
                        of bel naar
                        <?php if ($phone) : ?>
                            <a href="tel:<?= esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?= esc_html($phone); ?></a>
                        <?php else : ?>
                            ons
                        <?php endif; ?>.
                    </p>
                </div>

            <?php else : ?>

                <div class="course-calendar__cards">

                    <?php foreach ($cards as $card) :
                        $status   = $card['status'];
                        $avail    = $card['available'];
                        $days     = $card['days'];
                        $dates_ts = $card['dates_ts'];
                        $first_ts = $dates_ts[0] ?? null;

                        $badge_url = '';
                        if ($status !== 'vol' && $form_page_url) {
                            $badge_url = add_query_arg([
                                'appointment' => $card['appointment'],
                                'course'      => $card['name'],
                                'locatie'     => $card['location'],
                                'beschikbaar' => $card['available'],
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

            <?php endif; ?>

        </div>
    </div>
</section>
