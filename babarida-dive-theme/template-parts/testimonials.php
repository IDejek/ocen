<?php
/**
 * Testimonials Section Template Part
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

 $testimonials = get_posts(array('post_type' => 'bdc_testimonial', 'posts_per_page' => 10, 'orderby' => 'date', 'order' => 'DESC'));

// Fallback testimonials if none in DB
if (empty($testimonials)) {
    $testimonials = array(
        (object)array('post_title' => 'Sarah M.', 'post_content' => 'An absolutely incredible diving experience! The team at Babarida made everything seamless from booking to the final dive. The coral walls of Bunaken were breathtaking.', 'meta' => array('country' => 'Australia', 'rating' => 5)),
        (object)array('post_title' => 'Thomas K.', 'post_content' => 'Lembeh Strait exceeded all expectations. The muck diving was phenomenal - we saw mimic octopus, flamboyant cuttlefish, and so much more. Highly professional guides.', 'post_content' => 'Lembeh Strait exceeded all expectations. The muck diving was phenomenal!', 'meta' => array('country' => 'Germany', 'rating' => 5)),
        (object)array('post_title' => 'Yuki T.', 'post_content' => 'The liveaboard trip to Bangka was the highlight of our Indonesia vacation. Luxury boat, amazing food, and world-class dive sites. Will definitely return!', 'meta' => array('country' => 'Japan', 'rating' => 5)),
        (object)array('post_title' => 'Marco R.', 'post_content' => 'Completed my SSI Open Water course with Babarida. The instructors were patient, thorough, and made learning to dive so much fun. Siladen was the perfect training ground.', 'meta' => array('country' => 'Italy', 'rating' => 5)),
        (object)array('post_title' => 'Lisa & James W.', 'post_content' => 'We celebrated our anniversary with a dive safari and it was magical. The team arranged everything perfectly. The underwater photos they took were an amazing bonus!', 'meta' => array('country' => 'United Kingdom', 'rating' => 5)),
    );
}
?>

<section class="section" id="testimonials">
    <div class="container">
        <div class="section-header reveal">
            <div class="section-label"><?php esc_html_e('Reviews', 'babarida-dive'); ?></div>
            <h2 class="section-title"><?php esc_html_e('What Our Divers Say', 'babarida-dive'); ?></h2>
        </div>

        <div class="testimonial-slider reveal">
            <div class="testimonial-track" id="testimonial-track">
                <?php $idx = 0; foreach ($testimonials as $t) :
                    $rating = isset($t->meta) ? ($t->meta['rating'] ?? 5) : get_post_meta($t->ID, 'rating', true);
                    $country = isset($t->meta) ? ($t->meta['country'] ?? '') : get_post_meta($t->ID, 'country', true);
                    $content = isset($t->post_content) && !empty($t->post_content) ? $t->post_content : $t->post_content;
                ?>
                <div class="testimonial-slide" data-index="<?php echo $idx; ?>">
                    <div class="testimonial-card">
                        <div class="testimonial-stars">
                            <?php for ($s = 0; $s < (int)$rating; $s++) : ?>
                            <i data-lucide="star" style="width:20px;height:20px;fill:var(--tropical-yellow);color:var(--tropical-yellow);"></i>
                            <?php endfor; ?>
                        </div>
                        <blockquote class="testimonial-quote">"<?php echo esc_html($content); ?>"</blockquote>
                        <div class="testimonial-author">
                            <?php
                            $avatar = isset($t->ID) ? get_post_thumbnail_id($t->ID) : 0;
                            if ($avatar) :
                                echo wp_get_attachment_image($avatar, 'thumbnail', false, array('class' => 'testimonial-avatar'));
                            else :
                            ?>
                            <div class="testimonial-avatar" style="background:var(--bright-blue);color:white;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:20px;">
                                <?php echo esc_html(mb_substr($t->post_title, 0, 1)); ?>
                            </div>
                            <?php endif; ?>
                            <div>
                                <div class="testimonial-name"><?php echo esc_html($t->post_title); ?></div>
                                <?php if ($country) : ?>
                                <div class="testimonial-loc">
                                    <i data-lucide="map-pin" style="width:12px;height:12px;"></i>
                                    <?php echo esc_html($country); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $idx++; endforeach; ?>
            </div>
        </div>

        <div class="testimonial-nav reveal">
            <button id="test-prev" aria-label="<?php esc_attr_e('Previous testimonial', 'babarida-dive'); ?>">
                <i data-lucide="chevron-left" style="width:20px;height:20px;"></i>
            </button>
            <button id="test-next" aria-label="<?php esc_attr_e('Next testimonial', 'babarida-dive'); ?>">
                <i data-lucide="chevron-right" style="width:20px;height:20px;"></i>
            </button>
        </div>
    </div>
</section>
