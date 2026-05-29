<?php defined('ABSPATH') || exit; ?>
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
        var email = $('#bdc-customer-search').val();
        if(!email) return;
        $.post(ajaxurl, {action:'bdc_get_customer', nonce:'<?php echo wp_create_nonce("bdc_admin_nonce"); ?>', email:email}, function(res){
            if(res.success){
                var p = res.data;
                var html = '<div class="bdc-card"><h3>'+p.name+'</h3><p>Email: '+p.email+'</p><p>Nationality: '+p.nationality+'</p>';
                html += '<p>Total Trips: '+p.total_trips+'</p><p>Total Spent: $'+p.total_spent+'</p><p>Total Dives: '+p.total_dives+'</p>';
                html += '<h4>Booking History</h4><table class="bdc-table"><thead><tr><th>Date</th><th>Trip</th><th>Status</th><th>Amount</th></tr></thead><tbody>';
                p.bookings.forEach(function(b){ html += '<tr><td>'+b.date+'</td><td>'+b.type+'</td><td>'+b.status+'</td><td>$'+b.amount+'</td></tr>'; });
                html += '</tbody></table></div>';
                $('#bdc-customer-result').html(html);
            } else { $('#bdc-customer-result').html('<p>Customer not found.</p>'); }
        });
    });
});
</script>
<?php
// AJAX handler
add_action('wp_ajax_bdc_get_customer', function() {
    check_ajax_referer('bdc_admin_nonce', 'nonce');
    $email = sanitize_email($_POST['email'] ?? '');
    if ($email) wp_send_json_success(BDC_CRM::get_customer_profile($email));
    wp_send_json_error();
});
