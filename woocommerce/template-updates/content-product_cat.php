<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
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
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<li class="product-subcategory product-subcategory-archive">
	<div class="product-left">
		<h3>
		<a href="<?= get_category_link( $category->term_id ); ?>">
		<?= $category->name; ?>
		</a>
		</h3>
		<!--<div class="count">(<?= $category->category_count; ?>)</div>-->
	</div>
	<div class="product-right">
		<a class="link" href="<?= get_category_link( $category->term_id ); ?>"><button type="button"> Browse </button></a>
	</div>
	<div class="clr"></div>
</li>
