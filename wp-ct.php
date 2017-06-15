<?
/**
 *
 * @package   wp-ct
 * @license   GPL-2.0+
 *
 * Plugin Name: WP insert name
 * Plugin URI:  /
 * Description: Enables a custom post type, taxonomy and metaboxes.
 * Version:     0.1
 * Author:      David Voglgsnag
 * Author URI:  /
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


/* SECURITY - If this file is called directly, abort
/===================================================== */
if ( ! defined( 'WPINC' ) ) {
	die;
}


/* INCLUDE - Required files for registering the post type and taxonomies
/===================================================== */
require plugin_dir_path( __FILE__ ) . 'includes/class-register.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-plugin.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-backend.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-metaboxes.php';


/* INSTANTIATE - Required files for registering the post type and taxonomies
/===================================================== */
$post_type_registrations = new Post_Type_Registration;
$post_type = new Main_Settings( $post_type_registrations );


/* REGISTER CALLBACK
/===================================================== */
register_activation_hook( __FILE__, array( $post_type, 'activate' ) );

// Initialize registrations for post-activation requests.
$post_type_registrations->init();

// Initialize custom fields
$post_type_metaboxes = new Metabox_settings;
$post_type_metaboxes->init();

if ( is_admin() ) {
	$post_type_admin = new Backend_settings( $post_type_registrations );
	$post_type_admin->init();
}
?>
