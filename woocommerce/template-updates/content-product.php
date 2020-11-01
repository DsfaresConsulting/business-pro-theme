<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li class="product product-archive">
	<div class="product-left">
	<h3>
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</h3>
	</div>
	<div class="product-right">

	<?php $product = get_product(get_the_ID()); ?>
	<div class="price"><?php echo wc_price($product->get_price_excluding_tax(1, $product->get_sale_price())); ?></div>
	<?php if(get_field('sample_pdf') != null){?>
	<a class="view_sample iframe group" target="_blank" href="<?php echo site_url() . '/pdf/?pdfembed='. get_the_ID() ;?>"><button type="button"> View sample </button></a>
	<?php } ?>
	<form class="cart" method="post" enctype="multipart/form-data">
		<input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->id); ?>">
		<button type="submit"> <?php echo $product->single_add_to_cart_text(); ?> </button>
	</form>
	</div>
</li>

<script>
jQuery(document).ready(function($) {

	/* This is basic - uses default settings */
	
	$("a#single_image").fancybox();
	
	/* Using custom settings */
	
	$("a#inline").fancybox({
		'hideOnContentClick': true
	});

	/* Apply fancybox to multiple items */
	
	$("a.group").fancybox({
		'width': '60%',
		'height': '80%',
		'overlayShow'	:	false
	});

	$('a.iframe').click( function(e){
		e.preventDefault();

	})
	
});
</script>