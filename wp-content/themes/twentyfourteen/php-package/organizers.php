<?php
function call_organizersdetails() {
	$event_id = $_GET['event_id'];
    $json_event = call_all_api(API_URL.'events/'.$event_id.OAUTH_TOKEN_VARIABLE);
    $organizer_id = $json_event ['organizer_id'];
    $json = call_all_api(API_URL.'organizers/'.$organizer_id.OAUTH_TOKEN_VARIABLE);
   	echo '<section class="organizer_details"> <h3> Organizer Details </h3> <div class="row"> <div class="col-md-6 venue_events">';
   		if($json["description"]["text"]==null && $json["name"]==null && $json["twitter"]==null && $json["facebook"]==null) {
   			echo '<p> No description for organizer </p>';
   		}
   		if($json["description"]["text"]!=null) {
   			echo '<p> <span> Description : </span> '.$json["description"]["text"].' </p>'; 
   		}
   		echo '<ul> ';
   		if($json["name"]!=null) {
   			echo '<li> <span> Name : </span> '.$json["name"].' </li>';
   		}
   		if($json["twitter"]!=null) {
   			echo '<li> <span> Twitter : </span> '.$json["twitter"].' </li>';
   		}
   		if($json["facebook"]!=null) {
   			echo '<li> <span> Facebook : </span> '.$json["facebook"].' <li>';
   		}
   		echo '</ul> </div> <div class="col-md-6">';
    if($json['logo'] != null){
		echo '<img src="'.$json["logo"]["url"].'" alt="">';
    }
    else {
    	echo '<img src="'.get_template_directory_uri().'/images/category_events.jpg">';
    }
    echo '</div> </div> </section>';
}
add_shortcode('organizersdetails', 'call_organizersdetails');
?>