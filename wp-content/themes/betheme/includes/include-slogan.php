<?php
/**
 * Action Bar slogan area
 *
 * @package Betheme
 * @author Muffin group
 * @link https://muffingroup.com
 */

?>

<ul class="contact_details" aria-label="<?php _e('contact details', 'betheme'); ?>">
  <?php
    if ($header_slogan = mfn_opts_get('header-slogan')) {
      echo '<li class="slogan">'. do_shortcode(wp_kses($header_slogan, mfn_allowed_html('desc'))) .'</li>';
    }
    if ($header_phone = mfn_opts_get('header-phone')) {
      echo '<li class="phone phone-1"><i class="icon-phone"></i><a href="tel:'. esc_attr(str_replace(' ', '', $header_phone)) .'" aria-label="'. __('phone', 'betheme') .'">'. esc_html($header_phone) .'</a></li>';
    }
    if ($header_phone_2 = mfn_opts_get('header-phone-2')) {
      echo '<li class="phone phone-2"><i class="icon-phone"></i><a href="tel:'. esc_attr(str_replace(' ', '', $header_phone_2)) .'" aria-label="'. __('phone', 'betheme') .'">'. esc_html($header_phone_2) .'</a></li>';
    }
    if ($header_email = mfn_opts_get('header-email')) {
      echo '<li class="mail"><i class="icon-mail-line"></i><a href="mailto:'. sanitize_email($header_email) .'" aria-label="'. __('mail', 'betheme') .'">'. esc_html($header_email) .'</a></li>';
    }
  ?>
</ul>
