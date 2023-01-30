<?php
/**
 * @package ZJS_Server_Load
 * @version 0.9
 */
/*
Plugin Name: ZJS Server Load
Plugin URI: http://zjstech.com/
Description: Displays Linux server load in admin dashboard 
Author: Rich Stern, ZJS Technology
Version: 0.9
Author URI: https://zjstech.com
*/


// admin dashboard options interface:
// require('zjs-server-load-admin-settings.php');


// function to color code the CPU load with background color class:
function load_color_indicator($load) {
	if($load <= 3)
		return "green";
	if($load <= 5)
		return "orange";
	return "red";
}

// function returns the HTML object for a CPU load measurement
function load_indicator($load_value,$additional_classes) {
	return '<span class="load ' . $additional_classes .' ' . load_color_indicator($load_value) .'">' . number_format($load_value,2) . '</span>'; 
	
}


// if the server is running a Linux variant and is on the dashboard, show the CPU load values in a paragraph in the admin notices section of WP dashboard
function zjs_server_load() {
	// only execute this function in the WP admin area of the web site.
	if(!is_admin())
		return;

	// get the CPU load:
	$server_load = sys_getloadavg();

	// timestamp our server load readings:
	$raw_date_time = current_datetime();

	// bail out if this is a Windows OS or server load didn't return properly:
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' || !is_array($server_load)) {
		echo '<p id="zjs-server-load">ZJS Server Load plugin compatiable with *nix servers only';
		return;
	}

	// format the time and date for display (WordPress indicated time zone)
	$display_time_and_date = $raw_date_time->format('g:i:sa') . ' on ' . $raw_date_time->format('Y-m-d');

	// output the results:
	echo '<p id="zjs-server-load">' . PHP_OS . ' server CPU load 1 / 5 / 15 minutes: ';
	echo load_indicator($server_load->one_minute_load,'one-minute') . ' / ';
	echo load_indicator($server_load[1],'five-minute') . ' / ';
	echo load_indicator($server_load[2],'fifteen-minute');
	echo '<span class="load-date-time"> at ' . $display_time_and_date . '</span>';
	echo '</p>';
}
// display the content in the admin notices area
add_action('admin_notices','zjs_server_load');


// supporting css 
function zjs_server_load_css() {
	echo "
	<style type='text/css'>
	#zjs-server-load {background-color: #ccc; border: 1px solid #888; padding: 5px; display: inline-block;}
	#zjs-server-load span.load {background-color: green; color: #fff; padding: 1px 3px;};
	#zjs-server-load span.load.orange {background-color: orange;};
	#zjs-server-load span.load.red{background-color: red;};
	</style>
	";
}
add_action('admin_head','zjs_server_load_css');
