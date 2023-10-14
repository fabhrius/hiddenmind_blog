<?php

function restrict_checkout_for_logged_out_users() {
    if (is_checkout() && !is_user_logged_in()) {
        wp_redirect(wp_login_url());
        exit;
    }
}


add_action('template_redirect', 'restrict_checkout_for_logged_out_users');



?>