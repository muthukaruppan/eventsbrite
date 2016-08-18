<?php
function call_eventdetails() {
    $event_id = $_GET['event_id'];
    $json = call_all_api(API_URL.'events/'.$event_id.OAUTH_TOKEN_VARIABLE);
    $venue_id = $json ['venue_id'];
    $venue_details = call_all_api(API_URL.'venues/'.$venue_id.OAUTH_TOKEN_VARIABLE);
   	echo '<section class="event-detail newsection"> <h2 class="main-title "><a href="#"> '.$json["name"]["text"].' </a> </h2> 
   		<ul class="meta clearfix">';
   		if($json["start"]["local"]!=null) {
   			echo '<li class="date" title="Date"> <i class="icon fa fa-calendar"> </i> '.$json["start"]["local"].' </li>'; 
   		}
   		if($venue_details["address"]["region"]!=null) {
   			echo '<li title="Region"> <i class="icon fa fa-map-marker"> </i> '.$venue_details["address"]["region"].' </li>';
   		}
   		if($venue_details["address"]["country"]!=null) {
   			echo '<li title="Country"> <i class="fa fa-plane" aria-hidden="true"></i> '.$venue_details["address"]["country"].' </li>';
   		}
   		if($venue_details["address"]["city"]) {
   			echo '<li title="City"> <i class="icon fa fa-home"> </i> '.$venue_details["address"]["city"].'</li>';
   		}
   		if($venue_details["address"]["postal_code"]!=null) {   			
   			echo '<li title="Postalcode"> <i class="fa fa-code-fork" aria-hidden="true"></i> '.$venue_details["address"]["postal_code"].' </li>'; 
   		}
   		echo '</ul> 

   		<div class="event-detail-img" id="eventdetails_section"> ';
   	if($json['logo'] != null){
   		echo '<img src="'.$json["logo"]["url"].'"" alt="">';
   	}
   	else {
		echo '<img src="'.get_template_directory_uri().'/images/category_events.jpg">';
	}
    echo '</div> 
    		<h3 class="title">Whats About</h3> 
    		<div class="col-md-7 about_content">';
    		if($json["description"]["text"]!=null) {
    			echo '<p> '.$json["description"]["text"].' </p>';
    		}
    		else {
    			echo '<p> No description for this event </p>';
    		}

    		echo '</div> <div class="col-md-5"> <div id="googleMap"> </div> </div> <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD29eCm_1Q3IlgBZ60IoY-Cj3l8AMlmgoY&callback=initMap" async defer> </script> <script> var map; function initMap() { 
            	var lattitude = jQuery() 
        		map = new google.maps.Map(document.getElementById("googleMap"), {
          		center: {lat: '.$venue_details['address']['latitude'].', lng: '.$venue_details['address']['longitude'].'},
          zoom: 8
        });
      }
    </script> </section>';
}
add_shortcode('eventdetails', 'call_eventdetails');
?>