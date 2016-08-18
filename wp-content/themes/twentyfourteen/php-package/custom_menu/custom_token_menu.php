<?php 
wp_enqueue_style('init_menucss',get_stylesheet_directory_uri() . '/css/menu_style.css');
global $wpdb;
if(isset($_POST['api_form_submit'])) {
	
  	$api_url = $_POST['api_url'];
  	$api_token = $_POST['api_token'];

  	$sql3 = "DELETE FROM `api_settings` WHERE status='1'";
	$wpdb->query($sql3);

	$sql = "INSERT INTO `api_settings`	(`api_name`,`api_token`) 
   			values ('$api_url','$api_token')";
	$wpdb->query($sql);

  	echo "<script> alert('Inserted successfully'); </script>";
}



$sql1 = "SELECT * FROM api_settings WHERE status='1'";
$result = $wpdb->get_row($sql1) or die(mysql_error());
$api_name=$result->api_name;
$api_token=$result->api_token;


function add_api_settings(){
     add_menu_page('API Settings', 'API Settings', 'manage_options', 'api-settings', 'create_token_menu_page', get_template_directory_uri().'/images/token.png'); 
}
function create_token_menu_page(){
	global $api_name;
	global $api_token;

	echo '<div class="api_settings"> <h2> API Settings </h2>
	<div class="api_form"> 
		<form method="post"> 
			<label> API URL </label>
	<input type="text" name="api_url" value="'.$api_name.'" placeholder="Ex : https://www.eventbriteapi.com/v3/" required/> </br>

	<label> API TOKEN </label>
	<input type="text" name="api_token" value="'.$api_token.'" placeholder="Ex : GG3C63GYJPTIDWIVTSPG" required/> </br>
	<button type="submit" name="api_form_submit"> Save </button> </form> </div> </div>

	';
}

add_action('admin_menu','add_api_settings');

?>