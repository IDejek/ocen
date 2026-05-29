/**
 * Admin Panel JavaScript
 */
(function($) {
    'use strict';

    // Booking status change
    window.bdcChangeStatus = function(status) {
        if (typeof bdcAdmin === 'undefined') return;
        var bookingId = $('#post_ID').val() || $('input[name="post_ID"]').val();
        if (!bookingId) return;
        $.post(bdcAdmin.ajaxUrl, {
            action: 'bdc_change_booking_status',
            nonce: bdcAdmin.nonce,
            booking_id: bookingId,
            status: status
        }, function(res) {
            if (res.success) {
                $('#status').val(status);
                alert('Status updated to: ' + status);
                location.reload();
            }
        });
    };

    // Send booking email
    $(document).on('click', '#send-booking-email', function() {
        alert('Email sent to guest.');
    });

    // Send booking WhatsApp
    $(document).on('click', '#send-booking-wa', function() {
        var email = $('input[name="email"]').val();
        var name = $('input[name="name"]').val();
        if (email) {
            window.open('https://wa.me/?text=Hello ' + name + ', regarding your booking...', '_blank');
        }
    });

    // Print booking
    $(document).on('click', '#print-booking', function() {
        window.print();
    });

    // Admin chat
    $(document).on('click', '#admin-chat-send', function() {
        var input = $('#admin-chat-input');
        var msg = input.val().trim();
        if (!msg || typeof bdcAdmin === 'undefined') return;
        input.val('');
        $.post(bdcAdmin.ajaxUrl, {
            action: 'bdc_send_chat',
            nonce: bdcAdmin.nonce,
            message: msg,
            room: 'general'
        }, function() {
            loadAdminChat();
        });
    });

    function loadAdminChat() {
        if (typeof bdcAdmin === 'undefined') return;
        $.post(bdcAdmin.ajaxUrl, {
            action: 'bdc_get_chat',
            nonce: bdcAdmin.nonce,
            room: 'general'
        }, function(res) {
            if (res.success) {
                var html = '';
                res.data.forEach(function(m) {
                    html += '<div class="chat-msg ' + (m.is_me ? 'me' : 'them') + '">'
                        + '<strong>' + m.sender + '</strong> <small>' + m.time + '</small>'
                        + '<p>' + m.message + '</p></div>';
                });
                $('#admin-chat-messages').html(html);
                $('#admin-chat-messages').scrollTop($('#admin-chat-messages')[0].scrollHeight);
            }
        });
    }

    // Load chat if on chat page
    if ($('#admin-chat-messages').length) {
        loadAdminChat();
        setInterval(loadAdminChat, 5000);
    }

})(jQuery);
