<?php
function call_events_ticket() {
	$event_id = $_GET['event_id'];
    $json = call_all_api(API_URL.'events/'.$event_id.'/ticket_classes'.OAUTH_TOKEN_VARIABLE);
    echo '<section class="ticket_details"> <h3> Events Tickets Details </h3> <div class="row">';
	foreach ($json['ticket_classes'] as $key => $value) {
	  	echo '<div class="col-md-4 ticket_class"> <div class="ticket_content_holder"> <span class="venue_block"> Ticket Id : '.$value["id"].' </span> <span class="venue_block"> Cost : ';
	  	if($value['free']!=null) {
	  		echo 'Free';
	  	}
	  	else {
	  		echo 'Paid';
	  	}
		echo '</span> <a href="ticketdetails/?ticket_id='.$value["id"].'&event_id='.$value["event_id"].'" class="ticket_id"> Go </a> </div> </div>';
    }
    echo '</div> </section>';
}
add_shortcode('event_tickets', 'call_events_ticket');
?>