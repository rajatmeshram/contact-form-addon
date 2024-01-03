<?php

/**
 * Fired during plugin activation
 *
 * @link       https://https://rajatmeshram.in/
 * @since      1.0.0
 *
 * @package    Country_City_List_Contact_Form_7
 * @subpackage Country_City_List_Contact_Form_7/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Country_City_List_Contact_Form_7
 * @subpackage Country_City_List_Contact_Form_7/includes
 * @author     Rajat Meshram <support@rajatmeshram.in>
 */
class Country_City_List_Contact_Form_7_Activator {
	public function __construct(){
		//add_action( 'plugins_loaded', array( $this, 'nb_load_plugin_textdomain' ) );
		if(class_exists('WPCF7')){
			
			
			
			require_once 'form-tag-generator.php';
			require_once 'settings.php';
		} else {
			add_action( 'admin_notices', array( $this, 'ccl_admin_error_notice' ) );
		}
		
	}
	public function ccl_admin_error_notice(){
		$message = sprintf( esc_html__( 'The Country & City List Field Contact Form 7 plugin requires %1$sContact form 7%2$s plugin active to run properly. Please install %1$scontact form 7%2$s and activate', 'nb-cpf' ),'<strong>', '</strong>');

		printf( '<div class="notice notice-error"><p>%1$s</p></div>', wp_kses_post( $message ) );
	}

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		
	}

}
$ccl_cpf_plugin = new Country_City_List_Contact_Form_7_Activator();