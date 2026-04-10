(function () {
    function getNextSection(trigger) {
        var heroBlock = trigger.closest('.hero-banner');
        if (!heroBlock) return null;

        var next = heroBlock.nextElementSibling;
        while (next) {
            if (next.matches('section, main, footer, [id]')) return next;
            next = next.nextElementSibling;
        }

        return null;
    }

    document.addEventListener('click', function (event) {
        var trigger = event.target.closest('[data-scroll-target="next-section"]');
        if (!trigger) return;

        var target = getNextSection(trigger);
        if (!target) return;

        event.preventDefault();
        target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
}());
