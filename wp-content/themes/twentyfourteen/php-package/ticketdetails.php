<?php
function call_ticket_details() {
	$ticket_id = $_GET['ticket_id'];
	$event_id = $_GET['event_id'];
	$json = call_all_api(API_URL.'events/'.$event_id.'/ticket_classes/'.$ticket_id.OAUTH_TOKEN_VARIABLE);
   	echo '<div class="ticket_description"> <p class="venue_block"> <span> Ticket Id : </span> '.$json['id'].' </p>';
   	if($json['free']==null) {
   		echo '<p class="venue_block"> <span> Cost Display : </span> '.$json["cost"]["display"].' </p> <p class="venue_block"> <span> Cost Currency : </span> '.$json["cost"]["currency"].' </p> <p class="Venue Block"> <span> Cost Value : </span> '.$json["cost"]["value"].' </p> <p class="venue_block"> <span> Cost Majorvalue : </span> '.$json["cost"]["major_value"].' </p> <p class="venue_block"> <span> Fee Display : '.$json["fee"]["display"].' </span> </p> <p class="venue_block"> <span> Fee Currency : </span> '.$json["fee"]["currency"].' </p> <p class="venue_block"> <span> Fee Value : </span> '.$json["fee"]["value"].' </p> <p class="venue_block"> <span> Fee_major_value : '.$json["fee"]["major_value"].' </span> </p> <p class="venue_block"> <span> Tax Display : '.$json["tax"]["display"].' </span> </p> <p class="venue_block"> <span>Tax Currency : '.$json["tax"]["currency"].' </span> </p> <p class="venue_block"> <span>Tax Value : '.$json["tax"]["value"].' </span> </p> <p class="venue_block"> <span>Tax Majorvalue : '.$json["tax"]["major_value"].' </span> </p>';
   	}
   	echo '<p class="venue_block"> <span> Name : '.$json["name"].' </span> </p> 
   		<p class="venue_block"> <span> Minimum Quantity : '.$json["minimum_quantity"].' </span> </p>';
    if($json['maximum_quantity']!=null) {
        echo '<p class="venue_block"> <span> Maximum Quantity : '.$json["maximum_quantity"].' </span> </p>';
    }
    echo '<p class="venue_block"> <span> Maximum Quantityperorder : '.$json["maximum_quantity_per_order"].' </span> </p> <p class="venue_block"> <span> On Salestatus : '.$json["on_sale_status"].' </span> </p> </div>';
}
add_shortcode('ticket_details', 'call_ticket_details');
?>