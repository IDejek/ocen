<?php
/**
 * Custom Login Page
 * @package Babarida_Dive
 */
defined('ABSPATH') || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php esc_html_e('Login', 'babarida-dive'); ?> - <?php bloginfo('name'); ?></title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'DM Sans',sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;background:#001D3D;overflow:hidden;position:relative;}
body::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(0,53,102,0.9),rgba(0,29,61,0.95));z-index:1;}
.login-bg{position:absolute;inset:0;background:linear-gradient(135deg,#003566,#0077B6);opacity:0.3;}
.login-form{position:relative;z-index:2;width:90%;max-width:440px;background:rgba(255,255,255,0.08);backdrop-filter:blur(30px);-webkit-backdrop-filter:blur(30px);border:1px solid rgba(255,255,255,0.1);border-radius:20px;padding:48px 40px;}
.login-logo{text-align:center;margin-bottom:32px;}
.login-logo h2{font-family:'Playfair Display',serif;font-size:28px;color:white;margin-bottom:4px;}
.login-logo p{color:#48CAE4;font-size:13px;letter-spacing:3px;text-transform:uppercase;}
.form-group{margin-bottom:20px;}
.form-group label{display:block;font-size:13px;font-weight:500;color:rgba(255,255,255,0.7);margin-bottom:6px;}
.form-group input{width:100%;padding:14px 18px;border-radius:12px;border:2px solid rgba(255,255,255,0.1);background:rgba(255,255,255,0.06);color:white;font-size:15px;font-family:inherit;transition:border-color 0.3s;}
.form-group input::placeholder{color:rgba(255,255,255,0.35);}
.form-group input:focus{outline:none;border-color:#48CAE4;background:rgba(255,255,255,0.1);}
.login-submit{width:100%;padding:14px;border-radius:12px;border:none;background:linear-gradient(135deg,#FFB703,#FB8500);color:#001D3D;font-size:15px;font-weight:700;font-family:inherit;cursor:pointer;transition:transform 0.3s,box-shadow 0.3s;}
.login-submit:hover{transform:translateY(-2px);box-shadow:0 8px 25px rgba(255,183,3,0.4);}
.login-footer{text-align:center;margin-top:24px;}
.login-footer a{color:#48CAE4;font-size:14px;text-decoration:none;}
.login-footer a:hover{color:#FFB703;}
.login-error{background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);color:#FCA5A5;padding:12px;border-radius:10px;font-size:14px;margin-bottom:20px;text-align:center;}
.remember{display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.7);font-size:13px;margin-bottom:20px;}
.remember input{accent-color:#FFB703;}
</style>
</head>
<body>
<div class="login-bg"></div>
<div class="login-form">
    <div class="login-logo">
        <h2><?php echo esc_html(get_bloginfo('name')); ?></h2>
        <p><?php esc_html_e('Admin Portal', 'babarida-dive'); ?></p>
    </div>

    <?php
    $error = '';
    if (isset($_POST['bdc_login_submit'])) {
        $creds = array(
            'user_login'    => sanitize_text_field($_POST['log'] ?? ''),
            'user_password' => $_POST['pwd'] ?? '',
            'remember'      => isset($_POST['rememberme']),
        );
        $user = wp_signon($creds, false);
        if (is_wp_error($user)) {
            $error = $user->get_error_message();
        } else {
            wp_redirect(admin_url());
            exit;
        }
    }
    if ($error) echo '<div class="login-error">' . esc_html(strip_tags($error)) . '</div>';
    ?>

    <form method="post" action="">
        <div class="form-group">
            <label for="log"><?php esc_html_e('Username or Email', 'babarida-dive'); ?></label>
            <input type="text" name="log" id="log" required autofocus>
        </div>
        <div class="form-group">
            <label for="pwd"><?php esc_html_e('Password', 'babarida-dive'); ?></label>
            <input type="password" name="pwd" id="pwd" required>
        </div>
        <label class="remember">
            <input type="checkbox" name="rememberme" id="rememberme">
            <?php esc_html_e('Remember me', 'babarida-dive'); ?>
        </label>
        <button type="submit" name="bdc_login_submit" class="login-submit"><?php esc_html_e('Sign In', 'babarida-dive'); ?></button>
    </form>

    <div class="login-footer">
        <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'babarida-dive'); ?></a>
    </div>
</div>
</body>
</html>
