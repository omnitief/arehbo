(function () {
    'use strict';

    /* ── Bottom-nav toggle ── */
    var toggle = document.querySelector('.footer-bottom-nav__toggle');
    if (toggle) {
        var inner = document.querySelector('.footer-bottom-nav__inner');
        toggle.addEventListener('click', function () {
            var expanded = this.getAttribute('aria-expanded') === 'true';
            if (expanded) {
                if (inner) inner.style.maxHeight = '0';
                this.setAttribute('aria-expanded', 'false');
            } else {
                if (inner) inner.style.maxHeight = inner.scrollHeight + 'px';
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

