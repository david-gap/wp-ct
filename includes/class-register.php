<?
/**
 *
 *
 * Register post type and taxonimies
 * @package wp-ct
 * Author:      David Voglgsnag
 */

class Post_Type_Registration {
	/* Settigs
	/===================================================== */
	public $post_type = 'post-type-name'; // dev: Define post type
	public $taxonomies = array( 'tax-name' ); // dev: Define taxonomies


	/* Functions
	/===================================================== */
	public function init() {
		add_action( 'init', array( $this, 'register' ) );
	}
	public function register() {
		$this->register_post_type();
		$this->register_taxonomy_category();
	}

	// register post type
	protected function register_post_type() {
		$pt_labels = array(
			'name'               => __( 'Custom Type', 'wp-ct' ), // dev: Define backend menu name
		);

		$pt_supports = array(
			'title',
			'editor',
			'thumbnail',
			'custom-fields',
			'revisions',
		);
		$args = array(
			'labels'          => $pt_labels,
			'supports'        => $pt_supports,
			'public'          => true,
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => 'wp-cf', ), // dev: Define slug
			'menu_position'   => 30,
		);

		$args = apply_filters( 'post_type_args', $args );
		register_post_type( $this->post_type, $args );
	}


	// register taxonomies
	protected function register_taxonomy_category() {
		$labels = array(
			'name'                       => __( 'Categories', 'wp-ct' ),
		);
		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'wp-cf-category' ), // dev: Define slug
			'show_admin_column' => true,
			'query_var'         => true,
		);

		$args = apply_filters( 'post_type_category_args', $args );
		register_taxonomy( $this->taxonomies[0], $this->post_type, $args );
	}
}
?>
