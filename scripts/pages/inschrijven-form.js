(function ($) {
    'use strict';

    if (typeof $ === 'undefined') return;

    function syncPage($wrapper, currentPage) {
        $wrapper.attr('data-current-page', currentPage);
        $wrapper.find('.arehbo-gf-top-actions').remove();

        if (currentPage > 1) {
            var $prev = $wrapper.find('.gform_page_footer .gform_previous_button').first();
            if (!$prev.length) return;

            var $clone = $prev.clone();
            $clone.removeAttr('id').addClass('arehbo-gf-prev-top');
            $clone.on('click', function (e) {
                e.preventDefault();
                $prev.get(0).click();
            });

            var $topActions = $('<div class="arehbo-gf-top-actions"></div>').append($clone);
            var $heading    = $wrapper.find('.gform_heading').first();

            if ($heading.length) {
                $heading.after($topActions);
            } else {
                $wrapper.find('form').first().prepend($topActions);
            }
        }
    }

    $('.gform_wrapper').each(function () {
        var $w = $(this);
        if (!$w.attr('data-current-page')) {
            $w.attr('data-current-page', '1');
        }
    });

    $(document).on('gform_page_loaded', function (event, formId, currentPage) {
        syncPage($('#gform_wrapper_' + formId), parseInt(currentPage, 10) || 1);
    });
}(window.jQuery));

