<?php defined('ABSPATH') || exit; ?>
<div class="wrap">
    <h1 style="font-family:Playfair Display,serif;"><?php esc_html_e('Staff Chat', 'babarida-dive'); ?></h1>
    <div class="bdc-card" style="margin-top:20px;">
        <div id="admin-chat-messages" style="height:400px;overflow-y:auto;padding:16px;background:#f9f9f9;border-radius:12px;margin-bottom:16px;"></div>
        <div style="display:flex;gap:8px;">
            <input type="text" id="admin-chat-input" placeholder="<?php esc_attr_e('Type a message...', 'babarida-dive'); ?>" style="flex:1;padding:12px 16px;border:1px solid #ddd;border-radius:12px;">
            <button class="button button-primary" id="admin-chat-send"><?php esc_html_e('Send', 'babarida-dive'); ?></button>
        </div>
    </div>
</div>
