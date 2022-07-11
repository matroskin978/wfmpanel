<div class="wrap">

	<?php
	$wfm_posts  = Wfmpanel_Admin::get_posts();
	$wfm_slides = Wfmpanel_Admin::get_slides();
	$page       = $_GET['paged'] ?? 1;
	?>

    <h1><?php _e( 'Set slide', 'wfmpanel' ) ?></h1>

    <p><?php _e( 'Number of articles:', 'wfmpanel' ); ?><?php echo $wfm_posts->found_posts ?></p>

    <!-- Pagination -->
    <div class="pagination">
		<?php
		$big = 999999999; // need an unlikely integer

		echo paginate_links( array(
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'    => '?paged=%#%',
			'current'   => $page,
			'total'     => $wfm_posts->max_num_pages,
			'prev_text' => '&laquo;',
			'next_text' => '&raquo;',
			'mid_size'  => 5
		) );
		?>
    </div>
    <!-- Pagination -->

    <table class="wp-list-table widefat fixed striped table-view-list posts">
        <thead>
        <tr>
            <th class="manage-column column-title column-primary"
                style="width: 50%;"><?php _e( 'Title', 'wfmpanel' ); ?></th>
            <th class="manage-column column-categories" style="width: 50%;"><?php _e( 'Slide', 'wfmpanel' ); ?></th>
        </tr>
        </thead>
        <tbody>

		<?php if ( $wfm_posts->have_posts() ) : while ( $wfm_posts->have_posts() ) : $wfm_posts->the_post(); ?>
			<?php
			$slide_id = get_post_meta( get_the_ID(), 'wfm_panel', true );
			?>
            <tr>
                <td class="title column-title has-row-actions column-primary page-title"
                    data-colname="<?php _e( 'Title', 'wfmpanel' ); ?>">
                    <a href="<?php the_permalink(); ?>"><?php the_title() ?></a>
                    <button type="button" class="toggle-row"><span
                                class="screen-reader-text"><?php _e( 'Show more details', 'wfmpanel' ); ?></span>
                    </button>
                </td>
                <td class="column-slides" data-colname="<?php _e( 'Slides', 'wfmpanel' ); ?>">
                    <select class="wfmpanel-select" data-article="<?php the_ID(); ?>">
                        <option value="0" <?php selected( $slide_id, 0 ) ?>><?php _e( 'Select slide', 'wfmpanel' ) ?></option>
						<?php foreach ( $wfm_slides as $id => $wfm_slide ): ?>
                            <option value="<?php echo $id ?>" <?php selected( $slide_id, $id ) ?>><?php echo $wfm_slide ?></option>
						<?php endforeach; ?>
                    </select>
                </td>
            </tr>
		<?php endwhile; else : ?>
            <p><?php _e( 'No entries found', 'wfmpanel' ) ?></p>
		<?php endif; ?>

        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
		<?php
		$big = 999999999; // need an unlikely integer

		echo paginate_links( array(
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'    => '?paged=%#%',
			'current'   => $page,
			'total'     => $wfm_posts->max_num_pages,
			'prev_text' => '&laquo;',
			'next_text' => '&raquo;',
			'mid_size'  => 5
		) );
		?>
    </div>
    <!-- Pagination -->

    <div id="wfmpanel-loader">
        <img src="<?php echo WFMPANEL_PLUGIN_URL . 'admin/img/ripple.svg' ?>" alt="">
    </div>

</div>