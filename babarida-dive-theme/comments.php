<?php
/**
 * Comments Template
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;

if (post_password_required()) return;

if (have_comments()) : ?>
<section id="comments" class="comments-area">
    <h3 class="section-title" style="font-size:24px;margin-bottom:24px;">
        <?php
        $count = get_comments_number();
        printf(esc_html(_n('%d Review', '%d Reviews', $count, 'babarida-dive')), $count);
        ?>
    </h3>
    <ol class="comment-list">
        <?php
        wp_list_comments(array(
            'style'       => 'ol',
            'short_ping'  => true,
            'avatar_size' => 56,
            'callback'    => 'bdc_comment_callback',
        ));
        ?>
    </ol>
    <?php the_comments_navigation(); ?>
</section>
<?php endif;

if (comments_open()) : ?>
<div id="respond" class="comment-respond">
    <h3 class="section-title" style="font-size:22px;margin-bottom:20px;"><?php comment_form_title(__('Leave a Review', 'babarida-dive')); ?></h3>
    <?php comment_form(array(
        'class_form'         => 'comment-form',
        'title_reply_before' => '',
        'title_reply_after'  => '',
        'comment_field'      => '<div class="form-group"><label class="form-label" for="comment">' . __('Your Review', 'babarida-dive') . '</label><textarea class="form-textarea" id="comment" name="comment" rows="5" required></textarea></div>',
        'fields'             => array(
            'author' => '<div class="form-row"><div class="form-group"><label class="form-label" for="author">' . __('Name', 'babarida-dive') . ' *</label><input class="form-input" id="author" name="author" type="text" required></div>',
            'email'  => '<div class="form-group"><label class="form-label" for="email">' . __('Email', 'babarida-dive') . ' *</label><input class="form-input" id="email" name="email" type="email" required></div></div>',
        ),
        'submit_button'      => '<button type="submit" class="btn btn-primary">%4$s</button>',
        'comment_notes_before'=> '',
    )); ?>
</div>
<?php endif;

function bdc_comment_callback($comment, $args, $depth) {
    $tag = ('div' === $args['style']) ? 'div' : 'li';
    ?>
    <<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class('glass-card', $comment); ?> style="padding:24px;margin-bottom:16px;">
        <div style="display:flex;gap:16px;align-items:flex-start;">
            <div>
                <?php echo get_avatar($comment, $args['avatar_size']); ?>
            </div>
            <div style="flex:1;">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;flex-wrap:wrap;">
                    <strong style="font-size:15px;"><?php echo get_comment_author_link($comment); ?></strong>
                    <span style="font-size:12px;color:var(--mid-gray);"><?php echo get_comment_date('', $comment); ?></span>
                </div>
                <?php if ($comment->comment_approved == '0') : ?>
                    <p style="font-size:13px;color:var(--warning);"><?php esc_html_e('Your review is awaiting moderation.', 'babarida-dive'); ?></p>
                <?php endif; ?>
                <div style="font-size:14px;color:var(--dark-gray);line-height:1.7;"><?php comment_text(); ?></div>
                <div style="margin-top:8px;">
                    <?php comment_reply_link(array_merge($args, array('add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth'], 'before' => '', 'after' => ''))); ?>
                </div>
            </div>
        </div>
    </<?php echo $tag; ?>>
    <?php
}
