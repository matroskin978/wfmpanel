<div class="wrap">
    <h1><?php _e( 'Slides management', 'wfmpanel' ) ?></h1>

    <h3><?php _e( 'Add slide', 'wfmpanel' ) ?></h3>

	<?php
    $errors = get_transient( 'wfmpanel_form_errors' );
    $success = get_transient( 'wfmpanel_form_success' );
    ?>
	<?php if ( $errors ): ?>
        <div id="setting-error-settings_updated" class="notice notice-error settings-error is-dismissible">
            <p><strong><?php echo $errors; ?></strong></p>
        </div>
		<?php delete_transient( 'wfmpanel_form_errors' ) ?>
	<?php endif; ?>

	<?php if ( $success ): ?>
        <div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible">
            <p><strong><?php echo $success; ?></strong></p>
        </div>
		<?php delete_transient( 'wfmpanel_form_success' ) ?>
	<?php endif; ?>

    <form action="<?php echo admin_url( 'admin-post.php' ) ?>" method="post" class="wfmpanel-add-slide">
        <table class="form-table">
            <tbody>

            <tr>
                <th>
                    <label for="slide_title"><?php _e( 'Slide title', 'wfmpanel' ) ?></label>
                </th>
                <td>
                    <input type="text" id="slide_title" class="regular-text" name="slide_title">
                </td>
            </tr>

            <tr>
                <th>
                    <label for="slide_content"><?php _e( 'Slide content', 'wfmpanel' ) ?></label>
                </th>
                <td>
                    <textarea name="slide_content" id="slide_content" cols="50" rows="10"
                              class="large-text code"></textarea>
                </td>
            </tr>

            </tbody>
        </table>

		<?php wp_nonce_field( 'wfmpanel_action', 'wfmpanel_add_slide' ) ?>
        <input type="hidden" name="action" value="save_slide">

        <p class="submit">
            <button class="button button-primary" type="submit"
                    id="submit"><?php _e( 'Add slide', 'wfmpanel' ) ?></button>
        </p>
    </form>

    <hr>

    <h3><?php _e( 'Edit slides', 'wfmpanel' ) ?></h3>

</div>
