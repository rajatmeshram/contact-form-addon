/* Include all js and css files for active theme */
function ccl_cpf_embedCssJs() {
    //wp_enqueue_style( 'nbcpf-intlTelInput-style', NB_CPF_URL . 'assets/css/intlTelInput.min.css' );
	$plugin_url = plugin_dir_url( __FILE__ );
	wp_enqueue_script('jquery'); 
    wp_enqueue_script( 'ccl-countrycity-script',$plugin_url.'/custom.js', array(), '1.0.0', true );

	wp_localize_script( 'ccl-countrycity-script', 'ajaxob', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ), // WordPress AJAX
	) );
}
add_action( 'wp_enqueue_scripts', 'ccl_cpf_embedCssJs' );