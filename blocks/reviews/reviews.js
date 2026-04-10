(function () {

    function updateReadMoreButtons() {
        document.querySelectorAll('.reviews-block__card').forEach(function (card) {
            var text = card.querySelector('.reviews-block__card-text');
            var button = card.querySelector('.reviews-block__read-more');
            if (!text || !button) return;

            var isClamped = text.scrollHeight > text.clientHeight + 1;
            button.classList.toggle('is-visible', isClamped);
            button.hidden = !isClamped;
        });
    }

    // ── Swiper ─────────────────────────────────────────────
    if (typeof Swiper !== 'undefined') {
        document.querySelectorAll('.slider--reviews').forEach(function (wrapper) {
            new Swiper(wrapper.querySelector('.swiper'), {
                slidesPerView: 'auto',
                spaceBetween: 40,
                observer: true,
                observeParents: true,
                navigation: {
                    prevEl: wrapper.querySelector('.slider-nav__btn--prev'),
                    nextEl: wrapper.querySelector('.slider-nav__btn--next'),
                    disabledClass: 'is-disabled',
                },
                pagination: {
                    el: wrapper.querySelector('.swiper-pagination'),
                    type: 'progressbar',
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1.1,
                        spaceBetween: 20,
                    },
                    769: {
                        slidesPerView: 'auto',
                        spaceBetween: 40,
                    },
                },
            });
        });
    }

    updateReadMoreButtons();
    window.addEventListener('load', updateReadMoreButtons);
    window.addEventListener('resize', updateReadMoreButtons);

    // ── Modal ──────────────────────────────────────────────
    function openModal(modal) {
        modal.removeAttribute('hidden');
        document.body.style.overflow = 'hidden';
        var close = modal.querySelector('.reviews-block__modal-close');
        if (close) close.focus();
    }

    function closeModal(modal) {
        modal.setAttribute('hidden', '');
        document.body.style.overflow = '';
    }

    document.addEventListener('click', function (e) {
        // Open
        var btn = e.target.closest('.reviews-block__read-more');
        if (btn) {
            var id = btn.getAttribute('data-modal');
            var modal = document.getElementById(id);
            if (modal) openModal(modal);
            return;
        }

        // Close via overlay or close button
        var closeBtn = e.target.closest('.reviews-block__modal-close');
        if (closeBtn) {
            var modal = closeBtn.closest('.reviews-block__modal');
            if (modal) closeModal(modal);
            return;
        }

        var overlay = e.target.closest('.reviews-block__modal-overlay');
        if (overlay) {
            var modal = overlay.closest('.reviews-block__modal');
            if (modal) closeModal(modal);
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        var open = document.querySelector('.reviews-block__modal:not([hidden])');
        if (open) closeModal(open);
    });

}());
