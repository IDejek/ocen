/**
 * Babarida Dive Center - Main JavaScript
 */
(function() {
    'use strict';

    const DOC = document;
    const WIN = window;

    // ============================================================
    // PRELOADER
    // ============================================================
    function initPreloader() {
        const preloader = document.getElementById('preloader');
        if (!preloader) return;
        WIN.addEventListener('load', function() {
            setTimeout(function() {
                preloader.classList.add('loaded');
                document.body.style.overflow = '';
                // Init Lucide icons after preloader
                if (typeof lucide !== 'undefined') lucide.createIcons();
            }, 2800);
        });
        document.body.style.overflow = 'hidden';
    }

    // ============================================================
    // HEADER SCROLL BEHAVIOR
    // ============================================================
    function initHeader() {
        const header = document.getElementById('main-header');
        const topbar = document.getElementById('topbar');
        if (!header) return;

        let lastScroll = 0;
        WIN.addEventListener('scroll', function() {
            const scrollY = WIN.scrollY;
            // Glassmorphism on scroll
            if (scrollY > 60) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            // Hide topbar on scroll down
            if (topbar) {
                if (scrollY > lastScroll && scrollY > 200) {
                    topbar.classList.add('hidden');
                    header.style.top = '0';
                } else {
                    topbar.classList.remove('hidden');
                    header.style.top = '';
                }
            }
            lastScroll = scrollY;
        }, { passive: true });
    }

    // ============================================================
    // MOBILE NAVIGATION
    // ============================================================
    function initMobileNav() {
        const toggle = document.getElementById('nav-toggle');
        const menu = document.querySelector('.nav-menu');
        const overlay = document.getElementById('mobile-overlay');
        if (!toggle || !menu) return;

        toggle.addEventListener('click', function() {
            const isOpen = menu.classList.toggle('open');
            toggle.classList.toggle('active');
            if (overlay) overlay.classList.toggle('active', isOpen);
            toggle.setAttribute('aria-expanded', isOpen);
            document.body.style.overflow = isOpen ? 'hidden' : '';
        });

        if (overlay) {
            overlay.addEventListener('click', function() {
                menu.classList.remove('open');
                toggle.classList.remove('active');
                overlay.classList.remove('active');
                toggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            });
        }

        // Mobile submenu toggles
        const menuItems = menu.querySelectorAll('li');
        menuItems.forEach(function(li) {
            const megaMenu = li.querySelector('.mega-menu');
            if (megaMenu && WIN.innerWidth <= 1024) {
                const link = li.querySelector(':scope > a');
                if (link) {
                    link.addEventListener('click', function(e) {
                        if (WIN.innerWidth <= 1024) {
                            e.preventDefault();
                            li.classList.toggle('submenu-open');
                        }
                    });
                }
            }
        });
    }

    // ============================================================
    // SCROLL REVEAL
    // ============================================================
    function initReveal() {
        const reveals = document.querySelectorAll('.reveal');
        if (!reveals.length) return;

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        reveals.forEach(function(el) { observer.observe(el); });
    }

    // ============================================================
    // BACK TO TOP
    // ============================================================
    function initBackToTop() {
        const btn = document.getElementById('float-top');
        if (!btn) return;

        WIN.addEventListener('scroll', function() {
            btn.classList.toggle('visible', WIN.scrollY > 600);
        }, { passive: true });

        btn.addEventListener('click', function() {
            WIN.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // ============================================================
    // BOOKING MODAL
    // ============================================================
    function initBookingModal() {
        const modal = document.getElementById('booking-modal');
        const overlay = document.getElementById('booking-modal-overlay');
        const closeBtn = document.getElementById('booking-modal-close');
        const openBtn = document.getElementById('float-booking');
        if (!modal) return;

        function openModal() {
            modal.classList.add('active');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeModal() {
            modal.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (openBtn) openBtn.addEventListener('click', openModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (overlay) overlay.addEventListener('click', closeModal);
        DOC.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) closeModal();
        });
    }

    // ============================================================
    // BOOKING FORM SUBMISSION
    // ============================================================
    function initBookingForm() {
        const form = document.getElementById('booking-form');
        if (!form || typeof bdcData === 'undefined') return;

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = form.querySelector('button[type="submit"]');
            const origText = btn.innerHTML;
            btn.innerHTML = '<span class="bdc-spinner" style="width:18px;height:18px;border:2px solid rgba(255,255,255,0.3);border-top-color:white;border-radius:50%;animation:spin 0.6s linear infinite;display:inline-block;"></span> ' + bdcData.i18n.loading;
            btn.disabled = true;

            const formData = new FormData(form);
            formData.append('action', 'bdc_submit_booking');
            formData.append('nonce', bdcData.nonce);

            fetch(bdcData.ajaxUrl, {
                method: 'POST',
                body: formData,
            })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                if (res.success) {
                    form.innerHTML = '<div style="text-align:center;padding:40px 0;"><div style="width:60px;height:60px;border-radius:50%;background:#10B981;color:white;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:28px;">✓</div><h3 style="margin-bottom:8px;">' + bdcData.i18n.sent + '</h3><p style="color:var(--mid-gray);">' + (res.data.message || '') + '</p><p style="color:var(--mid-gray);font-size:13px;margin-top:8px;">Booking ID: BDC-' + res.data.booking_id + '</p></div>';
                } else {
                    alert(res.data.message || bdcData.i18n.error);
                    btn.innerHTML = origText;
                    btn.disabled = false;
                }
            })
            .catch(function() {
                alert(bdcData.i18n.error);
                btn.innerHTML = origText;
                btn.disabled = false;
            });
        });
    }

    // ============================================================
    // NEWSLETTER
    // ============================================================
    function initNewsletter() {
        const form = document.getElementById('newsletter-form');
        if (!form || typeof bdcData === 'undefined') return;

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            formData.append('action', 'bdc_subscribe_newsletter');
            formData.append('nonce', bdcData.nonce);
            formData.append('email', document.getElementById('newsletter-email').value);

            fetch(bdcData.ajaxUrl, { method: 'POST', body: formData })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                if (res.success) {
                    form.innerHTML = '<p style="color:white;font-size:16px;">✓ ' + res.data.message + '</p>';
                } else {
                    alert(res.data.message || bdcData.i18n.error);
                }
            })
            .catch(function() { alert(bdcData.i18n.error); });
        });
    }

    // ============================================================
    // AI CHAT
    // ============================================================
    function initAIChat() {
        const btn = document.getElementById('ai-chat-btn');
        const panel = document.getElementById('ai-chat-panel');
        const input = document.getElementById('ai-chat-input');
        const sendBtn = document.getElementById('ai-chat-send');
        const messages = document.getElementById('ai-chat-messages');
        if (!btn || !panel) return;

        btn.addEventListener('click', function() {
            panel.classList.toggle('active');
            if (panel.classList.contains('active') && input) input.focus();
        });

        function sendMessage() {
            if (!input || !input.value.trim() || typeof bdcData === 'undefined') return;
            const msg = input.value.trim();
            input.value = '';

            // User message
            messages.innerHTML += '<div class="ai-msg user">' + escapeHtml(msg) + '</div>';

            // Bot typing
            messages.innerHTML += '<div class="ai-msg bot" id="ai-typing"><span class="bdc-spinner" style="width:16px;height:16px;border:2px solid rgba(0,53,102,0.2);border-top-color:var(--bright-blue);border-radius:50%;animation:spin 0.6s linear infinite;display:inline-block;vertical-align:middle;"></span></div>';
            messages.scrollTop = messages.scrollHeight;

            const formData = new FormData();
            formData.append('action', 'bdc_ai_chat');
            formData.append('nonce', bdcData.nonce);
            formData.append('message', msg);

            fetch(bdcData.ajaxUrl, { method: 'POST', body: formData })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                var typing = document.getElementById('ai-typing');
                if (typing) typing.remove();
                if (res.success) {
                    messages.innerHTML += '<div class="ai-msg bot">' + escapeHtml(res.data.reply) + '</div>';
                } else {
                    messages.innerHTML += '<div class="ai-msg bot">' + bdcData.i18n.error + '</div>';
                }
                messages.scrollTop = messages.scrollHeight;
            })
            .catch(function() {
                var typing = document.getElementById('ai-typing');
                if (typing) typing.remove();
                messages.innerHTML += '<div class="ai-msg bot">' + bdcData.i18n.error + '</div>';
            });
        }

        if (sendBtn) sendBtn.addEventListener('click', sendMessage);
        if (input) input.addEventListener('keypress', function(e) { if (e.key === 'Enter') sendMessage(); });
    }

    // ============================================================
    // TESTIMONIAL SLIDER
    // ============================================================
    function initTestimonialSlider() {
        const track = document.getElementById('testimonial-track');
        const prevBtn = document.getElementById('test-prev');
        const nextBtn = document.getElementById('test-next');
        if (!track || !prevBtn || !nextBtn) return;

        const slides = track.querySelectorAll('.testimonial-slide');
        let current = 0;
        const total = slides.length;

        function goTo(index) {
            current = ((index % total) + total) % total;
            track.style.transform = 'translateX(-' + (current * 100) + '%)';
        }

        prevBtn.addEventListener('click', function() { goTo(current - 1); });
        nextBtn.addEventListener('click', function() { goTo(current + 1); });

        // Auto-play
        let autoplay = setInterval(function() { goTo(current + 1); }, 6000);
        track.parentElement.addEventListener('mouseenter', function() { clearInterval(autoplay); });
        track.parentElement.addEventListener('mouseleave', function() { autoplay = setInterval(function() { goTo(current + 1); }, 6000); });

        // Touch swipe
        let startX = 0;
        track.addEventListener('touchstart', function(e) { startX = e.touches[0].clientX; }, { passive: true });
        track.addEventListener('touchend', function(e) {
            const diff = startX - e.changedTouches[0].clientX;
            if (Math.abs(diff) > 50) goTo(current + (diff > 0 ? 1 : -1));
        }, { passive: true });
    }

    // ============================================================
    // WEATHER DATA
    // ============================================================
    function initWeather() {
        const bar = document.getElementById('weather-bar');
        if (!bar || typeof bdcData === 'undefined') return;

        fetch(bdcData.ajaxUrl + '?action=bdc_get_weather&nonce=' + bdcData.nonce)
        .then(function(r) { return r.json(); })
        .then(function(res) {
            if (res.success) {
                var d = res.data;
                var el = function(id) { return document.getElementById(id); };
                if (el('w-temp')) el('w-temp').textContent = d.temp + '°C';
                if (el('w-water')) el('w-water').textContent = d.water + '°C';
                if (el('w-vis')) el('w-vis').textContent = d.visibility + ' m';
                if (el('w-wind')) el('w-wind').textContent = d.wind + ' km/h';
                if (el('w-tide')) el('w-tide').textContent = d.tide + ' m';
            }
        })
        .catch(function() {});
    }

    // ============================================================
    // CURRENCY SWITCHER (Pricing Table)
    // ============================================================
    function initCurrencySwitch() {
        const tabs = document.querySelectorAll('.pricing-tab');
        if (!tabs.length || typeof bdcData === 'undefined') return;

        const rates = { USD: 1, EUR: 0.92, SGD: 1.34, AUD: 1.53, IDR: 15600 };
        const symbols = { USD: '$', EUR: '€', SGD: 'S$', AUD: 'A$', IDR: 'Rp' };

        tabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                tabs.forEach(function(t) { t.classList.remove('active'); });
                tab.classList.add('active');
                const currency = tab.dataset.currency;
                const rate = rates[currency] || 1;
                const symbol = symbols[currency] || '$';

                document.querySelectorAll('.price-cell').forEach(function(cell) {
                    const usd = parseFloat(cell.dataset.usd) || 0;
                    const converted = usd * rate;
                    if (currency === 'IDR') {
                        cell.textContent = symbol + Math.round(converted).toLocaleString('id-ID');
                    } else {
                        cell.textContent = symbol + converted.toFixed(2);
                    }
                });

                // Save preference
                if (typeof bdcData !== 'undefined') {
                    fetch(bdcData.ajaxUrl, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: 'action=bdc_switch_currency&nonce=' + bdcData.nonce + '&currency=' + currency,
                    });
                }
            });
        });
    }

    // ============================================================
    // AJAX FILTER (Archive Pages)
    // ============================================================
    function initArchiveFilter() {
        const applyBtn = document.getElementById('apply-filters');
        const grid = document.getElementById('archive-grid');
        if (!applyBtn || !grid || typeof bdcData === 'undefined') return;

        // Get post type from body class
        const bodyClasses = document.body.className;
        let postType = 'bdc_trip';
        if (bodyClasses.indexOf('post-type-archive-bdc_liveaboard') > -1) postType = 'bdc_liveaboard';
        else if (bodyClasses.indexOf('post-type-archive-bdc_course') > -1) postType = 'bdc_course';
        else if (bodyClasses.indexOf('post-type-archive-bdc_watersport') > -1) postType = 'bdc_watersport';
        else if (bodyClasses.indexOf('post-type-archive-bdc_hotel') > -1) postType = 'bdc_hotel';

        applyBtn.addEventListener('click', function() {
            const formData = new FormData();
            formData.append('action', 'bdc_filter_products');
            formData.append('nonce', bdcData.nonce);
            formData.append('post_type', postType);
            formData.append('per_page', '9');

            var dest = document.getElementById('filter-destination');
            var act = document.getElementById('filter-activity');
            var minP = document.getElementById('filter-price-min');
            var maxP = document.getElementById('filter-price-max');

            if (dest && dest.value) formData.append('destination', dest.value);
            if (act && act.value) formData.append('activity', act.value);
            if (minP && minP.value) formData.append('price_min', minP.value);
            if (maxP && maxP.value) formData.append('price_max', maxP.value);

            grid.style.opacity = '0.5';
            fetch(bdcData.ajaxUrl, { method: 'POST', body: formData })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                if (res.success) {
                    grid.innerHTML = res.data.html;
                    grid.style.opacity = '1';
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                }
            });
        });
    }

    // ============================================================
    // BOOK FROM PRICING TABLE
    // ============================================================
    function initPricingBooking() {
        DOC.addEventListener('click', function(e) {
            if (e.target.closest('.book-from-table')) {
                var btn = e.target.closest('.book-from-table');
                var month = btn.dataset.month;
                var modal = document.getElementById('booking-modal');
                var overlay = document.getElementById('booking-modal-overlay');
                var dateInput = document.getElementById('bk-date');
                if (modal) modal.classList.add('active');
                if (overlay) overlay.classList.add('active');
                if (dateInput && month) dateInput.value = month + '-01';
            }
        });
    }

    // ============================================================
    // LANGUAGE SWITCHER
    // ============================================================
    function initLangSwitch() {
        const btns = document.querySelectorAll('.lang-switch button');
        btns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                btns.forEach(function(b) { b.classList.remove('active'); });
                btn.classList.add('active');
                var lang = btn.dataset.lang;
                // Trigger Polylang/WPML if available
                if (typeof wpml_switch_lang !== 'undefined') {
                    wpml_switch_lang(lang);
                } else if (typeof pll_switch_lang !== 'undefined') {
                    pll_switch_lang(lang);
                }
            });
        });
    }

    // ============================================================
    // FLOATING BUBBLES
    // ============================================================
    function initBubbles() {
        if (WIN.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
        var container = document.body;
        function createBubble() {
            var bubble = document.createElement('div');
            bubble.className = 'bubble';
            var size = Math.random() * 20 + 5;
            bubble.style.width = size + 'px';
            bubble.style.height = size + 'px';
            bubble.style.left = Math.random() * 100 + '%';
            bubble.style.animationDuration = (Math.random() * 15 + 10) + 's';
            bubble.style.animationDelay = (Math.random() * 5) + 's';
            container.appendChild(bubble);
            setTimeout(function() { bubble.remove(); }, 25000);
        }
        // Only on homepage
        if (document.body.classList.contains('home')) {
            setInterval(createBubble, 3000);
            for (var i = 0; i < 5; i++) setTimeout(createBubble, i * 600);
        }
    }

    // ============================================================
    // SMOOTH SCROLL FOR ANCHOR LINKS
    // ============================================================
    function initSmoothScroll() {
        DOC.addEventListener('click', function(e) {
            var link = e.target.closest('a[href^="#"]');
            if (link) {
                var target = document.querySelector(link.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    }

    // ============================================================
    // SPINNER KEYFRAME (inject if not exists)
    // ============================================================
    function injectSpinnerCSS() {
        if (document.getElementById('bdc-spinner-css')) return;
        var style = document.createElement('style');
        style.id = 'bdc-spinner-css';
        style.textContent = '@keyframes spin{to{transform:rotate(360deg);}}';
        document.head.appendChild(style);
    }

    // ============================================================
    // UTILITY
    // ============================================================
    function escapeHtml(str) {
        var div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // ============================================================
    // INIT
    // ============================================================
    function init() {
        injectSpinnerCSS();
        initPreloader();
        initHeader();
        initMobileNav();
        initReveal();
        initBackToTop();
        initBookingModal();
        initBookingForm();
        initNewsletter();
        initAIChat();
        initTestimonialSlider();
        initWeather();
        initCurrencySwitch();
        initArchiveFilter();
        initPricingBooking();
        initLangSwitch();
        initBubbles();
        initSmoothScroll();
    }

    if (DOC.readyState === 'loading') {
        DOC.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
