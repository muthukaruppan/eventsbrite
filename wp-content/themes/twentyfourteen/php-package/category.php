<?php
function categoryfunction(){
    $url = home_url( '/', 'http' );
    $json = call_all_api(API_URL."categories".OAUTH_TOKEN_VARIABLE);
    echo '<div id="tabs-1"> <div class="event-container"> <div class="row">';
    foreach($json["categories"] as $key => $value) {
        echo '<div class="col-md-3"> <div class="event"> <div class="eventsimg"> <a href="'.$url.'subcategories/?cat_id='.$value["id"].'" value="'.$value["id"].'"> <img src="'.get_template_directory_uri().'/images/category_events.jpg"> </a> <div class="event-content"> <a href="'.$url.'subcategories/?cat_id='.$value["id"].'" class="btn btn-pri" value="'.$value["id"].'"> '.$value['name'].' </a> </div> </div> </div> </div>';
	}   
	echo '</div> </div> </div>';    
} 
add_shortcode('category', 'categoryfunction');
?>