<?php
/**
 * Created by PhpStorm.
 * User: EC
 * Date: 26.03.14
 * Time: 9:54
 * Email: bpteam22@gmail.com
 */

require(dirname(__FILE__).'/../../../wp-load.php');
global $wpdb;
$blogs = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'livejournal_parser', ARRAY_A);
foreach($blogs as $blog){
	parsing_livejournal($blog['livejournal_url'], true);
}

if(isset($_SERVER['argv'][1])){
	$email = $_SERVER['argv'][1];
} elseif(isset($_GET['email'])){
	$email = $_GET['email'];
}
if(isset($email)){
	mail($email,'Parser update your site', 'Parser is done. Please check site for new updates.');
}