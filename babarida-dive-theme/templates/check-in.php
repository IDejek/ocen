<?php
/**
 * Template Name: Check-In
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;
get_header();
?>

<main id="main-content" role="main">
    <div class="checkin-page">
        <div class="container">
            <div class="checkin-card">
                <h2 style="font-family:var(--font-display);font-size:28px;text-align:center;margin-bottom:8px;"><?php esc_html_e('Online Check-In', 'babarida-dive'); ?></h2>
                <p style="text-align:center;color:var(--mid-gray);margin-bottom:32px;"><?php esc_html_e('Complete your check-in before arriving at the dive center.', 'babarida-dive'); ?></p>

                <div class="checkin-steps">
                    <div class="checkin-step active">
                        <span class="checkin-step-num">1</span>
                        <?php esc_html_e('Find Booking', 'babarida-dive'); ?>
                    </div>
                    <div class="checkin-step">
                        <span class="checkin-step-num">2</span>
                        <?php esc_html_e('Details', 'babarida-dive'); ?>
                    </div>
                    <div class="checkin-step">
                        <span class="checkin-step-num">3</span>
                        <?php esc_html_e('Confirm', 'babarida-dive'); ?>
                    </div>
                </div>

                <!-- Step 1: Find Booking -->
                <div class="checkin-step-form" id="checkin-step-1">
                    <div class="form-group">
                        <label class="form-label"><?php esc_html_e('Booking Reference or Email', 'babarida-dive'); ?></label>
                        <input class="form-input" type="text" id="checkin-search" placeholder="<?php esc_attr_e('e.g. BDC-123 or your@email.com', 'babarida-dive'); ?>">
                    </div>
                    <button class="btn btn-primary" style="width:100%;" id="checkin-find"><?php esc_html_e('Find My Booking', 'babarida-dive'); ?></button>
                </div>

                <!-- Step 2: Details -->
                <div class="checkin-step-form" id="checkin-step-2" style="display:none;">
                    <form id="checkin-form">
                        <?php wp_nonce_field('bdc_nonce', 'checkin_nonce'); ?>
                        <input type="hidden" name="booking_id" id="checkin-booking-id">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label"><?php esc_html_e('Passport Number', 'babarida-dive'); ?></label>
                                <input class="form-input" type="text" name="passport_number" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><?php esc_html_e('Passport Expiry', 'babarida-dive'); ?></label>
                                <input class="form-input" type="date" name="passport_expiry" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?php esc_html_e('Hotel Pickup Location', 'babarida-dive'); ?></label>
                            <input class="form-input" type="text" name="hotel_pickup" placeholder="<?php esc_attr_e('Hotel name or address in Manado', 'babarida-dive'); ?>">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label"><?php esc_html_e('Certification Level', 'babarida-dive'); ?></label>
                                <select class="form-select" name="certification_level">
                                    <option value=""><?php esc_html_e('Select...', 'babarida-dive'); ?></option>
                                    <option value="non-diver"><?php esc_html_e('Non-Diver / Snorkeler', 'babarida-dive'); ?></option>
                                    <option value="open-water"><?php esc_html_e('Open Water', 'babarida-dive'); ?></option>
                                    <option value="advanced"><?php esc_html_e('Advanced Open Water', 'babarida-dive'); ?></option>
                                    <option value="rescue"><?php esc_html_e('Rescue Diver', 'babarida-dive'); ?></option>
                                    <option value="divemaster"><?php esc_html_e('Divemaster', 'babarida-dive'); ?></option>
                                    <option value="instructor"><?php esc_html_e('Instructor', 'babarida-dive'); ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><?php esc_html_e('Total Logged Dives', 'babarida-dive'); ?></label>
                                <input class="form-input" type="number" name="dives_count" min="0" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label"><?php esc_html_e('Medical Conditions', 'babarida-dive'); ?></label>
                            <textarea class="form-textarea" name="medical_conditions" rows="2" placeholder="<?php esc_attr_e('List any medical conditions or medications', 'babarida-dive'); ?>"></textarea>
                        </div>
                        <div style="display:flex;gap:12px;">
                            <button type="button" class="btn btn-outline checkin-prev" data-step="1"><?php esc_html_e('Back', 'babarida-dive'); ?></button>
                            <button type="submit" class="btn btn-primary" style="flex:1;"><?php esc_html_e('Complete Check-In', 'babarida-dive'); ?></button>
                        </div>
                    </form>
                </div>

                <!-- Step 3: Confirmation -->
                <div class="checkin-step-form" id="checkin-step-3" style="display:none;">
                    <div style="text-align:center;padding:40px 0;">
                        <div style="width:80px;height:80px;border-radius:50%;background:#10B981;color:white;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:36px;">✓</div>
                        <h3 style="font-family:var(--font-display);font-size:24px;margin-bottom:8px;"><?php esc_html_e('Check-In Complete!', 'babarida-dive'); ?></h3>
                        <p style="color:var(--mid-gray);margin-bottom:24px;"><?php esc_html_e('Your check-in has been submitted. See you at the dive center!', 'babarida-dive'); ?></p>
                        <div id="checkin-qr" style="margin-bottom:24px;"></div>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary"><?php esc_html_e('Back to Home', 'babarida-dive'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
