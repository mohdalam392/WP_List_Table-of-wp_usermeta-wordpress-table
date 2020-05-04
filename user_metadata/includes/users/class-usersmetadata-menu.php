<?php

/**
 * Admin Menu
 */
class UsersMetaData_Menu {

    /**
     * Kick-in the class
     */
    public function __construct() {
        global $current_user;

        // check captability
        if($current_user->roles[0]=='administrator'){
            add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        }
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu() {

         add_menu_page( __( 'Users Meta Data', '' ), __( 'Users Meta Data', '' ), 'manage_options', 'usersmetadata', array( $this, 'plugin_page' ), 'dashicons-groups', null );
    }

    /**
     * Handles the plugin page
     *
     * @return void
     */
    public function plugin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $umeta_id     = isset( $_GET['umeta_id'] ) ? intval( $_GET['umeta_id'] ) : 0;

        switch ($action) {
            case 'view':

                $template = dirname( __FILE__ ) . '/views/usersmeta-single.php';
                break;

            case 'edit':
                $template = dirname( __FILE__ ) . '/views/usersmeta-edit.php';
                break;

            case 'new':
                $template = dirname( __FILE__ ) . '/views/usersmeta-new.php';
                break;

            case 'delete':
                $template = dirname( __FILE__ ) . '/views/usersmeta-delete.php';
                break;

            default:
                $template = dirname( __FILE__ ) . '/views/usersmeta-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }
}