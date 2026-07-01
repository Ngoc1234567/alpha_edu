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

        var statCounts = document.querySelectorAll('.stat-count[data-count]');

        function formatCount(value, prefix, suffix) {
            return prefix + Math.floor(value).toLocaleString('vi-VN') + suffix;
        }

        function animateCount(element) {
            if (element.dataset.animated === 'true') {
                return;
            }

            var target = parseInt(element.dataset.count, 10);
            var prefix = element.dataset.prefix || '';
            var suffix = element.dataset.suffix || '';
            var duration = 1400;
            var startTime = null;

            if (!target) {
                element.dataset.animated = 'true';
                return;
            }

            element.dataset.animated = 'true';

            function step(timestamp) {
                if (!startTime) {
                    startTime = timestamp;
                }

                var progress = Math.min((timestamp - startTime) / duration, 1);
                var eased = 1 - Math.pow(1 - progress, 3);
                element.textContent = formatCount(target * eased, prefix, suffix);

                if (progress < 1) {
                    window.requestAnimationFrame(step);
                } else {
                    element.textContent = formatCount(target, prefix, suffix);
                }
            }

            window.requestAnimationFrame(step);
        }

        if (statCounts.length) {
            if ('IntersectionObserver' in window) {
                var observer = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            animateCount(entry.target);
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.35 });

                statCounts.forEach(function (element) {
                    observer.observe(element);
                });
            } else {
                statCounts.forEach(animateCount);
            }
        }
    });
}());

