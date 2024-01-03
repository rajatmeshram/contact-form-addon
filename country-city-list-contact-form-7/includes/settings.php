<?php 
/**
 * plugin settings page
 */
include_once('enqueue.php');
add_action('admin_menu', 'ccl_setting_menu');
function ccl_setting_menu(){
add_submenu_page( 'wpcf7', __('Country and City List settings', 'ccl-cpf'), 
__('City List Settings', 'ccl-cpf'), 'manage_options', 'ccl-settings', 'ccl_setting_tabs' );
add_action( 'admin_init', 'ccl_register_custom_settings' );

}
function ccl_register_custom_settings() {
	/***register our settings****/
	register_setting( 'ccl-custom-settings-group', 'defcountry' );
  }
function ccl_setting_tabs(){
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	
	global $wpdb;

// Table name
$tablename = $wpdb->prefix."cclist_table";

// Import CSV
if(isset($_POST['Import'])){

  // File extension
  $extension = pathinfo($_FILES['ccfile']['name'], PATHINFO_EXTENSION);

  // If file extension is 'csv'
  if(!empty($_FILES['ccfile']['name']) && $extension == 'csv'){

    $totalInserted = 0;

    // Open file in read mode
    $csvFile = fopen($_FILES['ccfile']['tmp_name'], 'r');

    fgetcsv($csvFile); // Skipping header row
    $cntSQL = "SELECT count(*) as count FROM {$tablename} ";
    $record = $wpdb->get_results($cntSQL, OBJECT);
    if($record){
      $wpdb->query('TRUNCATE TABLE '.$tablename.'');
    }
    // Read file
    while(($csvData = fgetcsv($csvFile)) !== FALSE){
      $csvData = array_map("utf8_encode", $csvData);

      // Row column length
      $dataLen = count($csvData);

      // Skip row if length != 4
      //if( !($dataLen == 3) ) continue;

      // Assign value to variables
      $country = trim($csvData[0]);
      $state = trim($csvData[1]);
      $city = trim($csvData[2]);

      // Check record already exists or not
      
        // Check if variable is empty or not
        if(!empty($city) && !empty($country) && !empty($state) ) {

          // Insert Record
          $wpdb->insert($tablename, array(
            'country' =>$country,
            'state' =>$state,
            'city' =>$city
          ));

          if($wpdb->insert_id > 0){
            $totalInserted++;
          }
        }
    }
    echo "<h3 style='color: green;'>Total record Inserted : ".$totalInserted."</h3>";
  }else{
    echo "<h3 style='color: red;'>Invalid Extension</h3>";
  }

}
?>
	 <div class="wrap full-width-layout ccl_settings_page">
		    <h2><?php _e('Country and City  settings', 'ccl'); ?></h2>
				<form method="post" action="options.php">
					<?php settings_fields( 'ccl-custom-settings-group' ); ?>
					<?php do_settings_sections( 'ccl-custom-settings-group' ); ?>
					<table>
				   <tr>
					<th scope="row">Default Country</th>
							<td><input type="text" name="defcountry" value="<?php echo esc_attr( get_option('defcountry') ); ?>" /></td>
					</tr>
					</table>
					<?php submit_button(); ?>
                 </form>
     </div>
	 <div id="wrap">
        <div class="container">
            <div class="row">
                <form class="form-horizontal" action='<?= $_SERVER['REQUEST_URI']; ?>' method="post" name="upload_excel" enctype="multipart/form-data">
                    <fieldset>
					<legend>Import CSV File Here</legend>
					<table border="1">
						<tr> 
						  <td>
							<div class="form-group">
								
								<div class="col-md-4">
									<input type="file" name="ccfile" id="ccfile" class="input-large">
								</div>
							</div>
						</td>
          <td>
          <!-- Button -->
          <div class="form-group">
              <div class="col-md-4">
                  <button type="submit" id="submit" name="Import" class="button button-primary" data-loading-text="Loading...">Import</button>
              </div>
          </div>
						</td>
						</tr>
					</table>
                    </fieldset>
                </form>

            </div>
        </div>
    </div>

<?php

}