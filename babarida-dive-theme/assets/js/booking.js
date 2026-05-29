/**
 * Booking & Check-in Specific JS
 */
(function() {
    'use strict';

    // Check-in steps
    function initCheckinSteps() {
        var steps = document.querySelectorAll('.checkin-step');
        var forms = document.querySelectorAll('.checkin-step-form');
        if (!steps.length) return;

        function showStep(index) {
            steps.forEach(function(s, i) {
                s.classList.toggle('active', i <= index);
                s.classList.toggle('done', i < index);
            });
            forms.forEach(function(f, i) {
                f.style.display = i === index ? 'block' : 'none';
            });
        }

        document.querySelectorAll('.checkin-next').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var current = parseInt(btn.dataset.step);
                showStep(current + 1);
            });
        });

        document.querySelectorAll('.checkin-prev').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var current = parseInt(btn.dataset.step);
                showStep(current - 1);
            });
        });
    }

    // Date picker min date
    function initDatePickers() {
        document.querySelectorAll('input[type="date"]').forEach(function(input) {
            var today = new Date().toISOString().split('T')[0];
            if (!input.min) input.min = today;
        });
    }

    // Init
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            initCheckinSteps();
            initDatePickers();
        });
    } else {
        initCheckinSteps();
        initDatePickers();
    }
})();
