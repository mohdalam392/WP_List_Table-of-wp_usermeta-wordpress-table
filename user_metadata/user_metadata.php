<?php
/*
Plugin Name: User Meta Data
Plugin URI: 
Description: User Meta Data List (Insert,Update,Delete)
Author: Mohd Alam
Version: 1.7.2
Author URI: 
*/

?>
<?php 
add_action('init',function(){

	/** Post Meta Deta **/
	require_once('includes/users/class-usersmetadata-menu.php');
	require_once('includes/users/class-usersmeta-list-table.php');
	require_once('includes/users/class-usersmeta-form-handler.php');	
	require_once('includes/users/usermeta-functions.php');
	new UsersMetaData_Menu();
	/** Post Meta Deta **/
});