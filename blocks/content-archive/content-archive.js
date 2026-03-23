(function () {
    if (typeof Swiper === 'undefined') return;

    document.querySelectorAll('.content-archive--slider').forEach(function (block) {
        var swiperEl = block.querySelector('.swiper');
        if (!swiperEl) return;

        new Swiper(swiperEl, {
            slidesPerView: 'auto',
            spaceBetween: 40,
            navigation: {
                prevEl: block.querySelector('.slider-nav__btn--prev'),
                nextEl: block.querySelector('.slider-nav__btn--next'),
                disabledClass: 'is-disabled',
            },
            pagination: {
                el: block.querySelector('.swiper-pagination'),
                type: 'progressbar',
            },
            breakpoints: {
                0: {
                    spaceBetween: 20,
                },
                769: {
                    spaceBetween: 30,
                },
                1200: {
                    spaceBetween: 40,
                },
            },
        });
    });

    document.querySelectorAll('.content-archive--grid').forEach(function (block) {
        var grid        = block.querySelector('.archive-grid');
        if (!grid) return;

        var allCards    = Array.from(grid.querySelectorAll('.archive-card'));
        var filterBtns  = Array.from(block.querySelectorAll('.archive-filter'));
        var paginationEl = block.querySelector('.archive-pagination');
        var pageNumsEl  = block.querySelector('.archive-page-numbers');
        var prevBtn     = block.querySelector('.archive-page-btn--prev');
        var nextBtn     = block.querySelector('.archive-page-btn--next');

        var CARDS_PER_PAGE = 10;
        var currentPage    = 1;

        var allBtn      = block.querySelector('.archive-filter[data-term="all"]');
        var categoryBtns = filterBtns.filter(function (f) { return f.dataset.term !== 'all'; });

        var activeTerms = new Set(['all']);

        function getVisibleCards() {
            if (!filterBtns.length || activeTerms.has('all')) return allCards;
            return allCards.filter(function (card) {
                var terms = (card.dataset.terms || '').split(',').filter(Boolean);
                if (!terms.length) return true;
                return terms.some(function (t) { return activeTerms.has(t); });
            });
        }

        function renderPage() {
            var visible    = getVisibleCards();
            var totalPages = Math.max(1, Math.ceil(visible.length / CARDS_PER_PAGE));
            if (currentPage > totalPages) currentPage = totalPages;

            var start = (currentPage - 1) * CARDS_PER_PAGE;
            var end   = start + CARDS_PER_PAGE;

            allCards.forEach(function (card) { card.style.display = 'none'; });
            visible.slice(start, end).forEach(function (card) { card.style.display = ''; });

            if (paginationEl) {
                paginationEl.style.display = totalPages <= 1 ? 'none' : '';
                renderPageNumbers(totalPages);
                if (prevBtn) prevBtn.disabled = currentPage <= 1;
                if (nextBtn) nextBtn.disabled = currentPage >= totalPages;
            }
        }

        function renderPageNumbers(totalPages) {
            if (!pageNumsEl) return;
            pageNumsEl.innerHTML = '';

            buildPageRange(currentPage, totalPages).forEach(function (p) {
                if (p === '...') {
                    var el = document.createElement('span');
                    el.className   = 'archive-page-ellipsis';
                    el.textContent = '...';
                    pageNumsEl.appendChild(el);
                } else {
                    var btn = document.createElement('button');
                    btn.className   = 'archive-page-number' + (p === currentPage ? ' is-active' : '');
                    btn.textContent = p;
                    btn.setAttribute('type', 'button');
                    btn.setAttribute('aria-label', 'Pagina ' + p);
                    btn.addEventListener('click', function () {
                        currentPage = p;
                        renderPage();
                        block.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                    pageNumsEl.appendChild(btn);
                }
            });
        }

        function buildPageRange(current, total) {
            if (total <= 7) {
                return Array.from({ length: total }, function (_, i) { return i + 1; });
            }
            var pages = [];
            if (current <= 4) {
                for (var i = 1; i <= 5; i++) pages.push(i);
                pages.push('...');
                pages.push(total);
            } else if (current >= total - 3) {
                pages.push(1);
                pages.push('...');
                for (var i = total - 4; i <= total; i++) pages.push(i);
            } else {
                pages.push(1);
                pages.push('...');
                pages.push(current - 1);
                pages.push(current);
                pages.push(current + 1);
                pages.push('...');
                pages.push(total);
            }
            return pages;
        }

        filterBtns.forEach(function (filter) {
            filter.addEventListener('click', function () {
                var term = filter.dataset.term;

                if (term === 'all') {
                    activeTerms = new Set(['all']);
                    categoryBtns.forEach(function (f) { f.classList.remove('is-active'); });
                    if (allBtn) allBtn.classList.add('is-active');
                } else {
                    activeTerms.delete('all');
                    if (allBtn) allBtn.classList.remove('is-active');

                    if (activeTerms.has(term)) {
                        activeTerms.delete(term);
                        filter.classList.remove('is-active');
                    } else {
                        activeTerms.add(term);
                        filter.classList.add('is-active');
                    }

                    if (activeTerms.size === 0) {
                        activeTerms.add('all');
                        if (allBtn) allBtn.classList.add('is-active');
                    }
                }

                currentPage = 1;
                renderPage();
            });
        });

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                if (currentPage > 1) {
                    currentPage--;
                    renderPage();
                    block.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                var visible    = getVisibleCards();
                var totalPages = Math.ceil(visible.length / CARDS_PER_PAGE);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderPage();
                    block.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        }

        renderPage();
    });
}());
