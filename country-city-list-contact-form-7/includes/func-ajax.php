<?php 
/* Include all js and css files for active theme */
add_action('wp_ajax_get_state','get_state_list');
add_action('wp_ajax_nopriv_get_state','get_state_list');
function get_state_list(){
	global $wpdb;
	$tablename = $wpdb->prefix."cclist_table";
	$country = $_POST['newValue'];
	$stateList = $wpdb->get_results("SELECT state FROM ".$tablename." WHERE country = '".$country."' ");
	 foreach ($stateList as $post){
		$stateListarr[] = $post->state;
		}
		$uniqueStateList = array_unique($stateListarr);
		echo '<option value="-1">Select State</option></select>';
		foreach ($uniqueStateList as $slist){
			echo '<option value="'.$slist.'">'.$slist.'</option>';
		}
	die();
	
}
add_action('wp_ajax_get_city','get_city_list');
add_action('wp_ajax_nopriv_get_city','get_city_list');
function get_city_list(){
	global $wpdb;
	$tablename = $wpdb->prefix."cclist_table";
	$state = $_POST['state'];
	$cityList = $wpdb->get_results("SELECT city FROM ".$tablename." WHERE state = '".$state."' ");
	echo '<option value="-1">Select City</option></select>';
	 foreach ($cityList as $city){
		echo '<option value="'.$city->city.'">'.$city->city.'</option>';
		}
	die();
	
}