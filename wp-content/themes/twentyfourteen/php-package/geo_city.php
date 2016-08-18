<?php
function call_geo_city_events($iteration) {
	if($iteration['list']!=null) {
		$iteration_limit=$iteration['list'];
	}
	else {
		$iteration_limit=50;
	}

    $url = home_url( '/', 'http' );
	$current_city_data = call_all_api("ip-api.com/json");
	$city_key = $current_city_data['city'];

	echo '<div id="tabs-1" class="geo_city_events"> ';
	if($city_key!=null) {
		echo '<h2 class="current_city"> '.$city_key.' </h2>';
		if($iteration['order']!=null && strtolower($iteration['order'])=='asc') {
			$json_city_url =call_all_api(API_URL."events/search".OAUTH_TOKEN_VARIABLE."&venue.city=".$city_key."&sort_by=date");
		}
		else {			
			$json_city_url =call_all_api(API_URL."events/search".OAUTH_TOKEN_VARIABLE."&venue.city=".$city_key."&sort_by=-date");
		}
	}
	else {
		echo '<h2 class="current_city"> Chennai </h2>';
		if($iteration['order']!=null && strtolower($iteration['order'])=='asc') {
			$json_city_url =call_all_api(API_URL."events/search".OAUTH_TOKEN_VARIABLE."&venue.city=Chennai"."&sort_by=date");
		}
		else {
			$json_city_url =call_all_api(API_URL."events/search".OAUTH_TOKEN_VARIABLE."&venue.city=Chennai"."&sort_by=-date");
		}
	}
	echo '<div class="event-container"> <div class="row">';
	$i=1;
	foreach($json_city_url["events"] as $key => $value) {
		if($i<=$iteration_limit) {
        echo '<div class="col-md-3"> <div class="event"> <div class="eventsimg"> <a href="'.$url.'eventdetails/?event_id='.$value["id"].'">';
	    if($value['logo_id']==null)
    		echo '<img src="'.get_template_directory_uri().'/images/category_events.jpg" />'; 
    	else
    		echo '<img src="'.$value["logo"]["url"].'" />';
		echo '</div> <div class="event-content"> <h3 class="title"><a href="eventdetails/?event_id='.$value['id'].'" class="events_anger"> '.$value['name']['text'].'</a> </h3> <ul class="meta" id="geo_event_date"> <li class="date"><i class="icon fa fa-calendar"></i> '.date('Y-m-d H:i:s',strtotime($value['start']['local'])).'</li> </ul> <p> '.substr ($value['description']['text'], 0, 100).' </p> </div> </div> </div>';
		}
		$i++;

	}   
	echo '</div> </div> </div>'; 
}


add_shortcode('geo_city_events','call_geo_city_events');
?>