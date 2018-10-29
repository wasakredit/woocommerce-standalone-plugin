<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class Wasa_Kredit_Checkout_Standalone {
	public static function run() {
		self::load_dependencies();
		self::add_styles();
		
		add_shortcode('wasa_kredit_checkout_router', 'Wasa_Kredit_Checkout_Standalone::render_page');
		add_filter('wasa_kredit_settings', 'Wasa_Kredit_Checkout_Standalone::add_settings');		
		add_action('plugins_loaded', 'Wasa_Kredit_Checkout_Standalone::set_locale');
	}

	public static function render_page() {
		include(plugin_dir_path( __FILE__ ) . '../templates/wasa-checkout-page-router.php');		
	}

	public static function add_settings($settings) {
		return array_merge($settings, array(
			'standalone_section' => array(
				'title' => __( 'Standalone settings', 'wasa-kredit-checkout-standalone' ),
				'type'  => 'title',
			),			
			'woo_checkout_page'     => array(
				'title'   => __( 'Woo checkout page', 'wasa-kredit-checkout-standalone' ),
				'type'    => 'select',
				'label'   => __(
					'Select standard WooCommerce checkout page',
					'wasa-kredit-checkout-standalone' ),
				'options' => self::get_top_pages(),
				'default' => '',
			),
			'woo_checkout_title'     => array(
				'title'   => __( 'Woo checkout title', 'wasa-kredit-checkout-standalone' ),
				'type'    => 'text',
				'label'   => __(
					'Select title for the standard WooCommerce checkout page',
					'wasa-kredit-checkout-standalone' ),
				'default' => __( 'Other payment types', 'wasa-kredit-checkout-standalone' ),
			),
			'woo_checkout_desc'     => array(
				'title'   => __( 'Woo checkout description', 'wasa-kredit-checkout-standalone' ),
				'type'    => 'textarea',
				'label'   => __(
					'Select description for the standard WooCommerce checkout page',
					'wasa-kredit-checkout-standalone' ),
				'default' => __( 'Other payment types', 'wasa-kredit-checkout-standalone' ),
			),
			'alternative_checkout_page'     => array(
				'title'   => __( 'Alternative checkout page', 'wasa-kredit-checkout-standalone' ),
				'type'    => 'select',
				'label'   => __(
					'Select an alternative checkout page.',
					'wasa-kredit-checkout-standalone' ),
				'options' => self::get_top_pages(),
				'default' => '',
			),
			'alternative_checkout_title'     => array(
				'title'   => __( 'Alternative checkout title', 'wasa-kredit-checkout-standalone' ),
				'type'    => 'text',
				'label'   => __(
					'Select title for the alternative checkout page.',
					'wasa-kredit-checkout-standalone' ),
				'default' => '',
			),
			'alternative_checkout_desc'     => array(
				'title'   => __( 'Alternative checkout description', 'wasa-kredit-checkout-standalone' ),
				'type'    => 'textarea',
				'label'   => __(
					'Select description for the alternative checkout page.',
					'wasa-kredit-checkout-standalone' ),
				'default' => '',
			)));
	}

	public static function set_locale() {
		load_plugin_textdomain(
			'wasa-kredit-checkout-standalone',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

	private static function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wasa-kredit-checkout-setup.php';
	}

	private static function add_styles() {
		wp_enqueue_style(
			'wasa-kredit-checkout-standalone',
			plugin_dir_url( dirname( __FILE__ ) ) . 'css/wasa-kredit-checkout-standalone.css',
			array(),
			WASA_KREDIT_CHECKOUT_STANDALONE_VERSION,
			'all'
		);
	}

	private static function get_top_pages() {
		$pages = get_pages();
		$options = array();

		foreach	( $pages as $page )
		{
			$options[$page->ID] = $page->post_title;
		}
		return $options;
	}
	
}
