<?php
/*
Plugin Name: Form To Online Booking
Description: CF7 to Calendly integration with peramters and values.This plugin required CF7 Installtion.
Author: Nabeel Tahir    
Version: 1.0
License: GPLv2 or later
Text Domain: form-to-online-booking
*/

/*  Copyright 2014-2020 Scott Paterson

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

require_once('public/public-form.php');
function calendlycf7_stylesheet() 
{
    wp_enqueue_style( 'calendlycss', plugins_url( '/assets/style.css', __FILE__ ) );
}
add_action('admin_print_styles', 'calendlycf7_stylesheet');
function calendlycf7_is_active() {
    if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
        // admin includes
		if (is_admin()) {
            include_once('admin/cf7_tab.php');
    } }
    else {           
        // give warning if contact form 7 is not active
        function calendlycf7_my_admin_notice() {
            ?>
            <div class="error">
                <p><?php _e( '<b>Contact Form 7 - Calendly Integration</b> Contact Form 7 is not installed and / or active! Please install or activate: <a href="'.get_admin_url().'/plugin-install.php?s=contact-form-7&tab=search&type=term">Contact Form 7</a>.', 'cf7rl' ); ?></p>
            </div>
            <?php
        }
        add_action( 'admin_notices', 'calendlycf7_my_admin_notice' );       
    } 
  }
  add_action( 'admin_init', 'calendlycf7_is_active' );

?>