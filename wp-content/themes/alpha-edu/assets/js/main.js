(function () {
    document.addEventListener('DOMContentLoaded', function () {
        var menuToggle = document.querySelector('.mobile-menu-toggle');
        var mainNav = document.querySelector('.main-nav');

        if (menuToggle && mainNav) {
            menuToggle.addEventListener('click', function () {
                var isOpen = mainNav.classList.toggle('is-open');
                menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });
        }

        if (typeof Swiper !== 'undefined') {
            new Swiper('.testimonial-swiper', {
                loop: true,
                slidesPerView: 1,
                spaceBetween: 24,
                speed: 700,
                autoplay: {
                    delay: 4500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                },
                pagination: {
                    el: '.testimonial-swiper .swiper-pagination',
                    clickable: true
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 28
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 34
                    }
                }
            });
        }
    });
}());

