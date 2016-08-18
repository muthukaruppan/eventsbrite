<?php
function call_all_api($api_url) {
	$curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $api_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "accept-language: application/json",
            "cache-control: no-cache",
        ),
    ));
    wp_enqueue_style('init_css',get_stylesheet_directory_uri() . '/css/style.css');
    wp_enqueue_style('fontawesome_css',get_stylesheet_directory_uri() . '/css/font-awesome.css');
    wp_enqueue_script('custom_script',  get_stylesheet_directory_uri() . '/js/custom.js');
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        return "cURL Error #:" . $err;
    } 
    else {
        $json = json_decode($response, true);
        return $json;
    }       
}
?>