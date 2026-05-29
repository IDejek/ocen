<?php
/**
 * Template Name: Book Now
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;
get_header();
?>

<main id="main-content" role="main">
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-list">
                <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'babarida-dive'); ?></a>
                <span class="breadcrumb-sep">/</span>
                <span><?php esc_html_e('Book Now', 'babarida-dive'); ?></span>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="container" style="max-width:700px;">
            <div class="section-header">
                <h1 class="section-title"><?php esc_html_e('Book Your Adventure', 'babarida-dive'); ?></h1>
                <p class="section-desc"><?php esc_html_e('Fill in the details and we\'ll get back to you within 24 hours with a confirmed itinerary and quote.', 'babarida-dive'); ?></p>
            </div>

            <div class="glass-card" style="padding:40px;">
                <form id="page-booking-form" novalidate>
                    <?php wp_nonce_field('bdc_nonce', 'booking_nonce'); ?>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label"><?php esc_html_e('Full Name *', 'babarida-dive'); ?></label>
                            <input class="form-input" type="text" name="name" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?php esc_html_e('Email *', 'babarida-dive'); ?></label>
                            <input class="form-input" type="email" name="email" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label"><?php esc_html_e('Phone / WhatsApp', 'babarida-dive'); ?></label>
                            <input class="form-input" type="tel" name="phone">
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?php esc_html_e('Nationality', 'babarida-dive'); ?></label>
                            <input class="form-input" type="text" name="nationality">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label"><?php esc_html_e('Trip Type', 'babarida-dive'); ?></label>
                            <select class="form-select" name="trip_type">
                                <option value=""><?php esc_html_e('Select...', 'babarida-dive'); ?></option>
                                <option value="liveaboard"><?php esc_html_e('Liveaboard', 'babarida-dive'); ?></option>
                                <option value="dive-stay"><?php esc_html_e('Dive & Stay', 'babarida-dive'); ?></option>
                                <option value="day-trip"><?php esc_html_e('Day Trip', 'babarida-dive'); ?></option>
                                <option value="snorkeling"><?php esc_html_e('Snorkeling', 'babarida-dive'); ?></option>
                                <option value="dive-safari"><?php esc_html_e('Dive Safari', 'babarida-dive'); ?></option>
                                <option value="watersport"><?php esc_html_e('Water Sports', 'babarida-dive'); ?></option>
                                <option value="course"><?php esc_html_e('Dive Course', 'babarida-dive'); ?></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?php esc_html_e('Preferred Date', 'babarida-dive'); ?></label>
                            <input class="form-input" type="date" name="date">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label"><?php esc_html_e('Destination', 'babarida-dive'); ?></label>
                            <select class="form-select" name="destination">
                                <option value=""><?php esc_html_e('Select...', 'babarida-dive'); ?></option>
                                <option value="bunaken">Bunaken</option>
                                <option value="siladen">Siladen</option>
                                <option value="bangka">Bangka</option>
                                <option value="lembeh">Lembeh</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?php esc_html_e('Number of Guests', 'babarida-dive'); ?></label>
                            <input class="form-input" type="number" name="guests" min="1" max="50" value="1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label"><?php esc_html_e('Special Requests', 'babarida-dive'); ?></label>
                        <textarea class="form-textarea" name="message" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">
                        <?php esc_html_e('Submit Booking Request', 'babarida-dive'); ?>
                    </button>
                </form>
            </div>
        </div>
    </section>
</main>

<script>
jQuery(function($){
    $('#page-booking-form').on('submit', function(e){
        e.preventDefault();
        var btn = $(this).find('button[type="submit"]');
        btn.prop('disabled', true).text('<?php esc_html_e("Sending...", "babarida-dive"); ?>');
        var fd = new FormData(this);
        fd.append('action', 'bdc_submit_booking');
        fd.append('nonce', bdcData.nonce);
        $.post(bdcData.ajaxUrl, fd, function(res){
            if(res.success){
                $(this).html('<div style="text-align:center;padding:40px 0;"><div style="width:80px;height:80px;border-radius:50%;background:#10B981;color:white;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:36px;">✓</div><h3><?php esc_html_e("Booking Submitted!", "babarida-dive"); ?></h3><p style="color:var(--mid-gray);"><?php esc_html_e("We'll contact you within 24 hours.", "babarida-dive"); ?></p></div>');
            } else {
                alert(res.data.message || '<?php esc_html_e("Error. Please try again.", "babarida-dive"); ?>');
                btn.prop('disabled', false).text('<?php esc_html_e("Submit Booking Request", "babarida-dive"); ?>');
            }
        }.bind(this));
    });
});
</script>

<?php get_footer(); ?>
