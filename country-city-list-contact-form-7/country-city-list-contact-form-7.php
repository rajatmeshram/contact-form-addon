<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://rajatmeshram.in/
 * @since             1.0.0
 * @package           Country_City_List_Contact_Form_7
 *
 * @wordpress-plugin
 * Plugin Name:       Country & City List Field Contact Form 7
 * Plugin URI:        https://https://rajatmeshram.in/
 * Description:       Add country, city drop down list extensions field in contact form 7.
 * Version:           1.0.0
 * Author:            Rajat Meshram
 * Author URI:        https://https://rajatmeshram.in/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       country-city-list-contact-form-7
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'COUNTRY_CITY_LIST_CONTACT_FORM_7_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-country-city-list-contact-form-7-activator.php
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-country-city-list-contact-form-7-activator.php';
function installer(){
    global $wpdb;
	$table_name = $wpdb->prefix . "cclist_table";
	$charset_collate = $wpdb->get_charset_collate();
	if ( $wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name ) {
	    $sql = "CREATE TABLE $table_name (
	            id mediumint(9) NOT NULL AUTO_INCREMENT,
	            `country` varchar(50) NOT NULL,
	            `state`  varchar(50) NOT NULL,
	            `city`  varchar(50) NOT NULL,
	            PRIMARY KEY  (id)
	    ) $charset_collate;";
	    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	    dbDelta($sql);

	}
}
register_activation_hook(__file__, 'installer');
