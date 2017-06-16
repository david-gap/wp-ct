<?
/**
 *
 *
 * Metaboxes registration and backend output
 * @package wp-ct
 * Author:      David Voglgsnag
 */

class Metabox_settings {

	public function init() {
		add_action( 'add_meta_boxes', array( $this, 'wpct_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta_boxes' ),  10, 2 );
	}

	// Register the metaboxes
	public function wpct_meta_boxes() {
		add_meta_box(
			'wpct_fields',
			'Custom fields',
			array( $this, 'output_meta_boxes' ),
			'post-type-name', // dev: Define post type
			'normal',
			'high'
		);
	}

	// output the metaboxes
	function output_meta_boxes( $post ) {

		// "dev: Define custom fields"
		$meta = get_post_custom( $post->ID );
		$output_id = ! isset( $meta['cf_id'][0] ) ? '' : $meta['cf_id'][0];
		$output_name = ! isset( $meta['cf_name'][0] ) ? '' : $meta['cf_name'][0];
		$output_class = ! isset( $meta['cf_class'][0] ) ? '' : $meta['cf_class'][0];

		wp_nonce_field( basename( __FILE__ ), 'post-type-name' ); ?>
		<table class="backend-metabox-output">
			<tr>
				<td>
					<label for="cf_id"><?php _e( 'ID', 'wp-ct' ); ?></label>
				</td>
				<td>
					<input type="text" name="cf_id" value="<?php echo $output_id; ?>">
				</td>
			</tr>
			<tr>
				<td>
					<label for="cf_name"><?php _e( 'Name', 'wp-ct' ); ?></label>
				</td>
				<td>
					<input type="text" name="cf_name" value="<?php echo $output_name; ?>">
				</td>
			</tr>
			<tr>
				<td>
					<label for="cf_class"><?php _e( 'Class', 'wp-ct' ); ?></label>
				</td>
				<td>
					<input type="text" name="cf_class" value="<?php echo $output_class; ?>">
				</td>
			</tr>

		</table>
	<? }

	// output the metaboxes
	function save_meta_boxes( $post_id ) {

		global $post;

		// Verify nonce
		if ( !isset( $_POST['wpct_fields'] ) || !wp_verify_nonce( $_POST['wpct_fields'], basename(__FILE__) ) ) {
			return $post_id;
		}
		// Check Autosave
		if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) {
			return $post_id;
		}
		// Don't save if only a revision
		if ( isset( $post->post_type ) && $post->post_type == 'revision' ) {
			return $post_id;
		}
		// Check permissions
		if ( !current_user_can( 'edit_post', $post->ID ) ) {
			return $post_id;
		}

		/* CUSTOM FIELDS
		/ https://codex.wordpress.org/Function_Reference/esc_textarea
		/===================================================== */
		// "dev: Define custom fields"
		$meta['cf_id'] = ( isset( $_POST['cf_id'] ) ? esc_textarea( $_POST['cf_id'] ) : '' );
		$meta['cf_name'] = ( isset( $_POST['cf_name'] ) ? esc_textarea( $_POST['cf_name'] ) : '' );
		$meta['cf_class'] = ( isset( $_POST['cf_class'] ) ? esc_textarea( $_POST['cf_class'] ) : '' );

		foreach ( $meta as $key => $value ) {
			update_post_meta( $post->ID, $key, $value );
		}
	}
}
?>
