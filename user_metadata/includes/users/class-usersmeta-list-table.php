<?php

if ( ! class_exists ( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class UsersMetaData_List_Table extends \WP_List_Table {

    function __construct() {
        parent::__construct( array(
            'singular' => 'UserMeta',
            'plural'   => 'Users Metas',
            'ajax'     => false
        ) );
    }

    function get_table_classes() {
        return array( 'widefat', 'fixed', 'striped', $this->_args['plural'] );
    }

    /**
     * Message to show if no designation found
     *
     * @return void
     */
    function no_items() {
        _e( 'No Users Meta Found', '' );
    }

    /**
     * Default column values if no callback found
     *
     * @param  object  $item
     * @param  string  $column_name
     *
     * @return string
     */
    function column_default( $item, $column_name ) {

        switch ( $column_name ) {
            case 'umeta_id':
                return $item->umeta_id;

            case 'user_id':
                return $item->user_id;

            case 'meta_key':
                return $item->meta_key;

            case 'meta_value':
                return $item->meta_value;

            default:
                return isset( $item->$column_name ) ? $item->$column_name : '';
        }
    }

    /**
     * Get the column names
     *
     * @return array
     */
    function get_columns() {
        $columns = array(
            'cb'           => '<input type="checkbox" />',
            'umeta_id'      => __( 'User Meta Key', '' ),
            'user_id'      => __( 'User Id', '' ),
            'meta_key'      => __( 'Meta Key', '' ),
            'meta_value'      => __( 'Meta Value', '' ),

        );

        return $columns;
    }

    /**
     * Render the designation name column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_umeta_id( $item ) {

        $actions           = array();
        $actions['edit']   = sprintf( '<a href="%s" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=usersmetadata&action=edit&umeta_id=' . $item->umeta_id ), $item->umeta_id, __( 'Edit this item', '' ), __( 'Edit', '' ) );
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=usersmetadata&action=delete&umeta_id=' . $item->umeta_id ), $item->umeta_id, __( 'Delete this item', '' ), __( 'Delete', '' ) );

        return sprintf( '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url( 'admin.php?page=usersmetadata&action=view&umeta_id=' . $item->umeta_id ), $item->umeta_id, $this->row_actions( $actions ) );
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'umeta_id' => array( 'UMeta Id', true ),
            'user_id' => array( 'User Id', true ),
            'meta_key' => array( 'Meta Key', true ),
            'meta_value' => array( 'Meta Value', true ),
        );

        return $sortable_columns;
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    function get_bulk_actions() {
        $actions = array(
            //'trash'  => __( 'Move to Trash', '' ),
        );
        return $actions;
    }

    /**
     * Render the checkbox column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="UserMeta_id[]" value="%d" />', $item->umeta_id
        );
    }

    public function extra_tablenav($which)
    {
        $umeta_id = sanitize_text_field( $_POST['umeta_id'] );
        $user_id = sanitize_text_field( $_POST['user_id'] );
        $meta_key = sanitize_text_field( $_POST['meta_key'] );
        $meta_value = sanitize_text_field( $_POST['meta_value'] );
    ?>
        <div class="alignleft actions daterangeactions">
            <form name='searchfilter'>
                <label for="daterange-actions-picker" class="screen-reader-text"><?=__('Filter', 'iw-stats')?></label>
                <input type="textfield" name="umeta_id" id="umeta_id" placeholder="UMeta Id" value="<?php echo $umeta_id ?>"/>
                <input type="textfield" name="user_id" id="user_id" placeholder="User Id" value="<?php echo $user_id ?>"/>
                <input type="textfield" name="meta_key" id="meta_key" placeholder="Meta Key" value="<?php echo $meta_key ?>"/>
                <input type="textfield" name="meta_value" id="meta_value" placeholder="Meta Value" value="<?php echo $meta_value ?>"/>
                <?php wp_nonce_field( '' ); ?>
            <?php submit_button(__('Apply', 'iw-stats'), 'action', 'dodate', false); ?>
            </form>
        </div>
        <?php
    }

    /**
     * Set the views
     *
     * @return array
     */
    public function get_views_() {
        $status_links   = array();
        $base_link      = admin_url( 'admin.php?page=sample-page' );

        foreach ($this->counts as $key => $value) {
            $class = ( $key == $this->page_status ) ? 'current' : 'status-' . $key;
            $status_links[ $key ] = sprintf( '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', add_query_arg( array( 'status' => $key ), $base_link ), $class, $value['label'], $value['count'] );
        }

        return $status_links;
    }

    /**
     * Prepare the class items
     *
     * @return void
     */
    function prepare_items() {

        if (!empty($_POST) && ! wp_verify_nonce( $_POST['_wpnonce'], '' ) ) {
            die( __( 'Are you cheating?', '' ) );
        }

        
        $columns               = $this->get_columns();
        $hidden                = array( );
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        $per_page              = 20;
        $current_page          = $this->get_pagenum();
        $offset                = ( $current_page -1 ) * $per_page;
        $this->page_status     = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : '2';

        // only ncessary because we have sample data
        $args = array(
            'offset' => $offset,
            'number' => $per_page,
        );

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = $_REQUEST['orderby'];
            $args['order']   = $_REQUEST['order'] ;
        }

        if ( isset( $_REQUEST['s'] ) && !empty( $_REQUEST['s'] ) ) {
            $args['s'] = $_REQUEST['s'];
        }

         if ( isset( $_POST['umeta_id'] ) && !empty( $_POST['umeta_id'] ) ) {
            $args['umeta_id'] = sanitize_text_field($_POST['umeta_id']);
        }
        if ( isset( $_POST['user_id'] ) && !empty( $_POST['user_id'] ) ) {
            $args['user_id'] = sanitize_text_field($_POST['user_id']);
        }
        if ( isset( $_POST['meta_key'] ) && !empty( $_POST['meta_key'] ) ) {
            $args['meta_key'] = sanitize_text_field($_POST['meta_key']);
        }
        if ( isset( $_POST['meta_value'] ) && !empty( $_POST['meta_value'] ) ) {
            $args['meta_value'] = sanitize_text_field($_POST['meta_value']);
        }


        $this->items  = um_get_all_UserMeta( $args );

        $this->set_pagination_args( array(
            'total_items' => um_get_UserMeta_count(),
            'per_page'    => $per_page
        ) );
    }
}