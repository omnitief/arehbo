(function () {
    if (typeof Swiper === 'undefined') return;

    document.querySelectorAll('.page-tiles--slider .page-tiles__swiper-wrap').forEach(function (wrapper) {
        new Swiper(wrapper.querySelector('.swiper'), {
            slidesPerView: 3.25,
            spaceBetween: 40,
            breakpoints: {
                0: {
                    slidesPerView: 1.2,
                    spaceBetween: 20,
                },
                769: {
                    slidesPerView: 2.25,
                    spaceBetween: 30,
                },
                1200: {
                    slidesPerView: 3.25,
                    spaceBetween: 40,
                },
            },
        });
    });
}());
