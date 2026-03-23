(function () {
    function closeItem(toggle) {
        var body = document.getElementById(toggle.getAttribute('aria-controls'));
        toggle.setAttribute('aria-expanded', 'false');
        if (body) body.classList.remove('is-open');
    }

    function openItem(toggle) {
        var body = document.getElementById(toggle.getAttribute('aria-controls'));
        toggle.setAttribute('aria-expanded', 'true');
        if (body) body.classList.add('is-open');
    }

    document.querySelectorAll('.faq-item__toggle').forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            var isOpen = this.getAttribute('aria-expanded') === 'true';

            this.closest('.faq-list')
                .querySelectorAll('.faq-item__toggle')
                .forEach(closeItem);

            if (!isOpen) {
                openItem(this);
            }
        });
    });
}());
