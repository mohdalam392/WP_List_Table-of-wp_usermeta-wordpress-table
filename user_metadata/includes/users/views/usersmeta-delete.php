<div class="wrap">
    <h1><?php _e( 'Delete Option', '' ); ?></h1>

    <?php $user_det = um_get_UserMeta( $umeta_id ); ?>
    <?php 
        um_delete_UserMeta($umeta_id);
        //swp_redirect(admin_url( 'admin.php?page=optionsmetadata' ));
        echo "<script>window.location.href='".admin_url( 'admin.php?page=usersmetadata&message=deleted' )."';</script>";
    ?>
</div>