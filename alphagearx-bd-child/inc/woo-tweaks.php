<?php
/**
 * WooCommerce integration tweaks for AlphaGearX BD.
 *
 * @package AlphaGearX_BD
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ---- Catalog: per page + grid class + branded placeholder ---- */
add_filter( 'loop_shop_per_page', function () {
	return 12;
} );

add_filter( 'woocommerce_product_loop_start', function ( $html ) {
	if ( false === strpos( $html, 'agx-grid' ) ) {
		$html = str_replace( 'class="products', 'class="products agx-grid', $html );
	}
	return $html;
} );

add_filter( 'woocommerce_placeholder_img_src', function () {
	return AGX_URI . '/assets/products/placeholder.png';
} );

// Related products: 4 across.
add_filter( 'woocommerce_output_related_products_args', function ( $args ) {
	$args['posts_per_page'] = 4;
	$args['columns']        = 4;
	return $args;
} );

// Remove WooCommerce's default breadcrumb (our templates render their own).
add_action( 'init', function () {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
} );

/* ---- Live cart count fragment (updates the header badge after AJAX add) ---- */
add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
	$fragments['span.agx-cart-count'] = agx_cart_count_html();
	return $fragments;
} );

/* ---- Single product: category eyebrow + COD trust line ---- */
add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	if ( ! $product ) {
		return;
	}
	$terms = get_the_terms( $product->get_id(), 'product_cat' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		echo '<span class="agx-pcat">' . esc_html( $terms[0]->name ) . '</span>';
	}
}, 4 );

add_action( 'woocommerce_single_product_summary', function () {
	echo '<div class="agx-trustline">' . agx_icon( 'truck' ) // phpcs:ignore
		. '<span>' . esc_html__( 'Cash on Delivery · Delivery 2–4 days across Bangladesh', 'alphagearx-bd' ) . '</span></div>';
}, 35 );

/* ---- Checkout: simplified, Bangladesh + COD friendly ---- */
add_filter( 'default_checkout_billing_country', function () {
	return 'BD';
} );

add_filter( 'woocommerce_checkout_fields', function ( $fields ) {
	// Trim fields we don't need for a simple COD store.
	unset( $fields['billing']['billing_company'] );
	unset( $fields['billing']['billing_last_name'] );
	unset( $fields['billing']['billing_address_2'] );

	if ( isset( $fields['billing']['billing_first_name'] ) ) {
		$fields['billing']['billing_first_name']['label'] = __( 'Full Name', 'alphagearx-bd' );
		$fields['billing']['billing_first_name']['class'] = array( 'form-row-wide' );
		$fields['billing']['billing_first_name']['priority'] = 10;
	}
	if ( isset( $fields['billing']['billing_phone'] ) ) {
		$fields['billing']['billing_phone']['label']    = __( 'Mobile Number', 'alphagearx-bd' );
		$fields['billing']['billing_phone']['required'] = true;
		$fields['billing']['billing_phone']['priority'] = 20;
		$fields['billing']['billing_phone']['placeholder'] = __( '01XXXXXXXXX', 'alphagearx-bd' );
	}
	if ( isset( $fields['billing']['billing_email'] ) ) {
		$fields['billing']['billing_email']['required'] = false;
		$fields['billing']['billing_email']['priority'] = 25;
	}
	if ( isset( $fields['billing']['billing_address_1'] ) ) {
		$fields['billing']['billing_address_1']['label']       = __( 'Full Address', 'alphagearx-bd' );
		$fields['billing']['billing_address_1']['placeholder'] = __( 'House / Road / Village', 'alphagearx-bd' );
		$fields['billing']['billing_address_1']['priority']    = 30;
	}
	if ( isset( $fields['billing']['billing_city'] ) ) {
		$fields['billing']['billing_city']['label']    = __( 'Area / Thana', 'alphagearx-bd' );
		$fields['billing']['billing_city']['priority'] = 40;
	}
	if ( isset( $fields['billing']['billing_state'] ) ) {
		$fields['billing']['billing_state']['label']    = __( 'District', 'alphagearx-bd' );
		$fields['billing']['billing_state']['priority'] = 50;
	}
	if ( isset( $fields['billing']['billing_postcode'] ) ) {
		$fields['billing']['billing_postcode']['required'] = false;
		$fields['billing']['billing_postcode']['priority'] = 60;
	}
	return $fields;
} );

/* ---- Make the whole homepage / shop feel cohesive: 3 columns handled by CSS grid ---- */
add_filter( 'loop_shop_columns', function () {
	return 3;
} );

/* ---- "Add to Bag" button text everywhere ---- */
add_filter( 'woocommerce_product_add_to_cart_text', function ( $text, $product ) {
	return ( $product && $product->is_purchasable() && $product->is_in_stock() ) ? __( 'Add to Bag', 'alphagearx-bd' ) : $text;
}, 10, 2 );
add_filter( 'woocommerce_product_single_add_to_cart_text', function () {
	return __( 'Add to Bag', 'alphagearx-bd' );
} );

/* ---- Self-contained shop filters (work without any extra plugin) ----
 * Supports ?min_price, ?max_price and ?on_sale=1 query args used by our filter rail. */
add_action( 'woocommerce_product_query', function ( $q ) {
	if ( is_admin() ) {
		return;
	}

	// Price range.
	$has_min = isset( $_GET['min_price'] ) && '' !== $_GET['min_price']; // phpcs:ignore WordPress.Security.NonceVerification
	$has_max = isset( $_GET['max_price'] ) && '' !== $_GET['max_price']; // phpcs:ignore WordPress.Security.NonceVerification
	if ( $has_min || $has_max ) {
		$min  = $has_min ? floatval( wp_unslash( $_GET['min_price'] ) ) : 0; // phpcs:ignore WordPress.Security.NonceVerification
		$max  = $has_max ? floatval( wp_unslash( $_GET['max_price'] ) ) : PHP_INT_MAX; // phpcs:ignore WordPress.Security.NonceVerification
		$meta = (array) $q->get( 'meta_query' );
		$meta[] = array(
			'key'     => '_price',
			'value'   => array( $min, $max ),
			'compare' => 'BETWEEN',
			'type'    => 'NUMERIC',
		);
		$q->set( 'meta_query', $meta );
	}

	// On sale (intersect with any existing post__in so it respects other constraints).
	if ( isset( $_GET['on_sale'] ) && function_exists( 'wc_get_product_ids_on_sale' ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		$ids      = wc_get_product_ids_on_sale();
		$ids      = ! empty( $ids ) ? $ids : array( 0 );
		$existing = $q->get( 'post__in' );
		$existing = is_array( $existing ) ? array_filter( $existing ) : array();
		$q->set( 'post__in', ! empty( $existing ) ? array_intersect( $existing, $ids ) : $ids );
	}
} );

/**
 * Minimal shop filter rail (Category / Price / Offers) — plugin-free.
 * Used by woocommerce/archive-product.php.
 */
function agx_shop_filter_rail() {
	$get_min = isset( $_GET['min_price'] ) ? sanitize_text_field( wp_unslash( $_GET['min_price'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	$get_max = isset( $_GET['max_price'] ) ? sanitize_text_field( wp_unslash( $_GET['max_price'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	$on_sale = isset( $_GET['on_sale'] ); // phpcs:ignore WordPress.Security.NonceVerification

	$base = ( function_exists( 'is_product_category' ) && is_product_category() )
		? get_term_link( get_queried_object() )
		: agx_shop_url();
	if ( is_wp_error( $base ) ) {
		$base = agx_shop_url();
	}
	$current_cat = ( function_exists( 'is_product_category' ) && is_product_category() ) ? get_queried_object_id() : 0;

	// --- Category ---
	echo '<div class="group"><h4>' . esc_html__( 'Category', 'alphagearx-bd' ) . '</h4><ul>';
	printf(
		'<li><a class="%1$s" href="%2$s">%3$s</a></li>',
		esc_attr( $current_cat ? '' : 'active' ),
		esc_url( agx_shop_url() ),
		esc_html__( 'All Products', 'alphagearx-bd' )
	);
	$terms = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => true,
			'exclude'    => array( get_option( 'default_product_cat' ) ),
		)
	);
	if ( ! is_wp_error( $terms ) ) {
		foreach ( $terms as $t ) {
			printf(
				'<li><a class="%1$s" href="%2$s">%3$s</a></li>',
				esc_attr( $t->term_id === $current_cat ? 'active' : '' ),
				esc_url( get_term_link( $t ) ),
				esc_html( $t->name )
			);
		}
	}
	echo '</ul></div>';

	// --- Price ---
	$ranges = array(
		array( __( 'Under ৳500', 'alphagearx-bd' ), '', '500' ),
		array( __( '৳500 – ৳1000', 'alphagearx-bd' ), '500', '1000' ),
		array( __( '৳1000 – ৳2000', 'alphagearx-bd' ), '1000', '2000' ),
		array( __( 'Over ৳2000', 'alphagearx-bd' ), '2000', '' ),
	);
	echo '<div class="group"><h4>' . esc_html__( 'Price', 'alphagearx-bd' ) . '</h4><ul>';
	foreach ( $ranges as $r ) {
		$args = array();
		if ( '' !== $r[1] ) {
			$args['min_price'] = $r[1];
		}
		if ( '' !== $r[2] ) {
			$args['max_price'] = $r[2];
		}
		$active = ( ! $on_sale && $get_min === $r[1] && $get_max === $r[2] && ( '' !== $get_min || '' !== $get_max ) ) ? 'active' : '';
		printf(
			'<li><a class="%1$s" href="%2$s">%3$s</a></li>',
			esc_attr( $active ),
			esc_url( add_query_arg( $args, remove_query_arg( array( 'min_price', 'max_price', 'on_sale' ), $base ) ) ),
			esc_html( $r[0] )
		);
	}
	printf(
		'<li><a href="%s">%s</a></li>',
		esc_url( remove_query_arg( array( 'min_price', 'max_price' ), $base ) ),
		esc_html__( 'All prices', 'alphagearx-bd' )
	);
	echo '</ul></div>';

	// --- Offers ---
	echo '<div class="group"><h4>' . esc_html__( 'Offers', 'alphagearx-bd' ) . '</h4><ul>';
	printf(
		'<li><a class="%1$s" href="%2$s">%3$s</a></li>',
		esc_attr( $on_sale ? 'active' : '' ),
		esc_url( add_query_arg( 'on_sale', '1', remove_query_arg( array( 'min_price', 'max_price' ), $base ) ) ),
		esc_html__( 'On Sale', 'alphagearx-bd' )
	);
	echo '</ul></div>';
}

