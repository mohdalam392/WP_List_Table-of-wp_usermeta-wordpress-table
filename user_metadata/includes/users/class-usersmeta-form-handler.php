<?php

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class Users_Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'handle_form' ) );
    }

    /**
     * Handle the UserMeta new and edit form
     *
     * @return void
     */
    public function handle_form() {
        if ( ! isset( $_POST['User_SubmitData'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], '' ) ) {
            die( __( 'Are you cheating?', '' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( __( 'Permission Denied!', '' ) );
        }

        $errors   = array();
        $page_url = admin_url( 'admin.php?page=usersmetadata' );
        $field_id = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

        $umeta_id = isset( $_POST['umeta_id'] ) ? sanitize_text_field( $_POST['umeta_id'] ) : '';
        $user_id = isset( $_POST['user_id'] ) ? sanitize_text_field( $_POST['user_id'] ) : '';
        $meta_key = isset( $_POST['meta_key'] ) ? sanitize_text_field( $_POST['meta_key'] ) : '';
        $meta_value = isset( $_POST['meta_value'] ) ? sanitize_text_field( $_POST['meta_value'] ) : '';

        // some basic validation
        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $fields = array(
            'umeta_id' => $umeta_id,
            'user_id' => $user_id,
            'meta_key' => $meta_key,
            'meta_value' => $meta_value,
        );

        // New or edit?
        if ( ! $field_id ) {

            $insert_id = um_insert_UserMeta( $fields );

        } else {

            $fields['umeta_id'] = $field_id;

            $insert_id = um_insert_UserMeta( $fields );
        }

        if ( is_wp_error( $insert_id ) ) {
            $redirect_to = add_query_arg( array( 'message' => 'error' ), $page_url );
        } else {
            $redirect_to = add_query_arg( array( 'message' => 'success' ), $page_url );
        }

        wp_safe_redirect( $redirect_to );
        exit;
    }
}

new Users_Form_Handler();