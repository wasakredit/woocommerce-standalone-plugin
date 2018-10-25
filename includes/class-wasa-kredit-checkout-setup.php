<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit(); // Exit if accessed directly
}

/**
 * Fired during plugin deactivation
 *
 * @link       https://developer.wasakredit.se
 * @since      1.0.0
 *
 * @package    Wasa_Kredit_Checkout
 * @subpackage Wasa_Kredit_Checkout/includes
 * @author     Wasa Kredit <ehandel@wasakredit.se>
 */

 class Wasa_Kredit_Checkout_Standalone_Setup {
	public static function activate() {
		self::create_checkout_page();
	}

	public static function deactivate() {
		self::delete_checkout_page();
	}

	public static function Settings() { return  get_option( 'wasa_kredit_settings' ); }

	public static function WooCommerce_Checkout_Page() {
		$woocommerce_checkout_page_id = self::Settings()['woo_checkout_page'];
		if( is_null($woocommerce_checkout_page_id) )
			return null;

		$returnObj = array();
		$returnObj['enabled'] = true;
		$returnObj['link'] = get_page_link($woocommerce_checkout_page_id);
		$returnObj['title'] = self::Settings()['woo_checkout_title'];
		$returnObj['description'] = self::Settings()['woo_checkout_desc'];

		return $returnObj;
	}

	public static function Alternative_Checkout_Page() {
		$alternative_checkout_page_id = self::Settings()['alternative_checkout_page'];
		if( is_null($alternative_checkout_page_id) )
			return null;

		$returnObj = array();
		$returnObj['enabled'] = true;
		$returnObj['link'] = get_page_link($alternative_checkout_page_id);
		$returnObj['title'] = self::Settings()['alternative_checkout_title'];
		$returnObj['description'] = self::Settings()['alternative_checkout_desc'];

		return $returnObj;
	}


	public static function Checkout_Page_Id_Key() { return 'wc_wasa_checkout_page_id'; }

	public static function Checkout_Page_Id() { return get_option( Wasa_Kredit_Checkout_Standalone_Setup::Checkout_Page_Id_Key() ); }

	public static function Checkout_Page_Exists(){
		$found_checkout_post = get_post( Wasa_Kredit_Checkout_Standalone_Setup::Checkout_Page_Id() );
		if( is_null( $found_checkout_post ) )
			return false;

		if( $found_checkout_post->post_status == 'trash') 
			return false;

		return true;
	}

	/**
	 * Create checkout page that the plugin relies on, storing page id's in variables.
	 */
	private static function create_checkout_page() {  
		$should_create_checkout_page = false;

		$checkout_page_id = get_option( Wasa_Kredit_Checkout_Standalone_Setup::Checkout_Page_Id_Key() );

		if( ! $checkout_page_id ) {
			$should_create_checkout_page = true;
		} else {
			$found_checkout_post = get_post( $checkout_page_id );
			if( is_null( $found_checkout_post ) || $found_checkout_post->post_status == 'trash') {
				$should_create_checkout_page = true;
			}
		}

		if( $should_create_checkout_page ) {
			$checkout_page = array(
				'post_type'     => 'page',
				'post_status'   => 'publish',
				'post_title'    => _x('Wasa Checkout (Standalone)', 'Page title', 'wasa-kredit-checkout-standalone'),
				'post_name'     => _x('wasa-checkout-standalone', 'Page slug', 'wasa-kredit-checkout-standalone'),
				'post_content'  => '[wasa_kredit_checkout_router]'
			);

			$checkout_post_id = wp_insert_post( $checkout_page );
			update_option( Wasa_Kredit_Checkout_Standalone_Setup::Checkout_Page_Id_Key(), $checkout_post_id );
		}
	}

	private static function delete_checkout_page() {  

		$checkout_page_id = get_option( Wasa_Kredit_Checkout_Standalone_Setup::Checkout_Page_Id_Key() );

		if(!$checkout_page_id)
			return;

		$found_checkout_posts = get_post( $checkout_page_id );
		foreach($found_checkout_posts as $found_checkout_post)
		{
			if( is_null( $found_checkout_post ) || $found_checkout_post->post_status == 'trash') 
				return;

			wp_delete_post( $found_checkout_post );
		}
	}
}
