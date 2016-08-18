<?php
function call_subcategory() {
    $cat_id = $_GET['cat_id'];
    $json = call_all_api(API_URL."categories/".$cat_id.OAUTH_TOKEN_VARIABLE);
        echo '<script type="text/javascript"> jQuery(".entry-title").append("<span>('.$json["name"].')</span>") </script>';
        echo '<div id="tabs-1"> <div class="event-container"> <div class="row">';
        foreach($json["subcategories"] as $key => $value) {
            echo '<div class="col-md-3"> <div class="event"> <div class="eventsimg"> <a href="events/?subcat_id='.$value["id"].'"> <img src="'.get_template_directory_uri().'/images/category_events.jpg"> </a> <div class="event-content"> <a href="events/?subcat_id='.$value["id"].'" class="btn btn-pri"> '.$value['name'].' </a> </div> </div> </div> </div>';
	    }
        echo '</div> </div> </div>';
}
add_shortcode('subcategory', 'call_subcategory');
?>