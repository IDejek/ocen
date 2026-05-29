<?php
/**
 * Theme Footer
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;
?>

<!-- Newsletter Section -->
<?php get_template_part('template-parts/newsletter'); ?>

<!-- Footer -->
<footer class="site-footer" role="contentinfo">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="nav-logo-text">
                    <?php echo esc_html(get_bloginfo('name')); ?>
                    <small><?php esc_html_e('Dive Center', 'babarida-dive'); ?></small>
                </div>
                <p><?php echo esc_html(get_bloginfo('description')); ?></p>
                <div class="footer-social">
                    <a href="#" aria-label="Instagram"><i data-lucide="instagram" style="width:18px;height:18px;"></i></a>
                    <a href="#" aria-label="Facebook"><i data-lucide="facebook" style="width:18px;height:18px;"></i></a>
                    <a href="#" aria-label="YouTube"><i data-lucide="youtube" style="width:18px;height:18px;"></i></a>
                    <a href="#" aria-label="TikTok"><i data-lucide="music" style="width:18px;height:18px;"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4><?php esc_html_e('Destinations', 'babarida-dive'); ?></h4>
                <?php
                $dests = get_terms(array('taxonomy' => 'bdc_destination', 'hide_empty' => true));
                if (!is_wp_error($dests) && !empty($dests)) :
                    echo '<ul>';
                    foreach ($dests as $d) :
                        echo '<li><a href="' . get_term_link($d) . '">' . esc_html($d->name) . '</a></li>';
                    endforeach;
                    echo '</ul>';
                else :
                    echo '<ul>';
                    echo '<li><a href="' . esc_url(home_url('/bunaken')) . '">Bunaken</a></li>';
                    echo '<li><a href="' . esc_url(home_url('/siladen')) . '">Siladen</a></li>';
                    echo '<li><a href="' . esc_url(home_url('/bangka')) . '">Bangka</a></li>';
                    echo '<li><a href="' . esc_url(home_url('/lembeh')) . '">Lembeh</a></li>';
                    echo '</ul>';
                endif;
                ?>
            </div>
            <div class="footer-col">
                <h4><?php esc_html_e('Services', 'babarida-dive'); ?></h4>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/liveaboards')); ?>"><?php esc_html_e('Liveaboards', 'babarida-dive'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/dive-courses')); ?>"><?php esc_html_e('Dive Courses', 'babarida-dive'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/water-sports')); ?>"><?php esc_html_e('Water Sports', 'babarida-dive'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/dive-safari')); ?>"><?php esc_html_e('Dive Safari', 'babarida-dive'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/snorkeling')); ?>"><?php esc_html_e('Snorkeling', 'babarida-dive'); ?></a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4><?php esc_html_e('Contact', 'babarida-dive'); ?></h4>
                <ul>
                    <li><a href="https://wa.me/62895801960359" target="_blank" rel="noopener">WhatsApp: +62 895 8019 60359</a></li>
                    <li><a href="mailto:info@babaridadive.com">info@babaridadive.com</a></li>
                    <li><a href="<?php echo esc_url(home_url('/check-in')); ?>"><?php esc_html_e('Check-In', 'babarida-dive'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/blog')); ?>"><?php esc_html_e('Blog', 'babarida-dive'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/faq')); ?>"><?php esc_html_e('FAQ', 'babarida-dive'); ?></a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>. <?php esc_html_e('All rights reserved.', 'babarida-dive'); ?></p>
            <p><?php esc_html_e('Developed by', 'babarida-dive'); ?> Iqbal Tombinawa</p>
        </div>
    </div>
</footer>

<!-- Floating Buttons -->
<div class="floating-buttons" aria-label="<?php esc_attr_e('Quick actions', 'babarida-dive'); ?>">
    <button class="float-btn float-btn-top" id="float-top" aria-label="<?php esc_attr_e('Back to top', 'babarida-dive'); ?>">
        <i data-lucide="chevron-up" style="width:22px;height:22px;"></i>
        <span class="float-tooltip"><?php esc_html_e('Back to Top', 'babarida-dive'); ?></span>
    </button>
    <a href="mailto:info@babaridadive.com" class="float-btn float-btn-email" aria-label="<?php esc_attr_e('Send email', 'babarida-dive'); ?>">
        <i data-lucide="mail" style="width:22px;height:22px;"></i>
        <span class="float-tooltip"><?php esc_html_e('Email Us', 'babarida-dive'); ?></span>
    </a>
    <a href="https://wa.me/62895801960359" class="float-btn float-btn-whatsapp" target="_blank" rel="noopener" aria-label="<?php esc_attr_e('Chat on WhatsApp', 'babarida-dive'); ?>">
        <i data-lucide="message-circle" style="width:22px;height:22px;"></i>
        <span class="float-tooltip"><?php esc_html_e('WhatsApp', 'babarida-dive'); ?></span>
    </a>
    <button class="float-btn float-btn-booking" id="float-booking" aria-label="<?php esc_attr_e('Book now', 'babarida-dive'); ?>">
        <i data-lucide="calendar-check" style="width:22px;height:22px;"></i>
        <span class="float-tooltip"><?php esc_html_e('Book Now', 'babarida-dive'); ?></span>
    </button>
</div>

<!-- AI Chat Widget -->
<div class="ai-chat-panel" id="ai-chat-panel" role="dialog" aria-label="<?php esc_attr_e('AI Assistant', 'babarida-dive'); ?>">
    <div class="ai-chat-header">
        <div>
            <h4><?php esc_html_e('Babarida AI Assistant', 'babarida-dive'); ?></h4>
            <span><?php esc_html_e('Ask anything about diving', 'babarida-dive'); ?></span>
        </div>
        <button onclick="document.getElementById('ai-chat-panel').classList.remove('active')" aria-label="<?php esc_attr_e('Close chat', 'babarida-dive'); ?>" style="color:white;margin-left:auto;">
            <i data-lucide="x" style="width:20px;height:20px;"></i>
        </button>
    </div>
    <div class="ai-chat-messages" id="ai-chat-messages">
        <div class="ai-msg bot"><?php esc_html_e('Hello! I\'m your diving assistant. How can I help you today? You can ask about destinations, courses, pricing, or anything else!', 'babarida-dive'); ?></div>
    </div>
    <div class="ai-chat-input">
        <input type="text" id="ai-chat-input" placeholder="<?php esc_attr_e('Type your question...', 'babarida-dive'); ?>" aria-label="<?php esc_attr_e('Chat message', 'babarida-dive'); ?>">
        <button id="ai-chat-send" aria-label="<?php esc_attr_e('Send message', 'babarida-dive'); ?>">
            <i data-lucide="send" style="width:18px;height:18px;"></i>
        </button>
    </div>
</div>
<button class="ai-chat-btn" id="ai-chat-btn" aria-label="<?php esc_attr_e('Open AI Assistant', 'babarida-dive'); ?>">
    <i data-lucide="bot" style="width:26px;height:26px;"></i>
</button>

<!-- Booking Modal -->
<div class="modal-overlay" id="booking-modal-overlay"></div>
<div class="modal" id="booking-modal" role="dialog" aria-label="<?php esc_attr_e('Booking form', 'babarida-dive'); ?>">
    <button class="modal-close" id="booking-modal-close" aria-label="<?php esc_attr_e('Close', 'babarida-dive'); ?>">
        <i data-lucide="x" style="width:20px;height:20px;"></i>
    </button>
    <h2 class="modal-title"><?php esc_html_e('Book Your Adventure', 'babarida-dive'); ?></h2>
    <p class="modal-subtitle"><?php esc_html_e('Fill in the details below and we\'ll get back to you within 24 hours.', 'babarida-dive'); ?></p>
    <form id="booking-form" class="booking-form" novalidate>
        <?php wp_nonce_field('bdc_nonce', 'booking_nonce'); ?>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="bk-name"><?php esc_html_e('Full Name *', 'babarida-dive'); ?></label>
                <input class="form-input" type="text" id="bk-name" name="name" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="bk-email"><?php esc_html_e('Email *', 'babarida-dive'); ?></label>
                <input class="form-input" type="email" id="bk-email" name="email" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="bk-phone"><?php esc_html_e('Phone / WhatsApp', 'babarida-dive'); ?></label>
                <input class="form-input" type="tel" id="bk-phone" name="phone">
            </div>
            <div class="form-group">
                <label class="form-label" for="bk-nationality"><?php esc_html_e('Nationality', 'babarida-dive'); ?></label>
                <input class="form-input" type="text" id="bk-nationality" name="nationality">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="bk-trip"><?php esc_html_e('Trip Type', 'babarida-dive'); ?></label>
                <select class="form-select" id="bk-trip" name="trip_type">
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
                <label class="form-label" for="bk-date"><?php esc_html_e('Preferred Date', 'babarida-dive'); ?></label>
                <input class="form-input" type="date" id="bk-date" name="date">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="bk-guests"><?php esc_html_e('Number of Guests', 'babarida-dive'); ?></label>
                <input class="form-input" type="number" id="bk-guests" name="guests" min="1" max="50" value="1">
            </div>
            <div class="form-group">
                <label class="form-label" for="bk-destination"><?php esc_html_e('Destination', 'babarida-dive'); ?></label>
                <select class="form-select" id="bk-destination" name="destination">
                    <option value=""><?php esc_html_e('Select...', 'babarida-dive'); ?></option>
                    <option value="bunaken">Bunaken</option>
                    <option value="siladen">Siladen</option>
                    <option value="bangka">Bangka</option>
                    <option value="lembeh">Lembeh</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="bk-message"><?php esc_html_e('Special Requests', 'babarida-dive'); ?></label>
            <textarea class="form-textarea" id="bk-message" name="message" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-lg" style="width:100%;">
            <i data-lucide="send" style="width:18px;height:18px;"></i>
            <?php esc_html_e('Submit Booking Request', 'babarida-dive'); ?>
        </button>
        <p class="text-center mt-2" style="font-size:13px;color:var(--mid-gray);">
            <?php esc_html_e('No payment required now. We\'ll confirm availability and send you a quote.', 'babarida-dive'); ?>
        </p>
    </form>
</div>

<?php wp_footer(); ?>
</body>
</html>
