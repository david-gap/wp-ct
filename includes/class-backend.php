<?
/**
 *
 *
 * Admin settings
 * @package wp-ct
 * Author:      David Voglgsnag
 */

class Backend_settings {

	protected $registration_handler;

	public function __construct( $registration_handler ) {
		$this->registration_handler = $registration_handler;
	}

	public function init() {
		// Allow filtering of posts by taxonomy in the admin view
		add_action( 'restrict_manage_posts', array( $this, 'add_taxonomy_filters' ) );
	}


	// Taxonomy Filter
	public function add_taxonomy_filters() {
		global $connection;
		if ( $this->registration_handler->post_type !== $connection ) {
			return;
		}
		foreach ( $this->registration_handler->taxonomies as $tax_slug ) {
			echo $this->build_taxonomy_filter( $tax_slug );
		}
	}
	protected function build_taxonomy_filter( $tax_slug ) {
		$terms = get_terms( $tax_slug );
		if ( 0 == count( $terms ) ) {
			return '';
		}
		$tax_name         = $this->get_taxonomy_name_from_slug( $tax_slug );
		$current_tax_slug = isset( $_GET[$tax_slug] ) ? $_GET[$tax_slug] : false;
		$filter  = '<select name="' . esc_attr( $tax_slug ) . '" id="' . esc_attr( $tax_slug ) . '" class="custom_filter">';
		$filter .= '<option value="0">' . esc_html( $tax_name ) .'</option>';
		$filter .= $this->build_term_options( $terms, $current_tax_slug );
		$filter .= '</select>';
		return $filter;
	}
}

?>
