<?php
error_reporting(0);
/**
 * Generate the tag inside the contact form
 *
 *
 * @since      1.0.0
 * @package    Country_City_List_Contact_Form_7
 * @subpackage Country_City_List_Contact_Form_7/includes
 * @author     Rajat Meshram <support@rajatmeshram.in>
 */

add_action( 'wpcf7_init', 'ccl_add_form_tag_countrycitylist' );

function ccl_add_form_tag_countrycitylist() {
	wpcf7_add_form_tag(
		array( 'countrycitylist', 'countrycitylist*'),
		'ccl_countrycitylist_form_tag_handler', array( 'name-attr' => true ) );
}
function ccl_countrycitylist_form_tag_handler( $tag ) {
    if ( empty( $tag->name ) ) {
		return '';
	}
    $class = wpcf7_form_controls_class( $tag->type, 'wpcf7-text' );

	if ( in_array( $tag->basetype, array( 'countrytext', 'countrytext*' ) ) ) {
		$class .= ' wpcf7-validates-as-' . $tag->basetype;
	}
    $atts = array();
    //$atts['size'] = $tag->get_size_option( '10' );
	$atts['maxlength'] = $tag->get_maxlength_option();
	$atts['minlength'] = $tag->get_minlength_option();

	if ( $atts['maxlength'] && $atts['minlength']
	&& $atts['maxlength'] < $atts['minlength'] ) {
		unset( $atts['maxlength'], $atts['minlength'] );
	}

	$atts['class'] = $tag->get_class_option( $class );
	$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );

	$atts['autocomplete'] = $tag->get_option( 'autocomplete',
		'[-0-9a-zA-Z]+', true );

	if ( $tag->has_option( 'readonly' ) ) {
		$atts['readonly'] = 'readonly';
	}

	if ( $tag->is_required() ) {
		$atts['aria-required'] = 'true';
	}

	if ( $validation_error ) {
		$atts['aria-invalid'] = 'true';
		$atts['aria-describedby'] = wpcf7_get_validation_error_reference(
			$tag->name
		);
	} else {
		$atts['aria-invalid'] = 'false';
	}

	$value = (string) reset( $tag->values );

	if ( $tag->has_option( 'placeholder' ) || $tag->has_option( 'watermark' ) ) {
		$atts['placeholder'] = $value;
		$value = '';
	}
	$data.='<span class="wpcf7-form-control-wrap" data-name="%1$s">';
	$doptions = get_option('defcountry');
	if(!empty($doptions)){
		$options = '<option value='.$doptions.'>'.$doptions.'</option>';
	}
	if(empty($doptions)){
	global $wpdb;
	$tablename = $wpdb->prefix."cclist_table";
	$countrylist = $wpdb->get_results("SELECT country FROM ".$tablename." ");
    foreach ($countrylist as $list){
           $countyr_arr[] = $list->country;
            }
		$myJSON = json_encode($countyr_arr);
		$unique = array_unique($countyr_arr);
		foreach($unique as $clist){
			$options .= '<option value='.$clist.'>'.$clist.'</option>';
		}		 
	}
	
	?>
	<?php	
	$data.= '<input type="hidden"  %2$s>
	<select id="countrylist" name="country">
	<option value="-1">select Country</option>
	'.$options.'
	</select>';
	$data.= '<select id="ccl-state" name="state"><option value="-1">Select state</option></select>
	<select  id="ccl-city" name="city"><option value="-1">Select City</option></select></span>';
	$value = $tag->get_default_option( $value );

	$value = wpcf7_get_hangover( $tag->name, $value );

	$atts['value'] = $value.$_POST['country'].$_POST['state'].$_POST['city'];

	$atts['type'] = 'text';
	
	$atts['name'] = $tag->name;

	$atts = wpcf7_format_atts( $atts );


    $html = sprintf($data,sanitize_html_class( $tag->name ), $atts, $validation_error );

	return $html;
}

add_action( 'wpcf7_admin_init', 'ccl_add_tag_generator_countrytext', 20 );
function ccl_add_tag_generator_countrytext() {
	$tag_generator = WPCF7_TagGenerator::get_instance();
	 $tag_generator->add( 'countrycitylist', __( 'Country City drop-down', 'ccl-cpf' ),
 	'ccl_add_tag_generator_countrylist' );
}
function ccl_add_tag_generator_countrylist( $contact_form, $args = '' ) {
	$args = wp_parse_args( $args, array() );
	$type = 'countrycitylist';

	$description = __( "Generate a form-tag for a country city dorp list.", 'ccl-cpf' );
	$desc_link = '';
?>
<div class="control-box">
<fieldset>
<legend><?php echo sprintf( esc_html( $description ), $desc_link ); ?></legend>

<table class="form-table">
<tbody>
	<tr>
	<th scope="row"><?php echo esc_html( __( 'Field type', 'ccl-cpf' ) ); ?></th>
	<td>
		<fieldset>
		<legend class="screen-reader-text"><?php echo esc_html( __( 'Field type', 'ccl-cpf' ) ); ?></legend>
		<label><input type="checkbox" name="required" /> <?php echo esc_html( __( 'Required field', 'ccl-cpf' ) ); ?></label>
		</fieldset>
	</td>
	</tr>

	<tr>
	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'ccl-cpf' ) ); ?></label></th>
	<td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /></td>
	</tr>

	<tr>
	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-values' ); ?>"><?php echo esc_html( __( 'Default value', 'ccl-cpf' ) ); ?></label></th>
	<td><input type="text" name="values" class="oneline" id="<?php echo esc_attr( $args['content'] . '-values' ); ?>" /><br />
	<label><input type="checkbox" name="placeholder" class="option" /> <?php echo esc_html( __( 'Use this text as the placeholder of the field', 'ccl-cpf' ) ); ?></label></td>
	</tr>
	<tr>
	<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-class' ); ?>"><?php echo esc_html( __( 'Class attribute', 'ccl-cpf' ) ); ?></label></th>
	<td><input type="text" name="class" class="classvalue oneline option" id="<?php echo esc_attr( $args['content'] . '-class' ); ?>" /></td>
	</tr>

</tbody>
</table>
</fieldset>
</div>

<div class="insert-box">
	<input type="text" name="<?php echo $type; ?>" class="tag code" readonly="readonly" onfocus="this.select()" />

	<div class="submitbox">
	<input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'ccl-cpf' ) ); ?>" />
	</div>

	<br class="clear" />

	<p class="description mail-tag"><label for="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>"><?php echo sprintf( esc_html( __( "To use the value input through this field in a mail field, you need to insert the corresponding mail-tag (%s) into the field on the Mail tab.", 'ccl-cpf' ) ), '<strong><span class="mail-tag"></span></strong>' ); ?><input type="text" class="mail-tag code hidden" readonly="readonly" id="<?php echo esc_attr( $args['content'] . '-mailtag' ); ?>" /></label></p>
</div>
<?php
}
include_once('func-ajax.php');
?>
