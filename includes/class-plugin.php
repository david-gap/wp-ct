<?
/**
 *
 *
 * Plugin registration and settings
 * @package wp-ct
 * Author:      David Voglgsnag
 */

class Main_Settings {
	/* Plugin Settigs
	/===================================================== */
	const VERSION = '0.1';
	const PLUGIN_SLUG = 'wp-ct'; // dev: Define plugin slug

	protected $registration_handler;
	public function __construct( $registration_handler ) {
		$this->registration_handler = $registration_handler;
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
	}

	// Fired when the plugin is activated
	public function activate() {
		$this->registration_handler->register();
		flush_rewrite_rules();
	}

	// Fired when the plugin is deactivated
	public function deactivate() {
		flush_rewrite_rules();
	}

	// Load plugin text
	public function load_plugin_textdomain() {
		$domain = self::PLUGIN_SLUG;
		load_plugin_textdomain( $domain, FALSE, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages' );
	}
}
?>
