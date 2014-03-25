<?php
/*
Plugin Name: Livejournal_parser
Plugin URI: http://bpteam.net
Description: Парсит блог на Livejournal и обновляет статьи с комментариями
Version: 1.0
Author: Evgeny Pynykh
Author URI: http://bpteam.net
*/

register_activation_hook(__FILE__,'lj_parser_install');

define('TABLE_LJ_PARSER', 'livejournal_parser');
require_once(dirname(__FILE__) . '/include.php');
global $lj_parser_db_version;
$lj_parser_db_version = "1.0";

function lj_parser_install () {
	global $wpdb;

	$sql = "CREATE TABLE " . $wpdb->prefix . TABLE_LJ_PARSER . " (
	  id INTEGER NOT NULL AUTO_INCREMENT,
	  livejournal_url VARCHAR(250) NOT NULL,
	  PRIMARY KEY id (id),
	  UNIQUE KEY livejournal_url (livejournal_url)
	);";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	$wpdb->query($sql);
}

function livejournal_add_admin_menu(){
	add_options_page('Парсинг LiveJournal','Парсинг LiveJournal','level_8','livejournal_parser','admin_parser_livejournal_page');
}

function livejournal_add_admin_pages(){

	admin_parser_livejournal_page();
}

function admin_parser_livejournal_page(){
	global $wpdb;
	if(isset($_REQUEST['send_form_livejournal'])){
		add_new_livejournal_blog();
	}

	echo '<h2>Сайты для парсинга</h2>';
	if($_REQUEST['parsing'] == 'start'){
		set_time_limit(0);
		echo '<h1>Выполняется парсинг, пожалуйста подождите...</h1>';
		ob_flush();
		flush();
		ob_flush();
		$blogs = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . TABLE_LJ_PARSER . ' WHERE id='.$_REQUEST['id'], ARRAY_A);
		foreach($blogs as $blog){
			parsing_livejournal($blog['livejournal_url']);
		}

	}
	if($_REQUEST['parsing'] == 'del'){
		$wpdb->query('DELETE FROM ' . $wpdb->prefix . TABLE_LJ_PARSER . ' WHERE id='.$_REQUEST['id']);
	}

	echo '<h3>Добавить сайт для парсинга:</h3>';
	echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'?page=livejournal_parser&update=true">';
	echo '<table>
	             <tr>
	             <td style="text-align: right">URL блога</td>
	             <td><input type="text" name="livejournal_url"></td>
	             <td><input type="submit" name="send_form_livejournal" value="Добавить"></td>
	             <td style="color: #666666">Пример: <i>http://jeytim.livejournal.com/</i></td>
	             </tr>
	      </table>';
	echo '</form>';

	show_all_livejournal_blog();
}

function add_new_livejournal_blog(){
	global $wpdb;
	$livejournal_url = $_POST['livejournal_url'];
	$wpdb->insert(
		$wpdb->prefix . TABLE_LJ_PARSER,
		array('livejournal_url'=>$livejournal_url),
		array('%s')
	);

}

function show_all_livejournal_blog(){
	global $wpdb;
	$blogs = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . TABLE_LJ_PARSER, ARRAY_A);
	foreach($blogs as $blog){
		echo '<table>
		<tr>
		<td>'.$blog['livejournal_url'].'</td>
		<td> <a href="'.$_SERVER['PHP_SELF'].'?page=livejournal_parser&parsing=start&id='.$blog['id'].'&update=true">Запустить</a> </td>
		<td> <a href="'.$_SERVER['PHP_SELF'].'?page=livejournal_parser&parsing=del&id='.$blog['id'].'&update=true">Удалить</a> </td>
		</tr>
		</table>';
	}
}

function parsing_livejournal($url){
	$lj = new \Parser\cLiveJournal();
	$ljPoster = new \Poster\cWordPressLocal();
	$lj->init($url);
	do{
		$pageLinks = current($lj->curl->load($url));
		$links = $lj->getLinks($pageLinks);
		if($links){
			foreach($links as $link){
				$page = current($lj->curl->load($link));
				$lj->parsArticle($page);
				$ljPoster->addUser($lj->getJournal(),$lj->getJournal().'123456','Author', $lj->getAuthorId());
				$post = $lj->getPost();
				$ljPoster->downloadPictures($post);
				$ljPoster->addPost($lj->getTitle(), $post, $lj->getAuthorId(), null, $lj->getPostId());
				$ljPoster->addTagsToPost($lj->getPostId(), $lj->getTag());
				$ljPoster->addCommentsToPost($lj->getPostId(), $lj->getComments());
			}
		}
		$url = $lj->nextPage($pageLinks);
	}while($url);
}

add_action('admin_page', 'livejournal_add_admin_pages');
add_action('admin_menu', 'livejournal_add_admin_menu');

