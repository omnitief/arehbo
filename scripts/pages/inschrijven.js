(function () {
    'use strict';

    var cat    = document.getElementById('inschr-filter-cat');
    var cursus = document.getElementById('inschr-filter-cursus');
    var cards  = document.querySelectorAll('.inschr-cards .course-card');

    if (!cat || !cursus) return;

    function filterCursusOptions() {
        var catVal = cat.value;
        Array.prototype.forEach.call(cursus.options, function (opt) {
            if (!opt.value) return;
            var optCats = (opt.dataset.categorie || '').split(',');
            opt.hidden = !!(catVal && optCats.indexOf(catVal) === -1);
        });
    }

    function applyFilter() {
        var catVal    = cat.value;
        var courseVal = cursus.value;

        cards.forEach(function (card) {
            if (!catVal) {
                card.style.display = 'none';
                return;
            }
            var cardCat    = card.dataset.categorie || '';
            var cardCourse = card.dataset.course || '';
            var catMatch    = (cardCat === catVal);
            var courseMatch = !courseVal || (cardCourse === courseVal);
            card.style.display = (catMatch && courseMatch) ? '' : 'none';
        });
    }

    cat.addEventListener('change', function () {
        if (cat.value) {
            cursus.removeAttribute('disabled');
        } else {
            cursus.setAttribute('disabled', 'disabled');
        }
        cursus.value = '';
        filterCursusOptions();
        applyFilter();
    });

    cursus.addEventListener('change', applyFilter);

    filterCursusOptions();
    applyFilter();
}());

