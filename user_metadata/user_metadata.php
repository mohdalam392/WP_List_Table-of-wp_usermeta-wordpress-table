<?php
/*
Plugin Name: User Meta Data
Plugin URI: https://github.com/mohdalam392/WP_List_Table-of-wp_usermeta-wordpress-table
Description: User Meta Data List (Insert,Update,Delete)
Author: Mohd Alam
Version: 1.0
Author URI: http://www.facebook.com/alamdeveloper
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