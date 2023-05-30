<?php

/*
  Plugin Name: Hide Admin Toolbar
  Plugin URI: https://aftabmuni.wordpress.com/
  Description: This plugin is used to hide admin toolbar from website. It will hide that bar when you are logged in and viewing the site.
  Author: Aftab Muni
  Version: 1.0
  Author URI: https://aftabmuni.wordpress.com/
 */

/*
  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
 */

define('AMM_HAT_VERSION', '1.0');
define('AMM_HAT_PLUGIN_URL', plugin_dir_url(__FILE__));
define('AMM_HAT_PLUGIN_DIR', plugin_dir_path(__FILE__));

add_filter('show_admin_bar', '__return_false');
add_action('admin_print_scripts-profile.php', 'amm_hat_add_css_style');

function amm_hat_add_css_style() {
    ?>
    <style type="text/css">
        .show-admin-bar {display: none !important;}
    </style>
    <?php

}
?>