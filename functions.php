<?php
/**
 * Business Pro Theme
 *
 * @package   BusinessProTheme
 * @link      https://seothemes.com/themes/business-pro
 * @author    SEO Themes
 * @copyright Copyright © 2019 SEO Themes
 * @license   GPL-3.0-or-later
 */

// If this file is called directly, abort..
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Start the engine (do not remove).
include_once get_template_directory() . '/lib/init.php';

// Load setup functions.
include_once __DIR__ . '/includes/setup.php';

// Load helper functions.
include_once __DIR__ . '/includes/helpers.php';

// Load scripts and styles.
include_once __DIR__ . '/includes/enqueue.php';

// Load general functionality.
include_once __DIR__ . '/includes/general.php';

// Load hero section.
include_once __DIR__ . '/includes/hero.php';

// Load widget areas.
include_once __DIR__ . '/includes/widgets.php';

// Load Customizer settings.
include_once __DIR__ . '/includes/customize.php';

// Load default settings.
include_once __DIR__ . '/includes/defaults.php';

// Load recommended plugins.
include_once __DIR__ . '/includes/plugins.php';

// Load bidirectional acf.
include_once __DIR__ . '/lib/bidirectional-acf.php';



if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme Options',
		'menu_title'	=> 'Theme Options',
		'menu_slug' 	=> 'theme-general-options',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

}


function add_copyright() {
	echo '<div class="social-buttons">';
			echo '<a target="_blank" href="https://www.facebook.com/appliedpractice/" class="fb"><i class="fa fa-facebook-f" aria-hidden="true"></i></a>';
			echo '<a target="_blank" href="https://www.pinterest.com/appliedpractice/" class="pn"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>';
			echo '<a target="_blank" href="https://twitter.com/appliedpractice" class="tw"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
			echo '<a target="_blank" href="https://instagram.com/appliedpractice" class="ig"><i class="fa fa-instagram" aria-hidden="true"></i></a>';
		echo '</div>';
		echo '<div class="clr"></div>';

	echo '<p class="copyright">' . get_field('copyright_line', 'option') . '</p>';
	echo '<div  class="footer-special-text">' . get_field('disclaimer', 'option') . '</div>';

}

add_action('genesis_footer', 'add_copyright');


// from old theme

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url("/wp-content/uploads/2017/06/LOGO-2.svg");
		height:100px;
		width:320px;
		background-size: contain;
		background-repeat: no-repeat;
        	padding-bottom: 30px;
        }
    </style>
<?php }


add_action( 'login_enqueue_scripts', 'my_login_logo' );


function your_function() {
    if( function_exists('WC') ){
        WC()->cart->empty_cart();
    }
}
add_action('wp_logout', 'your_function');


//* Make Font Awesome available
add_action( 'wp_enqueue_scripts', 'enqueue_font_awesome' );
function enqueue_font_awesome() {

	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css' );

}

add_filter('wp_nav_menu_items','sk_wcmenucart', 10, 2);
function sk_wcmenucart($menu, $args) {

	// Check if WooCommerce is active and add a new item to a menu assigned to Primary Navigation Menu location
	if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || 'primary' !== $args->theme_location )
		return $menu;

	ob_start();
		global $woocommerce;
		$viewing_cart = __('View your shopping cart', 'your-theme-slug');
		$start_shopping = __('Start shopping', 'your-theme-slug');
		$cart_url = $woocommerce->cart->get_cart_url();
		$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
		$cart_contents_count = $woocommerce->cart->cart_contents_count;
		$cart_contents = sprintf(_n('%d item', '%d items', $cart_contents_count, 'your-theme-slug'), $cart_contents_count);
		$cart_total = $woocommerce->cart->get_cart_total();
		// Uncomment the line below to hide nav menu cart item when there are no items in the cart
		if ( $cart_contents_count > 0 ) {
			if ($cart_contents_count == 0) {
				$menu_item = '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children"><a class="wcmenucart-contents" href="'. $shop_page_url .'" title="'. $start_shopping .'">';
			} else {
				$menu_item = '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children"><a class="wcmenucart-contents" href="'. $cart_url .'" title="'. $viewing_cart .'">';
			}

			$menu_item .= '<i class="fa fa-shopping-cart"></i> ';

			$menu_item .= $cart_contents.' - '. $cart_total;
			$menu_item .= '</a></li>';
		// Uncomment the line below to hide nav menu cart item when there are no items in the cart
		}else{
			$menu_item = '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children"><a class="wcmenucart-contents" href="'. $cart_url .'" title="'. $viewing_cart .'">';

			$menu_item .= '<i class="fa fa-shopping-cart"></i> ';

			$menu_item .= 'Cart';
			$menu_item .= '</a></li>';
		}

		// Add search button
		/*
		$menu_item .= '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children search-navbar"><a class="" href="">';
		$menu_item .= '<i class="fa fa-search"></i> ';
		$menu_item .= 'Search';
		$menu_item .= '</a></li>';

		$menu_item .= '<form action="/"><div class="shadow-search"><input name="s" type="text" placeholder="Type here..."/><button type="submit">Search</div></form>';
		*/

		echo $menu_item;
	$social = ob_get_clean();
	return $menu . $social;

}



// Add the theme's required WooCommerce functions.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Add the custom CSS to the theme's WooCommerce stylesheet.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Include notice to install Genesis Connect for WooCommerce.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );



function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');



// add_action( 'woocommerce_archive_description', 'woocommerce_category_image', 2 );
// function woocommerce_category_image() {
// global $image;
//     if ( is_product_category() ){
// 	    global $wp_query;
// 	    $cat = $wp_query->get_queried_object();
// 	    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
// 	    $image = wp_get_attachment_url( $thumbnail_id );
//
// if ($image){
// 		 echo '<img class="category-image" src="' . $image . '" alt="' . $cat->name . '" />';
// 	}
// 	}
// }


//
// function woocommerce_taxonomy_archive_description() {
// global $image;
//     if ( is_product_taxonomy() && 0 === absint( get_query_var( 'paged' ) ) ) {
//         $description = wc_format_content( term_description() );
//         if ( $description && $image) {
//             echo '<div class="term-description-image">' . $description . '</div>';
//         }
//         else
//          if ( $description) {
//             echo '<div class="term-description-no-image">' . $description . '</div>';
//         }
//         echo '<div class="clr"></div>';
//     }
// }





// Edit WooCommerce dropdown menu item of shop page//
// Options: menu_order, popularity, rating, date, price, price-desc

function custom_woocommerce_catalog_orderby( $orderby ) {
    unset($orderby["popularity"]);
    return $orderby;
}
add_filter( "woocommerce_catalog_orderby", "custom_woocommerce_catalog_orderby", 20 );


add_action( 'woocommerce_coupon_options_usage_limit', 'woocommerce_coupon_options_usage_limit', 10, 2 );
function woocommerce_coupon_options_usage_limit( $coupon_id, $coupon ){

	echo '<div class="options_group">';
	// max discount per coupons
	$max_discount =  get_post_meta( $coupon_id, '_max_discount', true );
	woocommerce_wp_text_input( array(
		'id'                => 'max_discount',
		'label'             => __( 'Usage max discount', 'woocommerce' ),
		'placeholder'       => esc_attr__( 'Unlimited discount', 'woocommerce' ),
		'description'       => __( 'The maximum discount this coupon can give.', 'woocommerce' ),
		'type'              => 'number',
		'desc_tip'          => true,
		'class'             => 'short',
		'custom_attributes' => array(
			'step' 	=> 1,
			'min'	=> 0,
		),
		'value' => $max_discount ? $max_discount : '',
	) );
	echo '</div>';

}

add_action( 'woocommerce_coupon_options_save', 'woocommerce_coupon_options_save', 10, 2 );
function woocommerce_coupon_options_save( $coupon_id, $coupon ) {

	update_post_meta( $coupon_id, '_max_discount', wc_format_decimal( $_POST['max_discount'] ) );

}


add_filter( 'woocommerce_coupon_get_discount_amount', 'woocommerce_coupon_get_discount_amount', 20, 5 );
function woocommerce_coupon_get_discount_amount( $discount, $discounting_amount, $cart_item, $single, $coupon ) {

	$max_discount = get_post_meta( $coupon->get_id(), '_max_discount', true );

	if ( is_numeric( $max_discount ) && ! is_null( $cart_item ) && WC()->cart->subtotal_ex_tax ) {

		$cart_item_qty = is_null( $cart_item ) ? 1 : $cart_item['quantity'];
		if ( wc_prices_include_tax() ) {
			$discount_percent = ( wc_get_price_including_tax( $cart_item['data'] ) * $cart_item_qty ) / WC()->cart->subtotal;
		} else {
			$discount_percent = ( wc_get_price_excluding_tax( $cart_item['data'] ) * $cart_item_qty ) / WC()->cart->subtotal_ex_tax;
		}
		$_discount = ( $max_discount * $discount_percent ) / $cart_item_qty;

		$discount = min( $max_discount, $discount );
	}

	return $discount;
}




// Agregamos los campos adicionales a Perfil y Editar Usuario

add_action( 'show_user_profile', 'add_customer_meta_fields' );
add_action( 'edit_user_profile', 'add_customer_meta_fields' );
/**
 * Show Address Fields on edit user pages.
 *
 * @param WP_User $user
 */
function add_customer_meta_fields( $user ) {

	$show_fields = get_school_meta_fields();
	foreach ( $show_fields as $fieldset_key => $fieldset ) :
		?>
		<h2><?php echo $fieldset['title']; ?></h2>
		<table class="form-table" id="<?php echo esc_attr( 'fieldset-' . $fieldset_key ); ?>">
			<?php
			foreach ( $fieldset['fields'] as $key => $field ) :
				?>
				<tr>
					<th><label for="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label></th>
					<td>
						<?php if ( ! empty( $field['type'] ) && 'select' === $field['type'] ) : ?>
							<select name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" class="<?php echo esc_attr( $field['class'] ); ?>" style="width: 25em;">
								<?php
									$selected = esc_attr( get_user_meta( $user->ID, $key, true ) );
									if (empty($selected))
										$selected = 'US';
									foreach ( $field['options'] as $option_key => $option_value ) : ?>
									<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $selected, $option_key, true ); ?>><?php echo esc_attr( $option_value ); ?></option>
								<?php endforeach; ?>
							</select>
						<?php elseif ( ! empty( $field['type'] ) && 'checkbox' === $field['type'] ) : ?>
							<input type="checkbox" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" value="1" class="<?php echo esc_attr( $field['class'] ); ?>" <?php checked( (int) get_user_meta( $user->ID, $key, true ), 1, true ); ?> />
						<?php elseif ( ! empty( $field['type'] ) && 'button' === $field['type'] ) : ?>
							<button id="<?php echo esc_attr( $key ); ?>" class="button <?php echo esc_attr( $field['class'] ); ?>"><?php echo esc_html( $field['text'] ); ?></button>
						<?php else : ?>
							<input type="text" name="<?php echo esc_attr( $key ); ?>" id="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( get_user_meta( $user->ID, $key, true ) ); ?>" class="<?php echo ( ! empty( $field['class'] ) ? esc_attr( $field['class'] ) : 'regular-text' ); ?>" />
						<?php endif; ?>
						<br/>
						<span class="description"><?php echo wp_kses_post( $field['description'] ); ?></span>
					</td>
				</tr>
				<?php
			endforeach;
			?>
		</table>
		<?php
	endforeach;
}
function get_school_meta_fields() {
	$show_fields = apply_filters('woocommerce_customer_meta_fields',array(
		'school' => array(
			'title' => __( 'School Information', 'woocommerce' ),
			'fields' => array(
				'user_position' => array(
					'label'       => __( 'Your Position', 'woocommerce' ),
					'description' => '',
				),
				'user_school_email' => array(
					'label'       => __( 'Your School Email Address', 'woocommerce' ),
					'description' => '',
				),
				'user_subject_taught' => array(
					'label'       => __( 'Subject Taught', 'woocommerce' ),
					'description' => '',
					'type'        => 'select',
					'options'     => array( '' => __( 'Select a subject&hellip;', 'woocommerce' ) ) + array(
					  'English' => 'English',
					  'Science' => 'Science',
					  'Social Studies' => 'Social Studies',
					  'Other' => 'Other')
				),
				'user_school_name' => array(
					'label'       => __( 'School Name', 'woocommerce' ),
					'description' => '',
				),
				'user_school_country' => array(
					'label'       => __( 'School Country', 'woocommerce' ),
					'description' => '',
					'class'       => 'js_field-country',
					'default'	  => 'US',
					'type'        => 'select',
					'options'     => array( '' => __( 'Select a country&hellip;', 'woocommerce' ) ) + WC()->countries->get_allowed_countries(),
				),
				'user_school_addres' => array(
					'label'       => __( 'School Address', 'woocommerce' ),
					'description' => '',
				),
				'user_school_addres_2' => array(
					'label'       => __( 'School Address line 2', 'woocommerce' ),
					'description' => '',
				),
				'user_school_city' => array(
					'label'       => __( 'School City', 'woocommerce' ),
					'description' => '',
				),

				'user_school_state' => array(
					'label'       => __( 'School State / County', 'woocommerce' ),
					'description' => __( 'State / County or state code', 'woocommerce' ),
					'class'       => 'js_field-state',
				),
				'user_school_postcode' => array(
					'label'       => __( 'School Postcode / ZIP', 'woocommerce' ),
					'description' => '',
				),

				'user_school_phone' => array(
					'label'       => __( 'School Phone', 'woocommerce' ),
					'description' => '',
				),

			),
		)));

	return $show_fields;
}


add_action( 'personal_options_update',  'save_customer_meta_fields' );
add_action( 'edit_user_profile_update', 'save_customer_meta_fields' );
/**
 * Save Address Fields on edit user pages.
 *
 * @param int $user_id User ID of the user being saved
 */
function save_customer_meta_fields( $user_id ) {
	$save_fields = get_school_meta_fields();

	foreach ( $save_fields as $fieldset ) {

		foreach ( $fieldset['fields'] as $key => $field ) {

			if ( isset( $field['type'] ) && 'checkbox' === $field['type'] ) {
				update_user_meta( $user_id, $key, isset( $_POST[ $key ] ) );
			} elseif ( isset( $_POST[ $key ] ) ) {
				update_user_meta( $user_id, $key, wc_clean( $_POST[ $key ] ) );
			}
		}
	}
}



// Validamos los campos adicionales
add_filter('registration_errors', 'validate_user_fields', 10, 3);
function validate_user_fields ($errors, $sanitized_user_login, $user_email) {
  if ( empty( $_POST['user_position'] ) ) {
    $errors->add( 'user_position_error', __('<strong>ERROR</strong>: Missing field: Your Position') );
  }
	if ( empty( $_POST['user_school_email'] ) ) {
    $errors->add( 'user_school_email_error', __('<strong>ERROR</strong>: Missing field: Your School Email Address') );
  }
  if ( empty( $_POST['user_school_name'] ) ) {
    $errors->add( 'user_school_name_error', __('<strong>ERROR</strong>: Missing field: School Name') );
  }
  if ( empty( $_POST['user_subject_taught'] ) ) {
    $errors->add( 'user_subject_taught_error', __('<strong>ERROR</strong>: Missing field: Subject Taught') );
  }

  return $errors;
}


/**
 * Add the field to the checkout
**/
add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );
function my_custom_checkout_field( $checkout ) {

    echo '<div id="my_custom_checkout_field"><h3>' . __('School Information') . '</h3>';
    woocommerce_form_field( 'user_position', array(
        'type'          => 'text',
        'class'         => array('form-row-wide'),
        'label'         => __('Your Position'),
        'required'		=> true
        ), $checkout->get_value( 'user_position' ));

		woocommerce_form_field( 'user_school_email', array(
        'type'          => 'text',
        'class'         => array('form-row-wide'),
        'label'         => __('Your School Email Address'),
        'required'		=> true
        ), $checkout->get_value( 'user_school_email' ));

		woocommerce_form_field( 'user_subject_taught', array(
        'type'          => 'select',
		'options' 		=> array(
						  'English' => 'English',
						  'Science' => 'Science',
						  'Social Studies' => 'Social Studies',
						  'Other' => 'Other'),
        'class'         => array('form-row-wide'),
        'label'         => __('Subject Taught'),
        'required'		=> true
        ), $checkout->get_value( 'user_subject_taught' ));

		woocommerce_form_field( 'user_school_name', array(
        'type'          => 'text',
        'class'         => array('form-row-wide'),
        'label'         => __('School Name'),
        'required'		=> true
        ), $checkout->get_value( 'user_school_name' ));

		woocommerce_form_field(	'user_school_country', array(
			'type'         => 'country',
			'label'        => __( 'School Country', 'woocommerce' ),
			'required'     => true,
			'class'        => array( 'form-row-wide', 'address-field', 'update_totals_on_change' ),
			'default' => 'US'
			),$checkout->get_value( 'user_school_country' ));

		woocommerce_form_field(	'user_school_addres', array(
			'label'        => __( 'School Address', 'woocommerce' ),
			'placeholder'  => esc_attr__( 'Street address', 'woocommerce' ),
			'required'     => true,
			'class'        => array( 'form-row-wide', 'address-field' ),
			),$checkout->get_value( 'user_school_addres' ));

		woocommerce_form_field('user_school_addres_2', array(
			'placeholder'  => esc_attr__( 'Apartment, suite, unit etc. (optional)', 'woocommerce' ),
			'class'        => array( 'form-row-wide', 'address-field' ),
			'required'     => false,
			),$checkout->get_value( 'user_school_addres_2' ));

		woocommerce_form_field('user_school_city', array(
			'label'        => __( 'School Town / City', 'woocommerce' ),
			'required'     => true,
			'class'        => array( 'form-row-wide', 'address-field' ),
			),$checkout->get_value( 'user_school_city' ));

		woocommerce_form_field('user_school_state', array(
			'type'         => 'state',
			'label'        => __( 'School State / County', 'woocommerce' ),
			'required'     => true,
			'class'        => array( 'form-row-wide', 'address-field' ),
			'validate'     => array( 'state' ),
			'country'	   => $checkout->get_value( 'user_school_country' ),
			),$checkout->get_value( 'user_school_state' ));

		woocommerce_form_field('user_school_postcode', array(
			'label'        => __( 'School Postcode / ZIP', 'woocommerce' ),
			'required'     => true,
			'class'        => array( 'form-row-wide', 'address-field' ),
			'validate'     => array( 'postcode' ),
			),$checkout->get_value( 'user_school_postcode' ));

		woocommerce_form_field( 'user_school_phone', array(
        'type'          => 'text',
        'class'         => array('form-row-wide'),
        'label'         => __('School Phone'),
        ), $checkout->get_value( 'user_school_phone' ));

    echo '</div>';
}


/**
 * Update the order meta with field value
 */
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

function my_custom_checkout_field_update_order_meta( $order_id ) {

	$user_id = get_current_user_id();
	if ( isset($_POST['user_position']) ){
		update_user_meta($user_id, 'user_position', sanitize_text_field($_POST['user_position']));
		update_post_meta( $order_id, 'user_position', get_user_meta( $order->user_id, 'user_position', true ) );
  }

  if ( isset($_POST['user_school_email']) ){
    update_user_meta($user_id, 'user_school_email', sanitize_text_field($_POST['user_school_email']));
	update_post_meta( $order_id, 'user_school_email', get_user_meta( $order->user_id, 'user_school_email', true ) );
  }

  if ( isset($_POST['user_school_name']) ){
    update_user_meta($user_id, 'user_school_name', sanitize_text_field($_POST['user_school_name']));
	update_post_meta( $order_id, 'user_school_name', get_user_meta( $order->user_id, 'user_school_name', true ) );
  }
 	if ( isset($_POST['user_school_country']) ){
    update_user_meta($user_id, 'user_school_country', sanitize_text_field($_POST['user_school_country']));
	update_post_meta( $order_id, 'user_school_country', get_user_meta( $order->user_id, 'user_school_country', true ) );
  }
  if ( isset($_POST['user_school_addres']) ){
    update_user_meta($user_id, 'user_school_addres', sanitize_text_field($_POST['user_school_addres']));
	update_post_meta( $order_id, 'user_school_addres', get_user_meta( $order->user_id, 'user_school_addres', true ) );
  }
  if ( isset($_POST['user_school_addres_2']) ){
    update_user_meta($user_id, 'user_school_addres_2', sanitize_text_field($_POST['user_school_addres_2']));
	update_post_meta( $order_id, 'user_school_addres_2', get_user_meta( $order->user_id, 'user_school_addres_2', true ) );
  }
	if ( isset($_POST['user_school_city']) ){
    update_user_meta($user_id, 'user_school_city', sanitize_text_field($_POST['user_school_city']));
	update_post_meta( $order_id, 'user_school_city', get_user_meta( $order->user_id, 'user_school_city', true ) );
  }
  if ( isset($_POST['user_school_state']) ){
    update_user_meta($user_id, 'user_school_state', sanitize_text_field($_POST['user_school_state']));
	update_post_meta( $order_id, 'user_school_state', get_user_meta( $order->user_id, 'user_school_state', true ) );
  }
   if ( isset($_POST['user_school_postcode']) ){
    update_user_meta($user_id, 'user_school_postcode', sanitize_text_field($_POST['user_school_postcode']));
	update_post_meta( $order_id, 'user_school_postcode', get_user_meta( $order->user_id, 'user_school_postcode', true ) );
  }
  if ( isset($_POST['user_school_phone']) ){
    update_user_meta($user_id, 'user_school_phone', sanitize_text_field($_POST['user_school_phone']));
	update_post_meta( $order_id, 'user_school_phone', get_user_meta( $order->user_id, 'user_school_phone', true ) );

  }

  if ( isset($_POST['user_subject_taught']) ){
    update_user_meta($user_id, 'user_subject_taught', sanitize_text_field($_POST['user_subject_taught']));
	update_post_meta( $order_id, 'user_subject_taught', get_user_meta( $order->user_id, 'user_subject_taught', true ) );
  }
}

/**
 * Process the checkout
 */
add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

function my_custom_checkout_field_process() {
    // Check if set, if its not set add an error.
    if ( ! $_POST['user_position'] )
        wc_add_notice( __( 'Your Position field is required.' ), 'error' );
	if ( ! $_POST['user_school_email'] )
        wc_add_notice( __( 'Your School Email Address field is required.' ), 'error' );
	if ( ! $_POST['user_school_name'] )
			wc_add_notice( __( 'School Name field is required.' ), 'error' );
	if ( ! $_POST['user_subject_taught'] )
			wc_add_notice( __( 'Subject Taught field is required.' ), 'error' );

	if ( ! $_POST['user_school_country'] )
			wc_add_notice( __( 'School Country field is required.' ), 'error' );

	if ( ! $_POST['user_school_addres'] )
			wc_add_notice( __( 'School Address field is required.' ), 'error' );

	if ( ! $_POST['user_school_city'] )
			wc_add_notice( __( 'School City  field is required.' ), 'error' );

	if ( ! $_POST['user_school_state'] )
			wc_add_notice( __( 'School State field is required.' ), 'error' );

	if ( ! $_POST['user_school_postcode'] )
			wc_add_notice( __( 'School Postcode field is required.' ), 'error' );

}


add_action( 'woocommerce_save_account_details_errors','my_custom_checkout_field_process');
add_action( 'woocommerce_save_account_details', 'save_customer_meta_fields' );


add_action( 'woocommerce_edit_account_form', 'my_custom_account_details_field' );
function my_custom_account_details_field() {
$user_id = get_current_user_id();
    echo '<div id="my_custom_account_details_field"><h3>' . __('School Information') . '</h3>';
    woocommerce_form_field( 'user_position', array(
        'type'          => 'text',
        'class'         => array('form-row-wide'),
        'label'         => __('Your Position'),
        'required'		=> true
        ), get_user_meta( $user_id, 'user_position', true ));

		woocommerce_form_field( 'user_school_email', array(
        'type'          => 'text',
        'class'         => array('form-row-wide'),
        'label'         => __('Your School Email Address'),
        'required'		=> true
        ), get_user_meta( $user_id, 'user_school_email', true ));

		woocommerce_form_field( 'user_subject_taught', array(
        'type'          => 'select',
		'options' 		=> array(
						  'English' => 'English',
						  'Science' => 'Science',
						  'Social Studies' => 'Social Studies',
						  'Other' => 'Other'),
        'class'         => array('form-row-wide'),
        'label'         => __('Subject Taught'),
        'required'		=> true
        ), get_user_meta( $user_id, 'user_subject_taught', true ));

		woocommerce_form_field( 'user_school_name', array(
        'type'          => 'text',
        'class'         => array('form-row-wide'),
        'label'         => __('School Name'),
        'required'		=> true
        ), get_user_meta( $user_id, 'user_school_name', true ));

		woocommerce_form_field(	'user_school_country', array(
			'type'         => 'country',
			'label'        => __( 'School Country', 'woocommerce' ),
			'required'     => true,
			'class'        => array( 'form-row-wide', 'address-field', 'update_totals_on_change' ),
			'default' => 'US'
			),get_user_meta( $user_id, 'user_school_country', true ));

		woocommerce_form_field(	'user_school_addres', array(
			'label'        => __( 'School Address', 'woocommerce' ),
			'placeholder'  => esc_attr__( 'Street address', 'woocommerce' ),
			'required'     => true,
			'class'        => array( 'form-row-wide', 'address-field' ),
			),get_user_meta( $user_id, 'user_school_addres', true ));

		woocommerce_form_field('user_school_addres_2', array(
			'placeholder'  => esc_attr__( 'Apartment, suite, unit etc. (optional)', 'woocommerce' ),
			'class'        => array( 'form-row-wide', 'address-field' ),
			'required'     => false,
			),get_user_meta( $user_id, 'user_school_addres_2', true ));

		woocommerce_form_field('user_school_city', array(
			'label'        => __( 'School Town / City', 'woocommerce' ),
			'required'     => true,
			'class'        => array( 'form-row-wide', 'address-field' ),
			),get_user_meta( $user_id, 'user_school_city', true ));

		woocommerce_form_field('user_school_state', array(
			'type'         => 'state',
			'label'        => __( 'School State / County', 'woocommerce' ),
			'required'     => true,
			'class'        => array( 'form-row-wide', 'address-field' ),
			'validate'     => array( 'state' ),
			'country'	   => get_user_meta( $user_id, 'user_school_country', true ),
			),get_user_meta( $user_id, 'user_school_state', true ));

		woocommerce_form_field('user_school_postcode', array(
			'label'        => __( 'School Postcode / ZIP', 'woocommerce' ),
			'required'     => true,
			'class'        => array( 'form-row-wide', 'address-field' ),
			'validate'     => array( 'postcode' ),
			),get_user_meta( $user_id, 'user_school_postcode', true ));

		woocommerce_form_field( 'user_school_phone', array(
        'type'          => 'text',
        'class'         => array('form-row-wide'),
        'label'         => __('School Phone'),
        ), get_user_meta( $user_id, 'user_school_phone', true ));

    echo '</div>';
}


add_action( 'add_meta_boxes', 'add_meta_boxes' );

function add_meta_boxes()
{
    add_meta_box(
        'woocommerce-order-my-custom',
        __( 'School Information' ),
        'order_my_custom',
        'shop_order',
        'side',
        'default'
    );
}
function order_my_custom()
{
	global $woocommerce, $post;

	$order = new WC_Order($post->ID);
	$user_id = $order->user_id;
	?>
	<p class="form-row form-row-thirds">
      <label for="user_position">Position - </label> <?= get_user_meta( $user_id, 'user_position', true ); ?>
    </p>

    <p class="form-row form-row-thirds">
      <label for="user_school_email">School Email Address - </label> <?= get_user_meta( $user_id, 'user_school_email', true ); ?>
    </p>

	<p class="form-row form-row-thirds">
      <label for="user_subject_taught">Subject Taught - </label> <?= get_user_meta( $user_id, 'user_subject_taught', true ); ?>
    </p>

    <p class="form-row form-row-thirds">
      <label for="user_school_name">School Name - </label> <?= get_user_meta( $user_id, 'user_school_name', true ); ?>
    </p>

    <p class="form-row form-row-thirds">
      <label for="user_school_district">School Country - </label> <?= get_user_meta( $user_id, 'user_school_country', true ); ?>
    </p>

    <p class="form-row form-row-thirds">
      <label for="user_school_addres">School Address - </label> <?= get_user_meta( $user_id, 'user_school_addres', true ) .' '. get_user_meta( $user_id, 'user_school_addres_2', true ); ?>
    </p>
	<p class="form-row form-row-thirds">
      <label for="user_school_district">School City - </label> <?= get_user_meta( $user_id, 'user_school_city', true ); ?>
    </p>

    <p class="form-row form-row-thirds">
      <label for="user_school_addres">School State - </label> <?= get_user_meta( $user_id, 'user_school_state', true ); ?>
    </p>

	<p class="form-row form-row-thirds">
      <label for="user_school_district">School Postcode - </label> <?= get_user_meta( $user_id, 'user_school_postcode', true ); ?>
    </p>

    <p class="form-row form-row-thirds">
      <label for="user_school_phone">School Phone - </label> <?= get_user_meta( $user_id, 'user_school_phone', true ); ?>
    </p>


	<?php
}

/**
 * Add custom fields to emails
 */
add_filter('woocommerce_email_customer_details_fields', 'my_checkout_field_order_meta_fields', 40, 3 );
function my_checkout_field_order_meta_fields( $fields, $sent_to_admin, $order ) {
	$fields['user_position'] = array(
	'label' => __( 'Position' ),
	'value' => get_user_meta( $order->user_id, 'user_position', true ),
	);
	$fields['user_school_email'] = array(
	'label' => __( 'School Email Address' ),
	'value' => get_user_meta( $order->user_id, 'user_school_email', true ),
	);
	$fields['user_subject_taught'] = array(
    'label' => __( 'Subject Taught' ),
    'value' => get_user_meta( $order->user_id, 'user_subject_taught', true ),
	);
	$fields['user_school_name'] = array(
	'label' => __( 'School Name' ),
	'value' => get_user_meta( $order->user_id, 'user_school_name', true ),
	);

	$fields['user_school_country'] = array(
	'label'        => __( 'School Country', 'woocommerce' ),
	'value' => get_user_meta( $order->user_id, 'user_school_country', true ),
	);
	$fields['user_school_addres'] = array(
		'label'        => __( 'School Address', 'woocommerce' ),
		'value' => get_user_meta( $order->user_id, 'user_school_addres', true ) .' '. get_user_meta( $order->user_id, 'user_school_addres_2', true ),
	);
	$fields['user_school_city'] = array(
		'label'        => __( 'School Town / City', 'woocommerce' ),
		'value' => get_user_meta( $order->user_id, 'user_school_city', true ),
	);
	$fields['user_school_state'] = array(
		'label'        => __( 'School State / County', 'woocommerce' ),
		'value' => get_user_meta( $order->user_id, 'user_school_state', true ),
		);

	$fields['user_school_postcode'] = array(
			'label'        => __( 'School Postcode / ZIP', 'woocommerce' ),
			'value' => get_user_meta( $order->user_id, 'user_school_postcode', true ),
			);
	$fields['user_school_phone'] = array(
	'label' => __( 'School Phone' ),
	'value' => get_user_meta( $order->user_id, 'user_school_phone', true ),
	);


  return $fields;
}


/**
* Campos de School en los detalles de la orden
*/
add_action( 'woocommerce_order_details_after_customer_details', 'custom_field_display_cust_order_meta', 10, 1 );
function custom_field_display_cust_order_meta($order){
	echo '<table class="woocommerce-table woocommerce-table--customer-details shop_table customer_details">' ;
	echo '<tbody>';
    echo '<tr><th>'.__('Position').':</th><td>' . get_user_meta( $order->user_id, 'user_position', true ). '</td></tr>';
    echo '<tr><th>'.__('School Email Address').':</th><td> ' . get_user_meta( $order->user_id, 'user_school_email', true ). '</td></tr>';
	echo '<tr><th>'.__('Subject Taught').':</th><td> ' . get_user_meta( $order->user_id, 'user_subject_taught', true ). '</td></tr>';
	echo '<tr><th>'.__('School Name').':</th><td> ' . get_user_meta( $order->user_id, 'user_school_name', true ). '</td></tr>';
	echo '<tr><th>'.__('School Country').':</th><td> ' . get_user_meta( $order->user_id, 'user_school_country', true ). '</td></tr>';
	echo '<tr><th>'.__('School Address').':</th><td> ' . get_user_meta( $order->user_id, 'user_school_addres', true ) .' '. get_user_meta( $order->user_id, 'user_school_addres_2', true ). '</td></tr>';
	echo '<tr><th>'.__('School City').':</th><td> ' . get_user_meta( $order->user_id, 'user_school_city', true ). '</td></tr>';
	echo '<tr><th>'.__('School State').':</th><td> ' . get_user_meta( $order->user_id, 'user_school_state', true ). '</td></tr>';
	echo '<tr><th>'.__('School Postcode').':</th><td> ' . get_user_meta( $order->user_id, 'user_school_postcode', true ). '</td></tr>';
	echo '<tr><th>'.__('School Phone').':</th><td> ' . get_user_meta( $order->user_id, 'user_school_phone', true ). '</td></tr>';

	echo '</tbody></table>';
}



/**
* Campos de School en la confirmación de la orden
*/
// add_action( 'woocommerce_after_checkout_billing_form', 'custom_field_display_cust_order_meta', 10, 1 );


// Register Script
function country_select() {

	wp_deregister_script( 'wc-country-select' );
	wp_register_script( 'wc-country-select', '/wp-content/themes/applied-practice/js/country-select.min.js', false, '1.0', false );
	wp_enqueue_script( 'wc-country-select' );

}
add_action( 'wp_enqueue_scripts', 'country_select' );



//Hide Under 50 Category in Category Results
add_filter('get_terms', 'get_subcategory_terms', 10, 3);

function get_subcategory_terms($terms, $taxonomies, $args)
{
    $new_terms = array();
    // if a product category and on the shop page
    if (in_array('product_cat', $taxonomies) && !is_admin() && is_shop()) {
        foreach ($terms as $key => $term) {
            if (!in_array($term->slug, array(
                'under-50'
            ))) {
                $new_terms[] = $term;
            }

        }
        $terms = $new_terms;
    }
    return $terms;
}


//Hide Under 50 Category in Single Products
function get_modified_term_list($id = 0, $taxonomy, $before = '', $sep = '', $after = '', $exclude = array())
{

    $terms = get_the_terms($id, $taxonomy);

    if (is_wp_error($terms))
        return $terms;

    if (empty($terms))
        return false;

    foreach ($terms as $term) {

        if (!in_array($term->slug, $exclude)) {

            $link = get_term_link($term, $taxonomy);

            if (is_wp_error($link))
                return $link;

            $term_links[] = '<a href="' . $link . '" rel="tag">' . $term->name . '</a>';
        }
    }

    if (!isset($term_links))
        return false;

    return $before . join($sep, $term_links) . $after;

}

function wc_get_modified_product_category_list( $product_id, $sep = ', ', $before = '', $after = '' ) {
	return get_modified_term_list( $product_id, 'product_cat', $before, $sep, $after, array('under-50') );
}

add_action("gform_user_registered", 'autologin', 10, 4);
function autologin($user_id, $config, $entry, $password) {
    wp_set_auth_cookie($user_id, false, '');
}



add_action( 'woocommerce_cart_totals_before_shipping', 'custom_shipping_note' );
add_action( 'woocommerce_review_order_before_shipping', 'custom_shipping_note' );
function custom_shipping_note() {
  print '<tr><td colspan="2"><p style="text-align: center; font-weight: 700;">Print orders may take up to 3 business days for processing and printing before leaving our warehouse.</p></td></tr>'.PHP_EOL;
}

//REMOVE LATER -- HIDE CATEGORIES TEMPORARY
add_filter('get_terms', 'get_subcategory_terms_temp', 10, 4);

function get_subcategory_terms_temp($terms, $taxonomies, $args)
{
    $new_terms = array();
    // if a product category and on the shop page
    if (in_array('product_cat', $taxonomies)) {
        foreach ($terms as $key => $term) {
            if (!in_array($term->slug, array(
                '1984-for-sat', 'a-separate-peace-for-sat', 'adventures-of-huckleberry-finn-for-sat',
                'animal-farm-for-sat', 'brave-new-world-for-sat', 'fahrenheit-451-for-sat',
                'great-expectations-for-sat', 'julius-caesar-for-sat', 'romeo-and-juliet-for-sat',
                'the-catcher-in-the-rye-for-sat', 'the-grapes-of-wrath-for-sat', 'the-pearl-for-sat',
                'to-kill-a-mockingbird-for-sat'
            ))) {
                $new_terms[] = $term;
            }

        }
        $terms = $new_terms;
    }
    return $terms;
}



function my_api_dir( $dir ) {
    $upload = wp_upload_dir();
    return $upload['basedir'];
}
add_filter( 'ip-geo-block-api-dir', 'my_api_dir' );


// Splits all multi items
//
add_action( 'woocommerce_add_to_cart', 'mai_split_multiple_quantity_products_to_separate_cart_items', 10, 6 );
function mai_split_multiple_quantity_products_to_separate_cart_items( $cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data ) {

    // If product has more than 1 quantity
    if ( $quantity > 1 ) {

        // Keep the product but set its quantity to 1
        WC()->cart->set_quantity( $cart_item_key, 1 );

        // Run a loop 1 less than the total quantity
        for ( $i = 1; $i <= $quantity -1; $i++ ) {
            /**
             * Set a unique key.
             * This is what actually forces the product into its own cart line item
             */
            $cart_item_data['unique_key'] = md5( microtime() . rand() . "Hi Mom!" );

            // Add the product as a new line item with the same variations that were passed
            WC()->cart->add_to_cart( $product_id, 1, $variation_id, $variation, $cart_item_data );
        }

    }

}









function my_admin_scripts() {
	wp_enqueue_style('bootstrap-style','https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_script( 'bootstrap-script', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'));
}
add_action( 'admin_enqueue_scripts', 'my_admin_scripts' );


function custom_scripts() {
	global $post;

	$src = get_stylesheet_directory_uri() . '/inc/dynamic-repeater.js';
	// make this script dependent on acf-input
	$depends = array('acf-input');
	$handle = 'dsf-acf-extension';

	wp_register_script($handle, $src, array('jquery'), '10_5_f');

	$object = 'php_vars';

	$admin_url = admin_url('admin-ajax.php');
	
	$data = array(
		'post_id' => $post->ID,
		'admin_url' => $admin_url
	);

	wp_enqueue_script($handle);
	
	wp_localize_script($handle, $object, $data);
	
	
}

add_action ('wp_enqueue_scripts', 'custom_scripts', 20);

function add_query_vars_filter( $vars ){
  $vars[] = "id";
  return $vars;
}

add_filter( 'query_vars', 'add_query_vars_filter' );



// define the function to be fired for logged in users
function set_default_questions() {

	// nonce check for an extra layer of security, the function will exit if it fails
// 	if ( !wp_verify_nonce( $_REQUEST['nonce'], "set_default_questions_nonce")) {
// 		exit("Woof Woof Woof");
// 	}   

	// fetch refernce for a section (sent via jquery)
	$reference_id = $_REQUEST["reference_id"];
	
	$images = get_field('reference_images', $reference_id);
	$orig_default_questions = get_field('default_questions', $reference_id);
	$default_questions = array();
	
	foreach($orig_default_questions as &$question) {
		$myquestion = array(
			'ID' => $question->ID,
			'Question Text' => $question->post_content,
			'Question Title' => $question->post_title,
			'Possible Answers' => get_field('possible_answers', $question->ID),
			'Answer Reasoning' => get_field('answer_reasoning', $question->ID),
			'Learning Objectives' => get_field('learning_objectives', $quesiton->ID)
		);
		array_push($default_questions, $myquestion);
	}
	
	$data = array(
		'reference_id' => $reference_id,
		'images' => $images,
		'default_questions' => $default_questions
	);
	
	echo json_encode($data);

	// don't forget to end your scripts with a die() function - very important
	die();
}

// define the function to be fired for logged in users
function get_references() {

	$args = array(
		'posts_per_page'   => -1,
		'post_type'=> 'references',
		'orderby' => 'title',
		'order'    => 'ASC'
	);              
	
	$new_arr = array();

	$the_query = new WP_Query( $args );
	if($the_query->have_posts() ) : 
		while ( $the_query->have_posts() ) : 
		   $the_query->the_post(); 
	
			$myid = get_the_ID();
			$mytitle = get_the_title();
	
			$my_arr = array(
				'id' => $myid,
				'text' => $mytitle
			); 
			array_push($new_arr, $my_arr);
		   // content goes here
		endwhile; 
		wp_reset_postdata(); 
	else: 
	endif;
	
// 	$data = array(
// // 		'reference_id' => $reference_id
// 	);
	
	echo json_encode($new_arr);

	// don't forget to end your scripts with a die() function - very important
	die();
}

function delete_assessment() {
	$delete_post_id = $_REQUEST["post_to_delete"];
	wp_trash_post( $delete_post_id );
	
	die();
}
function new_assessment() {
	$user_info = wp_get_current_user();
	$author_part = $user_info->user_login . ' - '; 
        $title =  $author_part . $_REQUEST["mydata"]["title"];
        $description = $_REQUEST["mydata"]["intro"];
		$questions = $_REQUEST["mydata"]["questions"];
		$reference_id = $_REQUEST["mydata"]["reference_id"];
    // Add the content of the form to $post as an array
    $new_post = array(
        'post_title'    => $title,
        'post_status'   => 'publish',           // Choose: publish, preview, future, draft, etc.
        'post_type' => 'assessments'  //'post',page' or use a custom post type if you want to
    );
    //save the new post
    $pid = wp_insert_post($new_post); 
	
	$new_assessment_data = array();
	$new_assessment_data["title"] = $title;
	$new_assessment_data["intro"] = $description;
	$new_assessment_data["reference_id"] = $reference_id;
	$new_assessment_data["questions"] = $questions;
	
	update_field('brief_intro', $description, $pid);
	
	$repeater_key = 'field_5ee3af2d8ff6d'; // field key of 'sections' repeater
	
	$sections = array(); // push sections to this repeater
	
	$all_questions = array();
	
	foreach($questions as &$question) {
		$possible_answers = array();
		
		foreach($question["possible_answers"] as &$possible_answer) {
			$correct_answer = 0;
			if($possible_answer["is_checked"] == "true"){ 
				$correct_answer = 1; 
			}
			$an_answer = array(
				'field_5f568880d37b2' => $possible_answer["answer_text"],
				'field_5f568880d37b3' => $correct_answer
			);
			array_push($possible_answers, $an_answer);
		}
		
		$q_array = array(
			'field_5f568836d37ae' => $question["question_id"], //question id
			'field_5f568852d37af' => $question["question_text"], //question text
			'field_5f56889ed37b4' => $question["answer_reasoning"], //answer reasoning
			'field_5f5688a8d37b5' => $question["learning_objectives"], //learning objectives
			'field_5f568880d37b1' => $possible_answers //possible answers
		);
		
		array_push($all_questions, $q_array);
	}
	
	  // nested array for every row of repeater
	  $section = array(
		// field key => value pairs for each sub field
		'field_5ee3b2a78ff6f' => $reference_id, // reference field
		'field_5f56828ed37ad' => $all_questions
		// next row in nested repeater
	  );
	
	array_push($sections, $section);
	
	$new_assessment_data["all_questions"] = $all_questions;
	
	update_field($repeater_key, $sections, $pid);
	
	echo json_encode($new_assessment_data);
	
	// don't forget to end your scripts with a die() function - very important
	die();
}






// define the actions for the two hooks created, first for logged in users and the next for logged out users
add_action("wp_ajax_set_default_questions", "set_default_questions");
add_action("wp_ajax_get_references", "get_references");
add_action("wp_ajax_delete_assessment", "delete_assessment");
add_action("wp_ajax_new_assessment", "new_assessment");
add_action("wp_ajax_save_changes", "save_changes");

