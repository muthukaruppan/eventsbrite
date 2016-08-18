<?php
function call_event_search() {

    wp_enqueue_style('init_js_ui_css', get_stylesheet_directory_uri() . '/css/jquery-ui.css');
    wp_enqueue_script('init_js_ui', get_stylesheet_directory_uri() . '/js/jquery-ui.min.js');
    wp_enqueue_script('init_js_auto', get_stylesheet_directory_uri() . '/js/jquery.select-to-autocomplete.js'); 
    $url = home_url( '/', 'http' );
    $category_data = call_all_api(API_URL."categories".OAUTH_TOKEN_VARIABLE);
	$str = file_get_contents(get_template_directory_uri().'/images/cities.json');
	$json_cities = json_decode($str, true);
	echo '<form  action="'.$url.'events/" method="GET" id="home_search"> <div class="find"> <select name="cat_id" class="search_select" placeholder="Category Name"> <option></option>';
    foreach ($category_data['categories'] as $key => $value) {
    	echo '<option value="'.$value["id"].'"> '.$value["name"].' </option>';
    }
    echo '</select> <select class="search_select" name="alpha2Code" placeholder="City Name"> <option></option> ';
	foreach ($json_cities as $key => $value) {
      	echo '<option value="'.$value['city'].'"> '.$value['city'].' </option>';
    }
	echo '</select> <button class="btn btn-pri" type="submit">Fınd event</button> </div> </form> <script> (function(jQuery){ jQuery(function(){ jQuery(".search_select").selectToAutocomplete(); });
		})(jQuery); </script>';
}
add_shortcode('event_search','call_event_search');
?>