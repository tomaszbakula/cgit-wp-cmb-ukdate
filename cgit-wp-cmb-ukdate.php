<?php

/*

Plugin Name: Castlegate IT WP CMB UK date
Plugin URI: https://github.com/castlegateit/cgit-wp-cmb-ukdate/
Description: UK custom date field for Custom Meta Boxes
Version: 1.1
Author: Richard Lane, Castlegate IT
Author URI: http://www.castlegateit.co.uk/
License: MIT

*/


/**
 * Activation hook
 *
 * Check that the custom meta boxes plugin is installed before activation.
 */
function cgit_wp_cmb_ukdate_activate()
{
    if (!cgit_wp_cmb_ukdate_check_cmb()) {

        $message = 'This plugin requires the <code>Custom-Meta-Boxes</code> ';
        $message.= ' plugin. Please ensure you\'ve installed ';
        $message.= 'it in the correct location: <code>';
        $message.= 'plugins/Custom-Meta-Boxes</code><br /><br />When ';
        $message.= 'download via GitHub\'s web interface, the installation ';
        $message.= 'directory may be <code>plugins/Custom-Meta-Boxes-master';
        $message.=  '</code>. Be sure to remove <code>master</code> from the ';
        $message.= 'directory.<br /><br />Download ';
        $message.= 'from <a target="_blank" href="https://github.com/humanmade';
        $message.= '/Custom-Meta-Boxes">GitHub</a>';
        wp_die($message);
    }
}
register_activation_hook(__FILE__, 'cgit_wp_cmb_ukdate_activate');


/**
 * Check that CustomMetaBoxes plugin is installed
 */
function cgit_wp_cmb_ukdate_check_cmb() {
    return is_plugin_active('Custom-Meta-Boxes/custom-meta-boxes.php');
}


/**
 * Display a notice if the plugin is active and Custom Meta Boxes is no longer
 * installed.
 */
function cgit_wp_cmb_ukdate_installed() {

    if (!cgit_wp_cmb_ukdate_check_cmb()) {

        if (current_user_can('install_plugins')) {

            function cgit_wp_cmb_ukdate_admin_notice_cmb() {

                echo '<div class="error">';
                echo '    <p>CGIT WP CMB UKDate requires <a target="_blank" ';
                echo 'href="https://github.com/humanmade/Custom-Meta-Boxes">';
                echo 'Custom Meta Boxes</a> to be installed and will not ';
                echo 'function correctly without it.</p>';
                echo '</div>';
            }
            add_action('admin_notices', 'cgit_wp_cmb_ukdate_admin_notice_cmb');
        }
    }
    else {
        // Include the class
        include ('cmb-field.class.php');
    }
}
add_action('admin_init', 'cgit_wp_cmb_ukdate_installed', 51);

add_filter( 'cmb_field_types', function( $cmb_field_types ) {
    $cmb_field_types['UK_date'] = 'CGIT_UK_Date_Field';
    return $cmb_field_types;
} );