<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); 
do_action( 'woocommerce_sidebar' );
?>
	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 * @hooked WC_Structured_Data::generate_website_data() - 30
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

    <header class="woocommerce-products-header">

		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>

		<?php endif; ?>

		<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>

    </header>

		<?php if ( have_posts() ) : ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked wc_print_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>

			<?php woocommerce_product_loop_start(); ?>

				<?php

				// Find the category + category parent, if applicable
				$term 			= get_queried_object();
				$parent_id 		= empty( $term->term_id ) ? 0 : $term->term_id;

				if ( is_product_category() ) {
					$display_type = get_woocommerce_term_meta( $term->term_id, 'display_type', true );

					switch ( $display_type ) {
						case 'products' :
							return;
						break;
						case '' :
							if ( '' === get_option( 'woocommerce_category_archive_display' ) ) {
								return;
							}
						break;
					}
				}

				// NOTE: using child_of instead of parent - this is not ideal but due to a WP bug ( https://core.trac.wordpress.org/ticket/15626 ) pad_counts won't work
				$product_categories = get_categories( apply_filters( 'woocommerce_product_subcategories_args', array(
					'parent'       => $parent_id,
					'menu_order'   => 'ASC',
					'hide_empty'   => 0,
					'hierarchical' => 1,
					'taxonomy'     => 'product_cat',
					'pad_counts'   => 1,
				) ) );

				if ( apply_filters( 'woocommerce_product_subcategories_hide_empty', true ) ) {
					$product_categories = wp_list_filter( $product_categories, array( 'count' => 0 ), 'NOT' );
				}

				if ( $product_categories ) {
					echo $before;

					foreach ( $product_categories as $category ) {
						//var_dump($category); die;
						?>
						<li class="product-subcategory product-subcategory-archive">
			          	<h3>
			               <a href="<?= get_category_link( $category->term_id ); ?>">
			               <?= $category->name; ?>
			               </a>
			          	</h3>
			          	<div class="count">(<?= $category->category_count; ?>)</div>
					     <a class="link" href="<?= get_category_link( $category->term_id ); ?>"><button type="button"> Browse </button></a>
				    	 </li>
						<?php
						//wc_get_template( 'content-product_cat.php', array(
						//	'category' => $category,
						//) );
					}
				}

				?>
				<?php //woocommerce_product_subcategories(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/**
						 * woocommerce_shop_loop hook.
						 *
						 * @hooked WC_Structured_Data::generate_product_data() - 10
						 */
						do_action( 'woocommerce_shop_loop' );
					?>

					<?php //wc_get_template_part( 'content', 'product' ); ?>


				     <li class="product product-archive">
			          	<h3>
			               <a href="<?php the_permalink(); ?>">
			               <?php the_title(); ?>
			               </a>
			          	</h3>
			          	<?php $product = get_product(get_the_ID()); ?>
			          	<div class="price"><?php echo wc_price($product->get_price_including_tax(1, $product->get_sale_price())); ?></div>
			          	<form class="cart" method="post" enctype="multipart/form-data">
						     <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->id); ?>">
					     <button type="submit"> <?php echo $product->single_add_to_cart_text(); ?> </button>
						</form>
				     </li>


				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php
				/**
				 * woocommerce_no_products_found hook.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action( 'woocommerce_no_products_found' );
			?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		
	?>
<?php get_footer( 'shop' ); ?>
