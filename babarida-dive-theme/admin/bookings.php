<?php defined('ABSPATH') || exit; ?>
<div class="wrap">
    <h1 style="font-family:Playfair Display,serif;"><?php esc_html_e('Booking Management', 'babarida-dive'); ?></h1>
    <div style="margin:20px 0;display:flex;gap:12px;flex-wrap:wrap;">
        <select id="bdc-filter-status" style="padding:8px 12px;border:1px solid #ddd;border-radius:6px;">
            <option value=""><?php esc_html_e('All Statuses', 'babarida-dive'); ?></option>
            <option value="pending"><?php esc_html_e('Pending', 'babarida-dive'); ?></option>
            <option value="confirmed"><?php esc_html_e('Confirmed', 'babarida-dive'); ?></option>
            <option value="paid"><?php esc_html_e('Paid', 'babarida-dive'); ?></option>
            <option value="checked-in"><?php esc_html_e('Checked-In', 'babarida-dive'); ?></option>
            <option value="completed"><?php esc_html_e('Completed', 'babarida-dive'); ?></option>
            <option value="cancelled"><?php esc_html_e('Cancelled', 'babarida-dive'); ?></option>
        </select>
        <input type="text" id="bdc-search-booking" placeholder="<?php esc_attr_e('Search by name, email, or ID...', 'babarida-dive'); ?>" style="padding:8px 12px;border:1px solid #ddd;border-radius:6px;min-width:250px;">
        <button class="button" id="bdc-export-excel"><?php esc_html_e('Export Excel', 'babarida-dive'); ?></button>
        <button class="button" id="bdc-export-pdf"><?php esc_html_e('Export PDF', 'babarida-dive'); ?></button>
    </div>
    <table class="wp-list-table widefat fixed striped" id="bdc-bookings-table">
        <thead>
            <tr>
                <th>ID</th><th>Guest</th><th>Email</th><th>Trip</th><th>Date</th><th>Guests</th><th>Amount</th><th>Status</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $bookings = get_posts(array('post_type' => 'bdc_booking', 'posts_per_page' => 50, 'orderby' => 'date', 'order' => 'DESC'));
            foreach ($bookings as $b) :
                $status = get_post_meta($b->ID, 'status', true);
                $total = get_post_meta($b->ID, 'total_price', true);
            ?>
            <tr>
                <td><strong><a href="<?php echo esc_url(get_edit_post_link($b->ID)); ?>">BDC-<?php echo $b->ID; ?></a></strong></td>
                <td><?php echo esc_html(get_post_meta($b->ID, 'name', true)); ?></td>
                <td><?php echo esc_html(get_post_meta($b->ID, 'email', true)); ?></td>
                <td><?php echo esc_html(get_post_meta($b->ID, 'trip_type', true)); ?></td>
                <td><?php echo esc_html(get_post_meta($b->ID, 'date', true)); ?></td>
                <td><?php echo esc_html(get_post_meta($b->ID, 'guests', true)); ?></td>
                <td><?php echo $total ? '$' . number_format($total) : '-'; ?></td>
                <td><span class="bdc-badge bdc-badge-<?php echo esc_attr($status); ?>"><?php echo esc_html(ucfirst($status)); ?></span></td>
                <td>
                    <a href="<?php echo esc_url(get_edit_post_link($b->ID)); ?>" class="button button-small"><?php esc_html_e('Edit', 'babarida-dive'); ?></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
