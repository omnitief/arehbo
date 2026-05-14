<?php

$marquee_text = get_field('footer_marquee_text', 'option') ?: 'AREHBO';
$marquee_bg   = 'light';

$logo_id    = get_field('footer_logo', 'option');

$contact_title   = get_field('footer_contact_title', 'option');
$contact_address = get_field('footer_contact_address', 'option');
$contact_phone   = get_field('footer_contact_phone', 'option');
$contact_email   = get_field('footer_contact_email', 'option');

$social_title = get_field('footer_social_title', 'option');
$social_links = get_field('footer_social_links', 'option') ?: [];

$nav_title     = get_field('footer_nav_title', 'option');
$nav_links     = get_field('footer_nav_links', 'option') ?: [];
$partner_logos = get_field('footer_partner_logos', 'option') ?: [];
$bottom_links  = get_field('footer_bottom_links', 'option') ?: [];

$copyright_text        = get_field('footer_copyright_text', 'option');
$copyright_links_left  = get_field('footer_copyright_links_left', 'option') ?: [];
$copyright_links_right = get_field('footer_copyright_links_right', 'option') ?: [];

?>

<div class="footer-marquee footer-marquee--<?= esc_attr($marquee_bg); ?>" aria-hidden="true">
    <div class="footer-marquee__track">
        <?php for ($i = 0; $i < 12; $i++) : ?>
            <span class="footer-marquee__item"><?= esc_html($marquee_text); ?></span>
        <?php endfor; ?>
    </div>
</div>

<?php get_template_part('components/colorbar'); ?>

<footer class="site-footer">
    <div class="container">

        <?php if ($logo_id) :
            $logo_url = wp_get_attachment_image_url($logo_id, 'full');
            $logo_alt = get_post_meta($logo_id, '_wp_attachment_image_alt', true) ?: get_bloginfo('name');
        ?>
            <div class="footer-logo">
                <a href="<?= esc_url(home_url('/')); ?>" aria-label="<?= esc_attr(get_bloginfo('name')); ?>">
                    <img
                        src="<?= esc_url($logo_url); ?>"
                        alt="<?= esc_attr($logo_alt); ?>"
                        loading="lazy"
                    >
                </a>
            </div>
        <?php endif; ?>

        <div class="footer-main-grid">

            <div class="footer-contact">

                <?php if ($contact_title) : ?>
                    <h6 class="footer-section-title"><?= esc_html($contact_title); ?></h6>
                <?php endif; ?>

                <?php if ($contact_address) : ?>
                    <div class="footer-contact__address">
                        <?= wp_kses_post($contact_address); ?>
                    </div>
                <?php endif; ?>

                <?php if ($contact_phone || $contact_email) : ?>
                    <div class="footer-contact__details">
                        <?php if ($contact_phone) : ?>
                            <a
                                class="footer-contact__link"
                                href="tel:<?= esc_attr(preg_replace('/\s+/', '', $contact_phone)); ?>"
                            ><?= esc_html($contact_phone); ?></a>
                        <?php endif; ?>
                        <?php if ($contact_email) : ?>
                            <a
                                class="footer-contact__link"
                                href="mailto:<?= esc_attr($contact_email); ?>"
                            ><?= esc_html($contact_email); ?></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>

            <?php if (!empty($social_links)) : ?>
                <div class="footer-social">

                    <?php if ($social_title) : ?>
                        <h6 class="footer-section-title"><?= esc_html($social_title); ?></h6>
                    <?php endif; ?>

                    <ul class="footer-social__list">
                        <?php foreach ($social_links as $link) :
                            if (empty($link['url'])) continue;
                        ?>
                            <li>
                                <a
                                    class="footer-social__link"
                                    href="<?= esc_url($link['url']); ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                ><?= esc_html($link['label']); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                </div>
            <?php endif; ?>

            <?php if (!empty($nav_links)) : ?>
                <nav class="footer-nav" aria-label="Footer navigatie">
                    <?php if ($nav_title) : ?>
                        <h6 class="footer-section-title"><?= esc_html($nav_title); ?></h6>
                    <?php endif; ?>
                    <ul class="footer-nav__list">
                        <?php foreach ($nav_links as $item) :
                            $link = $item['link'] ?? [];
                            if (empty($link['url'])) continue;
                        ?>
                            <li class="footer-nav__item">
                                <a
                                    class="footer-nav__link"
                                    href="<?= esc_url($link['url']); ?>"
                                    target="<?= esc_attr($link['target'] ?: '_self'); ?>"
                                ><?= esc_html($link['title']); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            <?php endif; ?>

        </div>

        <?php if (!empty($partner_logos)) : ?>
            <div class="footer-partners">
                <div class="footer-partners__grid">
                    <?php foreach ($partner_logos as $item) :
                        $p_id  = $item['logo'] ?? null;
                        if (!$p_id) continue;
                        $p_url = wp_get_attachment_image_url($p_id, 'medium');
                        $p_alt = get_post_meta($p_id, '_wp_attachment_image_alt', true) ?: '';
                        $p_link = $item['link_url'] ?? '';
                    ?>
                        <div class="footer-partner-card">
                            <?php if ($p_link) : ?>
                                <a href="<?= esc_url($p_link); ?>" target="_blank" rel="noopener noreferrer" tabindex="-1" aria-hidden="true">
                            <?php endif; ?>
                                <img src="<?= esc_url($p_url); ?>" alt="<?= esc_attr($p_alt); ?>" loading="lazy">
                            <?php if ($p_link) : ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($bottom_links)) :
            $bottom_count = count($bottom_links);
        ?>
            <div class="footer-bottom-nav">
                <button class="footer-bottom-nav__toggle" aria-expanded="false">
                    Landingspagina's uitklappen
                    <svg class="footer-bottom-nav__chevron" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <nav class="footer-bottom-nav__inner" aria-label="Site links">
                    <ul class="footer-bottom-nav__list">
                        <?php foreach ($bottom_links as $i => $item) :
                            $link = $item['link'] ?? [];
                            if (empty($link['url'])) continue;
                        ?>
                            <li>
                                <a
                                    class="footer-bottom-nav__link"
                                    href="<?= esc_url($link['url']); ?>"
                                    target="<?= esc_attr($link['target'] ?: '_self'); ?>"
                                ><?= esc_html($link['title']); ?></a>
                            </li>
                            <?php if ($i < $bottom_count - 1) : ?>
                                <li aria-hidden="true"><span class="footer-bottom-nav__sep">-</span></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>

        <?php if ($copyright_text || !empty($copyright_links_left) || !empty($copyright_links_right)) : ?>
            <div class="footer-copyright">

                <?php if ($copyright_text) : ?>
                    <p class="footer-copyright__text"><?= esc_html($copyright_text); ?></p>
                <?php endif; ?>

                <?php if (!empty($copyright_links_left)) : ?>
                    <div class="footer-copyright__links">
                        <?php foreach ($copyright_links_left as $item) :
                            $link = $item['link'] ?? [];
                            if (empty($link['url'])) continue;
                        ?>
                            <a
                                href="<?= esc_url($link['url']); ?>"
                                target="<?= esc_attr($link['target'] ?: '_self'); ?>"
                            ><?= esc_html($link['title']); ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($copyright_links_right)) : ?>
                    <div class="footer-copyright__links footer-copyright__links--right">
                        <?php foreach ($copyright_links_right as $item) :
                            $link = $item['link'] ?? [];
                            if (empty($link['url'])) continue;
                        ?>
                            <a
                                href="<?= esc_url($link['url']); ?>"
                                target="<?= esc_attr($link['target'] ?: '_self'); ?>"
                            ><?= esc_html($link['title']); ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>

    </div>
</footer>

<script>
(function () {
    /* ── Bottom-nav toggle ── */
    var toggle = document.querySelector('.footer-bottom-nav__toggle');
    if (toggle) {
        var inner = document.querySelector('.footer-bottom-nav__inner');
        toggle.addEventListener('click', function () {
            var expanded = this.getAttribute('aria-expanded') === 'true';
            if (expanded) {
                inner.style.maxHeight = '0';
                this.setAttribute('aria-expanded', 'false');
            } else {
                inner.style.maxHeight = inner.scrollHeight + 'px';
                this.setAttribute('aria-expanded', 'true');
            }
        });
    }

    /* ── Scroll-driven marquee ── */
    var track = document.querySelector('.footer-marquee__track');
    if (track) {
        var speed = 0.5;
        window.addEventListener('scroll', function () {
            var px = window.pageYOffset * speed;
            track.style.transform = 'translateX(-' + (px % (track.scrollWidth / 2)) + 'px)';
        }, { passive: true });
    }
}());
</script>

<?php wp_footer(); ?>
</body>
</html>
