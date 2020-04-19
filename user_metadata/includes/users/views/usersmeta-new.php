<div class="wrap">
    <h1><?php _e( 'Add New UsersMeta', '' ); ?></h1>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <!-- <tr class="row-umeta-id">
                    <th scope="row">
                        <label for="umeta_id"><?php //_e( 'Meta Id', '' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="umeta_id" id="umeta_id" class="regular-text" placeholder="<?php //echo esc_attr( '', '' ); ?>" value="" />
                    </td>
                </tr> -->
                <tr class="row-user-id">
                    <th scope="row">
                        <label for="user_id"><?php _e( 'User Id', '' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="user_id" id="user_id" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="" />
                    </td>
                </tr>
                <tr class="row-meta-key">
                    <th scope="row">
                        <label for="meta_key"><?php _e( 'Meta Key', '' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="meta_key" id="meta_key" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="" />
                    </td>
                </tr>
                <tr class="row-meta-value">
                    <th scope="row">
                        <label for="meta_value"><?php _e( 'Meta Value', '' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="meta_value" id="meta_value" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="" />
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( '' ); ?>
        <?php submit_button( __( 'Add New UserMeta', '' ), 'primary', 'User_SubmitData' ); ?>

    </form>
</div>