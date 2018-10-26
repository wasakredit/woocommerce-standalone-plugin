<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
	<h3 id="order_review_heading"><?php _e( 'Your order', 'woocommerce' ); ?></h3>
	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
	<div id="order_review22" class="woocommerce-checkout-review-order">
		<?php woocommerce_order_review(); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
	<h3 id="order_BETALSÄTT_heading"><?php _e( 'Välj betalsätt', 'woocommerce' ); ?></h3>
	<div id="order_review22" class="wasa-kredit-checkout-standalone router" style="display: flex">		
		<?php
			PaymentOptionLayout(Wasa_Kredit_Checkout_Standalone_Setup::WooCommerce_Checkout_Page());
			PaymentOptionLayout(Wasa_Kredit_Checkout_Standalone_Setup::Alternative_Checkout_Page());			
		?>
	</div>
</form>

<?php
	function PaymentOptionLayout($page){		
		echo('<div class="buttons-2">');				
			echo('<div class="button">');
				echo('<a href="' . $page['link'] . '">');
					echo('<div class="title">' . $page['title'] . '</div>');
					echo('<div class="description">' . $page['description'] . '</div>');
				echo('</a>');
			echo('</div>');				
		echo('</div>');
	}
?>