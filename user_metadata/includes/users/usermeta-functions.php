<?php

/**
 * Get all UserMeta
 *
 * @param $args array
 *
 * @return array
 */
function um_get_all_UserMeta( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 20,
        'offset'     => 0,
        'orderby'    => 'umeta_id',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = 'UserMeta-all';
    $items     = wp_cache_get( $cache_key, '' );

    if ( false === $items ) {

        if(empty($args['s'])){
            $query = 'SELECT * FROM ' . $wpdb->prefix . 'usermeta where 1=1 ';

            if(!empty($args['umeta_id'])){
                $query  .='and umeta_id="'.$args['umeta_id'].'" ';
            }
            if(!empty($args['user_id'])){
                $query  .='and user_id="'.$args['user_id'].'" ';
            }
            if(!empty($args['meta_key'])){
                $query  .='and meta_key="'.$args['meta_key'].'" ';
            }
            if(!empty($args['meta_value'])){
                $query  .='and meta_value="'.$args['meta_value'].'" ';
            }

            $query  .='ORDER BY umeta_id ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'];
             $items = $wpdb->get_results( $query );
        }else{
            $items = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'usermeta where user_id like "%'.$args['s'].'%" or meta_key like "%'.$args['s'].'%" or meta_value like "%'.$args['s'].'%" ORDER BY umeta_id ' . $args['order'] .' LIMIT ' . $args['offset'] . ', ' . $args['number'] );
        }
        wp_cache_set( $cache_key, $items, '' );
    }

    return $items;
}


/**
 * Insert a new UserMeta
 *
 * @param array $args
 */
function um_insert_UserMeta( $args = array() ) {
    global $wpdb;

    $defaults = array(
        //'id'         => null,
        //'umeta_id' => '',
        'user_id' => '',
        'meta_key' => '',
        'meta_value' => '',

    );

    $args       = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . 'usermeta';

    // some basic validation

    // remove row id to determine if new or update
    $row_id = (int) $args['umeta_id'];
    unset( $args['umeta_id'] );

    if ( ! $row_id ) {

        

        // insert a new
        if ( $wpdb->insert( $table_name, $args ) ) {
            return $wpdb->insert_id;
        }

    } else {

        // do update method here
        if ( $wpdb->update( $table_name, $args, array( 'umeta_id' => $row_id ) ) ) {
            return $row_id;
        }
    }

    return false;
}



function um_delete_UserMeta( $umeta_id = 0 ) {
    global $wpdb;
    $wpdb->delete( $wpdb->prefix.'usermeta',array('umeta_id'=>$umeta_id));
}


/**
 * Fetch all UserMeta from database
 *
 * @return array
 */
function um_get_UserMeta_count() {
    global $wpdb;

    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'usermeta' );
}

/**
 * Fetch a single UserMeta from database
 *
 * @param int   $id
 *
 * @return array
 */
function um_get_UserMeta( $umeta_id = 0 ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'usermeta WHERE umeta_id = %d', $umeta_id ) );
}