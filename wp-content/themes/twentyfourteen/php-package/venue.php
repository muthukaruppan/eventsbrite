<?php
function call_venuedetails() {
	$event_id = $_GET['event_id'];
    $json_event = call_all_api(API_URL.'events/'.$event_id.OAUTH_TOKEN_VARIABLE);
    $venue_id = $json_event ['venue_id'];
    $json = call_all_api(API_URL.'venues/'.$venue_id.OAUTH_TOKEN_VARIABLE);
	echo '<section class="venue_details"> <h3> Venue Details </h3> <div class="row"> <div class="col-md-12 venue_events"> <span class="venue_block"> Address 1 : '.$json["address"]["address_1"].' </span>';
	if($json["address"]["address_2"]!=null) {
		echo '<span class="venue_block"> Address 2 : '.$json["address"]["address_2"].' </span>';
	}
	echo '<span class="venue_block"> City : '.$json["address"]["city"].' </span> <span class="venue_block"> Region : '.$json["address"]["region"].' </span> <span class="venue_block"> Postal_code : '.$json["address"]["postal_code"].' </span> <span class="venue_block"> Country : '.$json["address"]["country"].' </span> <span class="venue_block"> Latitude : '.$json["address"]["latitude"].' </span> <span class="venue_block"> Longitude : '.$json["address"]["longitude"].' </span> </div> </div> </div>';
   	}
add_shortcode('venuedetails', 'call_venuedetails');
?>