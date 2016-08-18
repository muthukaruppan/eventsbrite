<?php
function call_date($sdate,$edate) {

	$d1=date("Y-m-d", $sdate);
	$d2=date("Y-m-d", $edate);
	$required_sdate = date("Y-m-d", strtotime($d1)).'T00:00:00';
	$required_edate = date("Y-m-d", strtotime($d2)).'T23:59:59';
	return "&sdate=".$required_sdate."&edate=".$required_edate;

}

function call_date_ajax() {
	if(isset($_POST['post_id1']) && !empty($_POST['post_id1'])) {
		$sdate=strtotime($_POST['post_id1']);
		$edate=strtotime($_POST['post_id2']);
		$d1=date("Y-m-d", $sdate);
		$d2=date("Y-m-d", $edate);
		$required_sdate = date("Y-m-d", strtotime($d1)).'T00:00:00';
		$required_edate = date("Y-m-d", strtotime($d2)).'T23:59:59';
		echo "&sdate=".$required_sdate."&edate=".$required_edate;
	    wp_die();
  	}	
}
add_action('init','call_date_ajax');
//  -----------------             Event page start       ----------------------

// Events [events]
function call_events() {
	wp_enqueue_style('init_default_css', get_stylesheet_directory_uri() . '/css/default.css');
	wp_enqueue_script('js12_script',  get_stylesheet_directory_uri() . '/js/jquery-1.12.0.js');
	wp_enqueue_script('date1_script',  get_stylesheet_directory_uri() . '/js/zebra_datepicker.js');
	wp_enqueue_script('date2_script',  get_stylesheet_directory_uri() . '/js/core.js');


    $category_json = call_all_api(API_URL."categories".OAUTH_TOKEN_VARIABLE);
    $formats_json = call_all_api(API_URL."formats".OAUTH_TOKEN_VARIABLE);
    // Event based on category and country
    if(!empty($_GET['cat_id']) && !empty($_GET['alpha2Code'])) { 
    	$change_status = 0;
    	$cat_status=1;
    	$cat_id = $_GET['cat_id'];
    	$start_date = $_GET['sdate'];
    	$end_date = $_GET['edate'];
    	$format_id=$_GET['format_id'];
    	$country_key = $_GET['alpha2Code'];
    	$json_current_url =API_URL."events/search".OAUTH_TOKEN_VARIABLE."&categories=".$cat_id."&venue.city=".$country_key.'&start_date.range_start='.$start_date.'&start_date.range_end='.$end_date.'&formats='.$format_id;
    	$json = call_all_api($json_current_url);
  	}
  	// Event based on category
  	else if(!empty($_GET['cat_id'])) { 
  		$change_status = 1;
  		$cat_status=0;
    	$cat_id = $_GET['cat_id'];
    	$start_date = $_GET['sdate'];
    	$end_date = $_GET['edate'];
    	$format_id=$_GET['format_id'];
    	$json_current_url =API_URL."events/search".OAUTH_TOKEN_VARIABLE."&categories=".$cat_id.'&start_date.range_start='.$start_date.'&start_date.range_end='.$end_date.'&formats='.$format_id;
    	$json = call_all_api($json_current_url);
  	}
  	// Event based on country
  	else if(!empty($_GET['alpha2Code'])) { 
  		$cat_status=1;
  		$change_status = 2;
    	$cat_id = $_GET['cat_id'];
    	$start_date = $_GET['sdate'];
    	$end_date = $_GET['edate'];
    	$country_key = $_GET['alpha2Code'];
    	$format_id=$_GET['format_id'];
    	$json_current_url =API_URL."events/search".OAUTH_TOKEN_VARIABLE."&venue.city=".$country_key.'&start_date.range_start='.$start_date.'&start_date.range_end='.$end_date.'&formats='.$format_id;
      	$json = call_all_api($json_current_url);
  	}
  	// Event based on sub_category
    else if(!empty($_GET['subcat_id'])){
    	$cat_status=0;
    	$change_status = 3;
   		$subcat_id = $_GET['subcat_id'];
		$start_date = $_GET['sdate'];
    	$end_date = $_GET['edate'];
    	$format_id=$_GET['format_id'];
		$json_current_url =API_URL."events/search".OAUTH_TOKEN_VARIABLE."&subcategories=".$subcat_id.'&start_date.range_start='.$start_date.'&start_date.range_end='.$end_date.'&formats='.$format_id;
		$json = call_all_api($json_current_url);
    }
    else {
    	$cat_status=0;
    	$start_date = $_GET['sdate'];
    	$end_date = $_GET['edate'];
    	$format_id=$_GET['format_id'];
    	$json_current_url =API_URL."events/search".OAUTH_TOKEN_VARIABLE.'&start_date.range_start='.$start_date.'&start_date.range_end='.$end_date.'&formats='.$format_id;
    	$json = call_all_api($json_current_url);
    }
    $today_sdate=strtotime("today");
    $tommorrow_sdate=strtotime("Tomorrow");
	$thisweek_sdate = strtotime("last sunday midnight",$today_sdate);
  	$thisweek_edate = strtotime("next saturday",$today_sdate);
  	$nw = strtotime("+1 week -1 day");
  	$nextweek_sdate = strtotime("last sunday midnight",$nw);
  	$nextweek_edate = strtotime("next saturday",$nw);
  	$nextmonth_sdate = strtotime("first day of next month");  
    $nextmonth_edate = strtotime("last day of next month");
    // echo $json_current_url;
    $current_query_string1 = $_SERVER["QUERY_STRING"];
    $current_query_string = $current_query_string1;
    echo '<div class="eventform-con clearfix sorting_option"> <form method="POST"> <span> Sorting  </span> <select name="soting_value" id="soting_value" class="sorting_holder"> <option value="all"> All </option> <option value="date"> Date </option> <option value="prize"> Price </option> </select>
            <select name="prize_soting_value" id="prize_soting_value" class="sorting_holder">
            <option value="free"> Free </option> <option value="paid"> Paid </option> </select>
            </form> </div>';
    echo '<div class="grid-list event-container clearfix sorting_section"> <div class="row sorting_inner_section"> <div class="col-md-3 sidebar_filter">  <div class="tainer"> <h1 class="title"><i aria-hidden="true" class="fa fa-filter" style=""></i> Find Events</h1> <ul class="dropdown_holder"> 
        <li data-panel="dropdown_section1" class="dropdown_link">Categories<i class="fa fa-caret-down" aria-hidden="true"></i> </li> <div class="dropdown_section dropdown_section1">';
    if($cat_status==1) {
	    foreach ($category_json['categories'] as $key => $value) {
			echo '<a href="events/?alpha2Code='.$country_key.'&cat_id='.$value["id"].'"> '.$value["name"].' </a>';
	    }
	}
	else {
		foreach ($category_json['categories'] as $key => $value) {
			echo '<a href="events/?cat_id='.$value["id"].'"> '.$value["name"].' </a>';
	    }
	}
	echo '</div> 
	 <li data-panel="dropdown_section3" class="dropdown_link">Formats<i class="fa fa-caret-down" aria-hidden="true"></i> </li> <div class="dropdown_section dropdown_section3">';
	    foreach ($formats_json['formats'] as $key => $value) {
			echo '<a href="events/?'.$current_query_string.'&format_id='.$value["id"].'"> '.$value["name"].' </a>';
	    }

	echo '</div> 
	<li data-panel="dropdown_section2" class="dropdown_link"> Date<i class="fa fa-caret-down" aria-hidden="true"></i> </li> <div class="dropdown_section dropdown_section2">';

	
	echo '<a href="events/?'.$current_query_string.''.call_date($today_sdate,$today_sdate).'"> Today </a> <a href="events/?'.$current_query_string.''.call_date($tommorrow_sdate,$tommorrow_sdate).'"> Tomorrow </a> <a href="events/?'.$current_query_string.''.call_date($thisweek_sdate,$thisweek_edate).'"> This Week </a> <a href="events/?'.$current_query_string.''.call_date($nextweek_sdate,$nextweek_edate).'"> Next Week </a> <a href="events/?'.$current_query_string.''.call_date($nextmonth_sdate,$nextmonth_edate).'"> Next Month </a> <a id="custom_date_event"> Custom Date </a> <div id="cutom_date_form_event"> <div class="start_date_event"> <label> Start Date </label>  <input type="text" placeholder="Start date" id="datepicker-example7-start" name="sdate" class="custom_date_class"> </div> <div class="end_date_event"> <label> End Date </label>  <input type="text" id="datepicker-example7-end" placeholder="End date" name="edate" class="custom_date_class"> </div> <span class="custom_anger_event">FIND EVENT</span> 

		<a id="hidden_custom1" href="events/?'.$current_query_string.'"> </a>
		</div> </div> </ul> </div> </div>';

		echo '<div class="col-md-9 ajax_call_section_event_listings"> <div class="col-md-12 ajax_section_event_listings"> <div class="pagination_section_event"> <div class="ajax_loading_section"> <img src="'.get_template_directory_uri().'/images/ajax_loader.gif"> </div>';
	    foreach ($json['events'] as $key => $value) {
        	echo '<div class="event-border col-md-4"> <div class="event clearfix"> <div class="eventsimg"> <a href="eventdetails/?event_id='.$value['id'].'" class=""> ';
        	if($value['logo'] != null){
               	echo '<img src="'.$value['logo']['url'].'" alt="">';
            }
            else {
              	echo '<img src="'.get_template_directory_uri().'/images/category_events.jpg">';
           	}
 			echo '</a> </div> <div class="event-content"> <h3 class="title"><a href="eventdetails/?event_id='.$value['id'].'" class="events_anger"> '.$value['name']['text'].'</a> </h3> <ul class="meta"> <li class="date"><i class="icon fa fa-calendar"></i> '.date('Y-m-d H:i:s',strtotime($value['start']['local'])).'</li> </ul> <p> '.substr ($value['description']['text'], 0, 100).' </p> </div> </div> </div>';
        }
       	echo '<input type="hidden" value="'.$json_current_url.'" name="json_current_url" id="json_current_url"/> </div> </div>';
       		$total_count = $json['pagination']['page_count'];
       	if($total_count > 1) {
       	echo '<div class="pageination_number"> <div class="total_event_pages"> <span> Total Number of Pages : '.$total_count.' </span> </div>';
	    	echo '<div class="pagination-holder">';
	    	echo '<ul class="col-md-offset-3">';
	    	$i = 1;
			while($i <= $total_count) {
				echo '<li value="'.$i.'" class="page_numbers"> '.$i .' </li>';
			    $i++;
			}
	      	echo '<div class="clear_both"> </div> </ul> </div> </div> </div>';
  		}



       		echo '</div> </div> <script>
       	        jQuery(document).on("change",".sorting_holder",function() { 
		        	var selected_value = jQuery(this).val(); 
		        	var json_current_url = jQuery("#json_current_url").val(); 
					var ajaxurl = "'.admin_url('admin-ajax.php').'";';
					if($change_status == 0) {
						echo 'jQuery.ajax({
				          	type: "POST",
				           	url: ajaxurl,
				           	data: { action: "sorting_action", post_id_sort: selected_value, json_current_url_sort : json_current_url},
				           	success: function(data){
				               	jQuery(".ajax_section_event_listings").remove();
				               	jQuery(".pageination_number").remove();
				               	jQuery(".ajax_call_section_event_listings").html(data);                    	
			           		},
			           	});';
			        }
			        else if($change_status ==1) {
			        	echo 'jQuery.ajax({
				          	type: "POST",
				           	url: ajaxurl,
				           	data: { action: "sorting_action", post_id_sort: selected_value, json_current_url_sort : json_current_url },
				           	success: function(data){
				               	jQuery(".ajax_section_event_listings").remove();
				               	jQuery(".pageination_number").remove();
				               	jQuery(".ajax_call_section_event_listings").html(data);                    	
			           		},
			           	});';
			        }
			      	else if($change_status ==2) {
			        	echo 'jQuery.ajax({
				          	type: "POST",
				           	url: ajaxurl,
				           	data: { action: "sorting_action", post_id_sort: selected_value, json_current_url_sort : json_current_url },
				           	success: function(data){
				              	jQuery(".ajax_section_event_listings").remove();
				               	jQuery(".pageination_number").remove();
				               	jQuery(".ajax_call_section_event_listings").html(data);                   	
			           		},
			           	});';
			        }
			        else if($change_status ==3) {
			        	echo 'jQuery.ajax({
				          	type: "POST",
				           	url: ajaxurl,
				           	data: { action: "sorting_action", post_id_sort: selected_value, json_current_url_sort : json_current_url },
				           	success: function(data){
				               	jQuery(".ajax_section_event_listings").remove();
				               	jQuery(".pageination_number").remove();
				               	jQuery(".ajax_call_section_event_listings").html(data);                   	
			           		},
			           	});';
			        }

			        else {
			        	echo 'jQuery.ajax({
				          	type: "POST",
				           	url: ajaxurl,
				           	data: { action: "sorting_action", post_id_sort: selected_value, json_current_url_sort : json_current_url },
				           	success: function(data){
				               	jQuery(".ajax_section_event_listings").remove();
				               	jQuery(".pageination_number").remove();
				               	jQuery(".ajax_call_section_event_listings").html(data);                  	
			           		},
			           	});';
			        }		        
		       	echo '}); </script>';


		 echo '<script> 
		 		jQuery(document).on("click",".custom_anger_event",function() {
					var input1_value = jQuery("#datepicker-example7-start").val();
					var input2_value =  jQuery("#datepicker-example7-end").val();
					var ajaxurl = "'.admin_url('admin-ajax.php').'";
					var custom_href = jQuery("#hidden_custom1").attr("href");
					if(input1_value!="" && input2_value!="") {
						jQuery.ajax({
				          	type: "POST",
				           	url: ajaxurl,
				           	data: { action: "call_date_ajax", post_id1: input1_value, post_id2: input2_value },
				           	success: function(data){
				               	jQuery("#hidden_custom1").attr("href",custom_href+data);
			          		},
			           	}).done(function() { 
			           		jQuery("a#hidden_custom1")[0].click();
						});
					}
				}); </script> ';

       	


  		echo '<script>
        		jQuery(document).on("click",".page_numbers",function() { 
        			var clicked_value = jQuery(this).val();
        			jQuery(".page_numbers").fadeOut();
        			jQuery(this).fadeIn();
        			var json_current_url = jQuery("#json_current_url").val();
        			jQuery(".page_numbers").removeClass("show_pages");
        			jQuery(this).prevAll().slice(0,4).fadeIn();
    				jQuery(this).nextAll().slice(0,4).fadeIn();
        			jQuery(this).addClass("show_pages");
        			var ajaxurl = "'.admin_url('admin-ajax.php').'";
					jQuery.ajax({
		                	type: "POST",
		                	url: ajaxurl,
		                	data: { action: "call_all_events", page_value: clicked_value, json_current_url : json_current_url },
		                	success: function(data){
		            			jQuery(".pagination_section_event").remove();
				               	jQuery(".ajax_section_event_listings").html(data);                   	
	             			}
               		});
                });
                
       	</script>';
  
}
add_shortcode('events', 'call_events');

// Search whole event based on page number
function call_all_events() {
	if(isset($_POST['page_value']) && !empty($_POST['page_value'])) {
		$page_value = $_POST['page_value'];
		$json_current_url = $_POST['json_current_url'];
		$json_current_api=$json_current_url.'&page='.$page_value;
	    $json = call_all_api($json_current_api);

      	echo '<div class="pagination_section_event"> <div class="ajax_loading_section"> <img src="'.get_template_directory_uri().'/images/ajax_loader.gif"> </div>';
	    foreach ($json['events'] as $key => $value) {
           	echo '<div class="event-border col-md-4"> <div class="event clearfix"> <div class="eventsimg"> <a href="eventdetails/?event_id='.$value['id'].'" class="">';
          	if($value['logo'] != null){
               	echo '<img src="'.$value['logo']['url'].'" alt="">';
            }
            else {
              	echo '<img src="'.get_template_directory_uri().'/images/category_events.jpg">';
            }
 			echo '</a> </div> <div class="event-content"> <h3 class="title"><a href="eventdetails/?event_id='.$value['id'].'" class="events_anger"> '.$value['name']['text'].'</a> </h3> <ul class="meta"> <li class="date"><i class="icon fa fa-calendar"></i> '.date('Y-m-d H:i:s',strtotime($value['start']['local'])).'</li> </ul> <p> '.substr ($value['description']['text'], 0, 100).' </p> </div> </div> </div>';
        }
        echo '<input type="hidden" value="'.$json_current_url.'" name="json_current_url" id="json_current_url" /> </div>';
	    wp_die();
  	}	
}
add_action('init','call_all_events');



// Sorting option based on date price
function sorting_action() {
	if(isset($_POST['post_id_sort']) && !empty($_POST['post_id_sort'])) {
		$selected_value = $_POST['post_id_sort'];
		$json_current_url_sort = $_POST['json_current_url_sort'];
		if($selected_value == 'date') {
			$json_current_api_sort=$json_current_url_sort.'&sort_by=date';
			$json=call_all_api($json_current_api_sort);
		}
		else if($selected_value == 'paid') {
			$json_current_api_sort=$json_current_url_sort.'&price=paid';
			$json=call_all_api($json_current_api_sort);
		}
		else if($selected_value == 'all') {
			$json_current_api_sort=$json_current_url_sort;
			$json=call_all_api($json_current_api_sort);
		}
		else {
			$json_current_api_sort=$json_current_url_sort.'&price=free';
			$json=call_all_api($json_current_api_sort);
		}
		echo '<div class="col-md-12 ajax_section_event_listings"> <div class="pagination_section_event"> <div class="ajax_loading_section"> <img src="'.get_template_directory_uri().'/images/ajax_loader.gif"> </div>';
        foreach ($json['events'] as $key => $value) {
        	echo '<div class="event-border col-md-4"> <div class="event clearfix"> <div class="eventsimg"> <a href="eventdetails/?event_id='.$value['id'].'" class="">';
         	if($value['logo'] != null) {
            	echo '<img src="'.$value['logo']['url'].'" alt="">';
            }
            else {
            	echo '<img src="'.get_template_directory_uri().'/images/category_events.jpg">';
            }
				echo '</a> </div> <div class="event-content"> <h3 class="title"><a href="eventdetails/?event_id='.$value['id'].'" class="events_anger"> '.$value['name']['text'].'</a> </h3> <ul class="meta"> <li class="date"><i class="icon fa fa-calendar"></i> '.date('Y-m-d H:i:s',strtotime($value['start']['local'])).'</li> </ul> <p> '.substr ($value['description']['text'], 0, 100).' </p> </div> </div> </div>';
        }
        echo '<input type="hidden" value="'.$json_current_url_sort.'" name="json_current_url" id="json_current_url"/> </div> </div>';
        $total_count = $json['pagination']['page_count'];
        if($total_count > 1) {
       	echo '<div class="pageination_number"> <div class="total_event_pages"> <span> Total Number of Pages : '.$total_count.' </span> </div>';
	    	echo '<div class="pagination-holder">';
	    	echo '<ul class="col-md-offset-3">';
	    	$i = 1;
			while($i <= $total_count) {
				echo '<li value="'.$i.'" class="page_numbers"> '.$i .' </li>';
			    $i++;
			}
	      	echo '<div class="clear_both"> </div> </ul> </div> </div> ';
  		}
  		echo '<script> jQuery(".page_numbers:first-child").fadeIn();
			jQuery(".page_numbers:first-child").addClass("show_pages");
			jQuery(".page_numbers").nextAll().slice(0,9).fadeIn(); </script>';
		wp_die();
	}
}
add_action('init','sorting_action');
?>