/**
 * World Clock System
 */
(function() {
    'use strict';

    if (typeof bdcClocks === 'undefined') return;

    const container = document.getElementById('world-clocks');
    if (!container) return;

    function getTimeInTimezone(tz) {
        try {
            return new Date().toLocaleTimeString('en-GB', {
                timeZone: tz,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });
        } catch (e) {
            return '--:--:--';
        }
    }

    function renderClocks() {
        const isMobile = window.innerWidth < 768;
        const clocks = bdcClocks.timezones;
        const display = isMobile ? clocks.filter(c => ['Manado','Singapore','London','Seoul'].includes(c.city)) : clocks;

        let html = '';
        display.forEach(clock => {
            html += '<div class="clock-item">'
                + '<span class="clock-city">' + clock.city + '</span>'
                + '<span class="clock-time" data-tz="' + clock.tz + '">' + getTimeInTimezone(clock.tz) + '</span>'
                + '</div>';
        });
        container.innerHTML = html;
    }

    function updateClocks() {
        const times = container.querySelectorAll('.clock-time');
        times.forEach(el => {
            el.textContent = getTimeInTimezone(el.dataset.tz);
        });
    }

    renderClocks();
    setInterval(updateClocks, 1000);

    // Re-render on resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(renderClocks, 250);
    });
})();
