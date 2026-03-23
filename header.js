(function () {
    'use strict';

    var hamburger  = document.querySelector('.hamburger');
    var mobileMenu = document.getElementById('mobile-menu');
    var track      = document.getElementById('mobile-track');
    var viewport   = mobileMenu ? mobileMenu.querySelector('.mobile-menu__viewport') : null;
    var headerBar  = document.querySelector('.site-header__bar');

    if (!hamburger || !mobileMenu) return;

    function updateBarVars() {
        if (!headerBar) return;
        document.documentElement.style.setProperty('--bar-height', headerBar.offsetHeight + 'px');
        document.documentElement.style.setProperty('--header-bottom', headerBar.getBoundingClientRect().bottom + 'px');
    }
    updateBarVars();
    window.addEventListener('resize', updateBarVars);

    var overlay = document.createElement('div');
    overlay.className = 'mobile-overlay';
    document.body.appendChild(overlay);
    overlay.addEventListener('click', closeMenu);

    function setMenuHeight(index) {
        if (!viewport || !track) return;
        var panels = track.querySelectorAll('.mobile-menu__panel');
        if (panels[index]) {
            var content = panels[index].querySelector('.mobile-menu__content');
            if (content) {
                var barBottom = headerBar ? headerBar.getBoundingClientRect().bottom : 80;
                var maxAvailable = window.innerHeight - barBottom - 20;
                var targetHeight = Math.min(content.offsetHeight, maxAvailable);
                viewport.style.height = targetHeight + 'px';
                panels.forEach(function (p, i) {
                    p.style.height = i === index ? targetHeight + 'px' : '';
                });
            }
        }
    }

    function positionMenu() {
        if (headerBar) {
            var barBottom = headerBar.getBoundingClientRect().bottom;
            mobileMenu.style.paddingTop = Math.round(barBottom + 15) + 'px';
        }
    }

    positionMenu();

    function openMenu() {
        positionMenu();
        hamburger.classList.add('is-active');
        hamburger.setAttribute('aria-expanded', 'true');
        mobileMenu.classList.add('is-open');
        mobileMenu.setAttribute('aria-hidden', 'false');
        overlay.classList.add('is-active');
        document.body.style.overflow = 'hidden';
        if (track) track.style.transition = 'none';
        goToPanel(0);
        if (track) requestAnimationFrame(function () {
            requestAnimationFrame(function () { track.style.transition = ''; });
        });
    }

    function closeMenu() {
        hamburger.classList.remove('is-active');
        hamburger.setAttribute('aria-expanded', 'false');
        mobileMenu.classList.remove('is-open');
        mobileMenu.setAttribute('aria-hidden', 'true');
        overlay.classList.remove('is-active');
        document.body.style.overflow = '';
    }

    hamburger.addEventListener('click', function () {
        if (hamburger.classList.contains('is-active')) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && mobileMenu.classList.contains('is-open')) {
            closeMenu();
            hamburger.focus();
        }
    });

    function goToPanel(index) {
        if (!track) return;
        track.style.transform = 'translateX(-' + (index * 100) + '%)';
        setMenuHeight(index);
    }

    document.querySelectorAll('.mobile-nav__panel-open').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var panelIndex = parseInt(btn.getAttribute('data-panel'), 10);
            goToPanel(panelIndex);
        });
    });

    document.querySelectorAll('.mobile-nav__row').forEach(function (row) {
        var btn = row.querySelector('.mobile-nav__panel-open');
        if (!btn) return;
        row.addEventListener('click', function (e) {
            if (e.target === btn || btn.contains(e.target)) return;
            btn.click();
        });
    });

    document.querySelectorAll('[data-go-main]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            goToPanel(0);
        });
    });


    var headerEl = document.querySelector('.site-header');
    if (headerEl && headerBar) {
        var megaPanelsContainer = document.createElement('div');
        megaPanelsContainer.className = 'site-mega-panels';
        headerEl.insertBefore(megaPanelsContainer, headerBar.nextSibling);
        document.querySelectorAll('.site-nav__item--has-mega').forEach(function (item) {
            var mega = item.querySelector('.mega-menu');
            if (mega) {
                item._megaPanel = mega;
                megaPanelsContainer.appendChild(mega);
            }
        });
    }

    document.querySelectorAll('.site-nav__item--has-mega').forEach(function (item) {
        var closeTimer = null;
        var mega = item._megaPanel || null;

        function openMega() {
            clearTimeout(closeTimer);
            document.querySelectorAll('.site-nav__item--has-mega').forEach(function (other) {
                if (other !== item) {
                    other.classList.remove('is-mega-open');
                    if (other._megaPanel) other._megaPanel.classList.remove('is-mega-open');
                }
            });
            item.classList.add('is-mega-open');
            if (mega) mega.classList.add('is-mega-open');
        }

        function scheduledClose() {
            closeTimer = setTimeout(function () {
                item.classList.remove('is-mega-open');
                if (mega) mega.classList.remove('is-mega-open');
            }, 200);
        }

        item.addEventListener('mouseenter', openMega);
        item.addEventListener('mouseleave', scheduledClose);

        if (mega) {
            mega.addEventListener('mouseenter', function () { clearTimeout(closeTimer); });
            mega.addEventListener('mouseleave', scheduledClose);
        }
    });

    document.querySelectorAll('.site-nav__item--has-dropdown .site-nav__trigger').forEach(function (trigger) {
        trigger.addEventListener('click', function () {
            var expanded = trigger.getAttribute('aria-expanded') === 'true';
            document.querySelectorAll('.site-nav__trigger').forEach(function (other) {
                if (other !== trigger) other.setAttribute('aria-expanded', 'false');
            });
            trigger.setAttribute('aria-expanded', expanded ? 'false' : 'true');
        });
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.site-nav__item--has-dropdown') &&
            !e.target.closest('.site-nav__item--has-mega') &&
            !e.target.closest('.mega-menu')) {
            document.querySelectorAll('.site-nav__trigger').forEach(function (trigger) {
                trigger.setAttribute('aria-expanded', 'false');
            });
            document.querySelectorAll('.site-nav__item--has-mega').forEach(function (item) {
                item.classList.remove('is-mega-open');
                if (item._megaPanel) item._megaPanel.classList.remove('is-mega-open');
            });
        }
    });

}());
