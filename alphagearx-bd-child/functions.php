<?php
/**
 * AlphaGearX BD — Astra child theme functions.
 *
 * @package AlphaGearX_BD
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'AGX_VER', '1.0.0' );
define( 'AGX_DIR', get_stylesheet_directory() );
define( 'AGX_URI', get_stylesheet_directory_uri() );

/* -------------------------------------------------------------------------
 * Assets
 * ---------------------------------------------------------------------- */
function agx_enqueue_assets() {
	// Google fonts.
	wp_enqueue_style(
		'agx-fonts',
		'https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap',
		array(),
		null
	);

	// Astra parent stylesheet.
	wp_enqueue_style( 'astra-parent', get_template_directory_uri() . '/style.css', array(), AGX_VER );

	// Child theme stylesheet (required header file).
	wp_enqueue_style( 'agx-style', get_stylesheet_uri(), array( 'astra-parent' ), AGX_VER );

	// Main theme styles + scripts.
	wp_enqueue_style( 'agx-main', AGX_URI . '/assets/css/main.css', array( 'agx-style' ), AGX_VER );
	wp_enqueue_script( 'agx-main', AGX_URI . '/assets/js/main.js', array(), AGX_VER, true );
}
add_action( 'wp_enqueue_scripts', 'agx_enqueue_assets', 20 );

/* -------------------------------------------------------------------------
 * Theme setup
 * ---------------------------------------------------------------------- */
function agx_setup() {
	// WooCommerce support + gallery features.
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus(
		array(
			'agx_primary' => __( 'Primary Menu', 'alphagearx-bd' ),
			'agx_footer'  => __( 'Footer Menu', 'alphagearx-bd' ),
		)
	);
}
add_action( 'after_setup_theme', 'agx_setup' );

// Mark the body so our scoped CSS applies.
function agx_body_class( $classes ) {
	$classes[] = 'agx';
	return $classes;
}
add_filter( 'body_class', 'agx_body_class' );

/* -------------------------------------------------------------------------
 * Full-width (page-builder) layout on the storefront + custom templates,
 * so Astra's container/sidebar doesn't fight our design.
 * ---------------------------------------------------------------------- */
function agx_full_width_layout( $layout ) {
	if (
		is_front_page()
		|| is_page_template( 'page-contact.php' )
		|| ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) )
	) {
		return 'page-builder';
	}
	return $layout;
}
add_filter( 'astra_get_content_layout', 'agx_full_width_layout' );

// Hide Astra's page title where we render our own hero.
function agx_disable_title( $enabled ) {
	if ( is_front_page() || ( function_exists( 'is_woocommerce' ) && ( is_shop() || is_product() || is_product_category() ) ) ) {
		return false;
	}
	return $enabled;
}
add_filter( 'astra_the_title_enabled', 'agx_disable_title' );

/* -------------------------------------------------------------------------
 * Replace Astra header & footer with our own markup (hook-based — no need
 * to copy Astra's complex header.php / footer.php).
 * ---------------------------------------------------------------------- */
require_once AGX_DIR . '/inc/header-markup.php';
require_once AGX_DIR . '/inc/footer-markup.php';
require_once AGX_DIR . '/inc/woo-tweaks.php';
require_once AGX_DIR . '/inc/customizer-hero.php';

function agx_swap_chrome() {
	remove_action( 'astra_header', 'astra_header_markup' );
	add_action( 'astra_header', 'agx_header_markup' );

	remove_action( 'astra_footer', 'astra_footer_markup' );
	add_action( 'astra_footer', 'agx_footer_markup' );
}
// `wp` runs after Astra has registered its header/footer (on init) and before any
// template renders the `astra_header` / `astra_footer` actions — robust across versions.
add_action( 'wp', 'agx_swap_chrome' );

// Animated neon background + grain, output once just inside <body>.
function agx_background_markup() {
	echo '<div class="agx-bg" aria-hidden="true"><span class="neon n1"></span><span class="neon n2"></span><span class="neon n3"></span><span class="neon n4"></span></div><div class="agx-grain" aria-hidden="true"></div>';
}
add_action( 'wp_body_open', 'agx_background_markup', 1 );

/* -------------------------------------------------------------------------
 * Shared helpers
 * ---------------------------------------------------------------------- */

/**
 * Icon map: WooCommerce product-category slug => inline SVG symbol id.
 * Categories are matched by slug; fall back to a generic bag.
 */
function agx_cat_icon( $slug ) {
	$map = array(
		'strength-training' => 'dumbbell',
		'yoga-flexibility'  => 'lotus',
		'recovery-support'  => 'heart',
		'home-workout'      => 'house',
		'gym-accessories'   => 'bag',
		'complete-kits'     => 'box',
	);
	return isset( $map[ $slug ] ) ? $map[ $slug ] : 'bag';
}

/** Output an inline SVG icon by name. */
function agx_icon( $name ) {
	$paths = array(
		'arrow'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
		'caret'    => '<path d="M6 9l6 6 6-6"/>',
		'lotus'    => '<path d="M12 21c-5 0-9-2.5-9-2.5s1.5-4.5 5.5-4.5M12 21c5 0 9-2.5 9-2.5s-1.5-4.5-5.5-4.5M12 21c0-4 .5-8 3-11M12 21c0-4-.5-8-3-11M12 21V9"/>',
		'dumbbell' => '<path d="M2 12h2M20 12h2M5 8.5v7M19 8.5v7M8 10v4M16 10v4M8 12h8"/>',
		'heart'    => '<path d="M12 20s-7-4.6-9.3-9C1 7.5 3 4.5 6.2 4.5c2 0 3.2 1.2 3.8 2.3C10.6 5.7 11.8 4.5 13.8 4.5 17 4.5 19 7.5 17.3 11 15 15.4 12 20 12 20z"/>',
		'house'    => '<path d="M3 11l9-7 9 7M5 10v10h14V10"/>',
		'bag'      => '<path d="M6 7h12l1 13H5zM9 7a3 3 0 0 1 6 0"/>',
		'box'      => '<path d="M3 8l9-5 9 5v8l-9 5-9-5zM3 8l9 5 9-5M12 13v9"/>',
		'search'   => '<circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/>',
		'cart'     => '<circle cx="9" cy="20" r="1.4"/><circle cx="18" cy="20" r="1.4"/><path d="M2 3h3l2.4 12.4a1 1 0 0 0 1 .8h8.7a1 1 0 0 0 1-.8L21 7H6"/>',
		'truck'    => '<path d="M3 6h11v9H3zM14 9h4l3 3v3h-7zM7 18a1.6 1.6 0 1 0 0-3.2A1.6 1.6 0 0 0 7 18zM18 18a1.6 1.6 0 1 0 0-3.2 1.6 1.6 0 0 0 0 3.2z"/>',
		'shield'   => '<path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/>',
		'refresh'  => '<path d="M3 12a9 9 0 0 1 15-6.7L21 8M21 3v5h-5M21 12a9 9 0 0 1-15 6.7L3 16M3 21v-5h5"/>',
		'phone'    => '<path d="M5 3h4l2 5-2.5 1.5a11 11 0 0 0 5 5L20 17l-2 4a16 16 0 0 1-13-13z"/>',
		'mail'     => '<path d="M3 6h18v12H3zM3 7l9 6 9-6"/>',
		'pin'      => '<path d="M12 21s-7-6-7-11a7 7 0 0 1 14 0c0 5-7 11-7 11zM12 12a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>',
		'spark'    => '<path d="M12 3v18M3 12h18M6 6l12 12M18 6L6 18" stroke-width="1.2"/>',
		'flame'    => '<path d="M12 3c1 4 5 5 5 9a5 5 0 0 1-10 0c0-2 1-3 2-4 .4 1.8 2 1.8 2 0 0-2-1-3-1-5z"/>',
	);
	$p = isset( $paths[ $name ] ) ? $paths[ $name ] : $paths['arrow'];
	return '<svg class="icn" viewBox="0 0 24 24" aria-hidden="true">' . $p . '</svg>';
}

/** Star rating string (filled stars, simple). */
function agx_stars() {
	return '<span class="stars">★★★★★</span>';
}
