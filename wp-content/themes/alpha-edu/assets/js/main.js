(function () {
    document.addEventListener('DOMContentLoaded', function () {
        document.body.classList.add('registration-js-ready');
        document.body.classList.add('about-animation-ready');

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
                    delay: 2500,
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

        var registrationToggle = document.querySelector('[data-registration-toggle]');
        var registrationSection = document.getElementById('course-registration-form');

        if (registrationToggle && registrationSection) {
            function openRegistrationForm(shouldScroll) {
                registrationSection.classList.add('is-open');
                registrationToggle.setAttribute('aria-expanded', 'true');

                if (shouldScroll) {
                    window.setTimeout(function () {
                        registrationSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 120);
                }
            }

            registrationToggle.addEventListener('click', function (event) {
                event.preventDefault();
                openRegistrationForm(true);
            });

            if (window.location.search.indexOf('registration=success') !== -1) {
                openRegistrationForm(false);
            }
        }

        var registrationData = window.alphaEduRegistration || null;

        if (registrationData) {
            var typeSelect = document.querySelector('[name="registration-type"], [name="registration[type]"], [name="hinh-thuc"]');
            var programSelect = document.querySelector('[name="registration-program"], [name="registration[program]"], [name="chuong-trinh"]');
            var courseSelect = document.querySelector('[name="registration-course"], [name="registration[course]"], [name="khoa-dang-ky"]');
            var scheduleSelect = document.querySelector('[name="registration-schedule"], [name="registration[schedule]"], [name="lich-hoc-thi"]');

            function disableRegistrationChangeValidation() {
                if (!window.wpcf7 || typeof window.wpcf7.validate !== 'function' || window.wpcf7.alphaRegistrationValidateWrapped) {
                    return;
                }

                var originalValidate = window.wpcf7.validate;

                window.wpcf7.validate = function (form, options) {
                    if (options && options.target && options.target.closest('.alpha-registration-section')) {
                        return;
                    }

                    return originalValidate.apply(this, arguments);
                };

                window.wpcf7.alphaRegistrationValidateWrapped = true;
            }

            function clearRegistrationValidation(form) {
                if (!form) {
                    return;
                }

                form.querySelectorAll('.wpcf7-not-valid').forEach(function (field) {
                    field.classList.remove('wpcf7-not-valid');
                    field.setAttribute('aria-invalid', 'false');
                });

                form.querySelectorAll('.wpcf7-not-valid-tip').forEach(function (tip) {
                    tip.remove();
                });

                form.querySelectorAll('.wpcf7-form-control-wrap').forEach(function (wrap) {
                    wrap.classList.remove('wpcf7-not-valid');
                });

                form.classList.remove('invalid');
                form.classList.remove('failed');
                form.classList.add('init');
                form.setAttribute('data-status', 'init');

                var response = form.querySelector('.wpcf7-response-output');

                if (response) {
                    response.textContent = '';
                    response.setAttribute('aria-hidden', 'true');
                }
            }

            function scheduleRegistrationValidationClear(form) {
                clearRegistrationValidation(form);

                window.requestAnimationFrame(function () {
                    clearRegistrationValidation(form);
                });

                window.setTimeout(function () {
                    clearRegistrationValidation(form);
                }, 80);
            }

            function fillSelect(select, items, placeholder) {
                if (!select) {
                    return;
                }

                select.innerHTML = '';

                var emptyOption = document.createElement('option');
                emptyOption.value = '';
                emptyOption.textContent = placeholder || '';
                emptyOption.disabled = true;
                emptyOption.selected = true;
                select.appendChild(emptyOption);

                (items || []).forEach(function (item) {
                    var option = document.createElement('option');
                    option.value = item;
                    option.textContent = item;
                    select.appendChild(option);
                });
            }

            function updatePrograms() {
                var type = typeSelect ? typeSelect.value : '';
                var programs = registrationData.programs[type] || [];
                fillSelect(programSelect, programs, registrationData.placeholders.program);

                if (programs.length === 1 && programSelect) {
                    programSelect.value = programs[0];
                }

                fillSelect(courseSelect, [], registrationData.placeholders.course);
                fillSelect(scheduleSelect, registrationData.schedules[type] || [], registrationData.placeholders.schedule);
                updateCourses();
            }

            function updateCourses() {
                var type = typeSelect ? typeSelect.value : '';
                var program = programSelect ? programSelect.value : '';
                var coursesByType = registrationData.courses[type] || {};
                fillSelect(courseSelect, coursesByType[program] || [], registrationData.placeholders.course);
            }

            if (typeSelect && programSelect && courseSelect && scheduleSelect) {
                disableRegistrationChangeValidation();
                window.setTimeout(disableRegistrationChangeValidation, 0);

                updatePrograms();
                typeSelect.addEventListener('change', function () {
                    updatePrograms();
                    scheduleRegistrationValidationClear(typeSelect.closest('form'));
                });
                programSelect.addEventListener('change', function () {
                    updateCourses();
                    scheduleRegistrationValidationClear(programSelect.closest('form'));
                });
                courseSelect.addEventListener('change', function () {
                    scheduleRegistrationValidationClear(courseSelect.closest('form'));
                });
                scheduleSelect.addEventListener('change', function () {
                    scheduleRegistrationValidationClear(scheduleSelect.closest('form'));
                });
            }
        }

        var aboutHeadings = document.querySelectorAll('.about-intro h2, .about-value h2, .about-stats h2');

        if (aboutHeadings.length) {
            if ('IntersectionObserver' in window) {
                var aboutHeadingObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            aboutHeadingObserver.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.45, rootMargin: '0px 0px -8% 0px' });

                aboutHeadings.forEach(function (heading) {
                    aboutHeadingObserver.observe(heading);
                });
            } else {
                aboutHeadings.forEach(function (heading) {
                    heading.classList.add('is-visible');
                });
            }
        }

        var aboutRevealItems = document.querySelectorAll('.about-eyebrow, .about-rich-text p, .about-wide-image, .about-stat-card');

        if (aboutRevealItems.length) {
            aboutRevealItems.forEach(function (item, index) {
                item.style.setProperty('--about-reveal-delay', Math.min(index % 4, 3) * 90 + 'ms');
            });

            if ('IntersectionObserver' in window) {
                var aboutRevealObserver = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            aboutRevealObserver.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.18, rootMargin: '0px 0px -6% 0px' });

                aboutRevealItems.forEach(function (item) {
                    aboutRevealObserver.observe(item);
                });
            } else {
                aboutRevealItems.forEach(function (item) {
                    item.classList.add('is-visible');
                });
            }
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

