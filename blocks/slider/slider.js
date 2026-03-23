(function () {
    if (typeof Swiper === 'undefined') return;

    document.querySelectorAll('.slider--photo').forEach(function (wrapper) {
        new Swiper(wrapper.querySelector('.swiper'), {
            slidesPerView: 2,
            spaceBetween: 40,
            navigation: {
                prevEl: wrapper.querySelector('.slider-nav__btn--prev'),
                nextEl: wrapper.querySelector('.slider-nav__btn--next'),
                disabledClass: 'is-disabled',
            },
            pagination: {
                el: wrapper.querySelector('.slider-nav__progress'),
                type: 'progressbar',
            },
            breakpoints: {
                0: {
                    slidesPerView: 1.2,
                    spaceBetween: 20,
                },
                769: {
                    slidesPerView: 2,
                    spaceBetween: 40,
                },
            },
        });
    });

    document.querySelectorAll('.slider--process').forEach(function (wrapper) {
        new Swiper(wrapper.querySelector('.swiper'), {
            slidesPerView: 'auto',
            spaceBetween: 40,
            navigation: {
                prevEl: wrapper.querySelector('.slider-nav__btn--prev'),
                nextEl: wrapper.querySelector('.slider-nav__btn--next'),
                disabledClass: 'is-disabled',
            },
            pagination: {
                el: wrapper.querySelector('.slider-nav__progress'),
                type: 'progressbar',
            },
            breakpoints: {
                0: {
                    slidesPerView: 1.2,
                    spaceBetween: 20,
                },
                769: {
                    slidesPerView: 'auto',
                    spaceBetween: 40,
                },
            },
        });
    });
}());
