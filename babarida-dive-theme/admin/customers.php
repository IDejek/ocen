<?php
/**
 * Admin: Customer Management
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;
?>
<div class="wrap">
    <h1 style="font-family:Playfair Display,serif;"><?php esc_html_e('Customer Management (CRM)', 'babarida-dive'); ?></h1>
    <div style="margin:20px 0;">
        <input type="text" id="bdc-customer-search" placeholder="<?php esc_attr_e('Search by email to view customer profile...', 'babarida-dive'); ?>" style="padding:10px 16px;border:1px solid #ddd;border-radius:8px;min-width:300px;">
        <button class="button button-primary" id="bdc-search-customer"><?php esc_html_e('Search', 'babarida-dive'); ?></button>
    </div>
    <div id="bdc-customer-result"></div>
</div>
<script>
jQuery(function($){
    $('#bdc-search-customer').click(function(){
        var email = $('#bdc-customer-search').val().trim();
        if(!email) return;
        var $btn = $(this);
        $btn.prop('disabled', true).text('<?php esc_html_e("Searching...", "babarida-dive"); ?>');
        $.post(ajaxurl, {
            action: 'bdc_get_customer',
            nonce: '<?php echo esc_js(wp_create_nonce("bdc_admin_nonce")); ?>',
            email: email
        }, function(res){
            $btn.prop('disabled', false).text('<?php esc_html_e("Search", "babarida-dive"); ?>');
            if(res.success && res.data){
                var p = res.data;
                var html = '<div class="bdc-card" style="margin-top:16px;">';
                html += '<h3>' + (p.name || 'Unknown') + '</h3>';
                html += '<p>Email: ' + (p.email || '-') + '</p>';
                html += '<p>Phone: ' + (p.phone || '-') + '</p>';
                html += '<p>Nationality: ' + (p.nationality || '-') + '</p>';
                html += '<p>Cert Level: ' + (p.cert_level || '-') + '</p>';
                html += '<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin:16px 0;">';
                html += '<div style="text-align:center;padding:12px;background:#f0f4f8;border-radius:8px;"><div style="font-size:24px;font-weight:700;color:#0077B6;">' + p.total_trips + '</div><div style="font-size:12px;color:#94A3B8;">Trips</div></div>';
                html += '<div style="text-align:center;padding:12px;background:#f0f4f8;border-radius:8px;"><div style="font-size:24px;font-weight:700;color:#10B981;">$' + p.total_spent + '</div><div style="font-size:12px;color:#94A3B8;">Spent</div></div>';
                html += '<div style="text-align:center;padding:12px;background:#f0f4f8;border-radius:8px;"><div style="font-size:24px;font-weight:700;color:#FFB703;">' + p.total_dives + '</div><div style="font-size:12px;color:#94A3B8;">Dives</div></div>';
                html += '<div style="text-align:center;padding:12px;background:#f0f4f8;border-radius:8px;"><div style="font-size:24px;font-weight:700;color:#0077B6;">' + (p.favorite_dest || '-') + '</div><div style="font-size:12px;color:#94A3B8;">Favorite</div></div>';
                html += '</div>';
                if(p.bookings && p.bookings.length){
                    html += '<h4>Booking History</h4>';
                    html += '<table class="wp-list-table widefat striped"><thead><tr><th>Date</th><th>Trip</th><th>Status</th><th>Amount</th></tr></thead><tbody>';
                    p.bookings.forEach(function(b){
                        html += '<tr><td>' + b.date + '</td><td>' + b.type + '</td><td>' + b.status + '</td><td>$' + b.amount + '</td></tr>';
                    });
                    html += '</tbody></table>';
                }
                html += '</div>';
                $('#bdc-customer-result').html(html);
            } else {
                $('#bdc-customer-result').html('<div class="notice notice-error" style="margin-top:16px;"><p><?php esc_html_e("Customer not found.", "babarida-dive"); ?></p></div>');
            }
        }).fail(function(){
            $btn.prop('disabled', false).text('<?php esc_html_e("Search", "babarida-dive"); ?>');
            $('#bdc-customer-result').html('<div class="notice notice-error" style="margin-top:16px;"><p><?php esc_html_e("Request failed.", "babarida-dive"); ?></p></div>');
        });
    });
    $('#bdc-customer-search').keypress(function(e){ if(e.which===13) $('#bdc-search-customer').click(); });
});
</script>
