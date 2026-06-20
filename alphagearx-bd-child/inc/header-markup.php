<?php
/**
 * Custom site header (glass nav, slim Shop dropdown, cart).
 * Hooked onto `astra_header` (replaces Astra's default header markup).
 *
 * @package AlphaGearX_BD
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Permalink to the WooCommerce shop page (with fallback). */
function agx_shop_url() {
	if ( function_exists( 'wc_get_page_permalink' ) ) {
		$url = wc_get_page_permalink( 'shop' );
		if ( $url ) {
			return $url;
		}
	}
	return home_url( '/shop/' );
}

/** Permalink to a page by slug (with graceful fallback). */
function agx_page_url( $slug ) {
	$page = get_page_by_path( $slug );
	return $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
}

/** Cart count markup (also used as an AJAX fragment). */
function agx_cart_count_html() {
	$count = 0;
	if ( function_exists( 'WC' ) && WC()->cart ) {
		$count = WC()->cart->get_cart_contents_count();
	}
	$zero = $count > 0 ? '' : ' zero';
	return '<span class="agx-count agx-cart-count' . $zero . '">' . esc_html( $count ) . '</span>';
}

/**
 * Render the header.
 */
function agx_header_markup() {
	$is_shop = function_exists( 'is_woocommerce' ) && ( is_shop() || is_product() || is_product_category() || is_product_tag() );
	?>
	<div class="agx-promo" data-rotate>
		<span class="agx-promo-msg"><?php echo wp_kses_post( __( 'Free delivery over <strong>৳2000</strong> across Bangladesh', 'alphagearx-bd' ) ); ?></span>
		<span class="agx-promo-msg" style="display:none"><?php echo wp_kses_post( __( '<strong>Cash on Delivery</strong> · order by phone or online', 'alphagearx-bd' ) ); ?></span>
	</div>

	<div class="agx-header">
		<div class="agx-wrap">
			<nav class="agx-nav" aria-label="<?php esc_attr_e( 'Primary', 'alphagearx-bd' ); ?>">

				<a class="agx-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php
					if ( has_custom_logo() ) {
						$logo_id = get_theme_mod( 'custom_logo' );
						echo wp_get_attachment_image( $logo_id, 'medium', false, array( 'alt' => get_bloginfo( 'name' ) ) );
					} else {
						echo '<span class="agx-logo">AG</span><span>AlphaGearX BD</span>';
					}
					?>
				</a>

				<ul class="agx-menu" id="agx-menu">
					<li class="agx-shop">
						<a class="agx-link <?php echo $is_shop ? 'active' : ''; ?>" href="<?php echo esc_url( agx_shop_url() ); ?>">
							<?php esc_html_e( 'Shop', 'alphagearx-bd' ); ?> <?php echo agx_icon( 'caret' ); // phpcs:ignore ?>
						</a>
						<div class="agx-dropdown">
							<div class="agx-cat-list">
								<?php
								$terms = get_terms(
									array(
										'taxonomy'   => 'product_cat',
										'hide_empty' => false,
										'exclude'    => array( get_option( 'default_product_cat' ) ),
										'orderby'    => 'menu_order',
									)
								);
								if ( ! is_wp_error( $terms ) && $terms ) {
									foreach ( $terms as $term ) {
										$kit = ( 'complete-kits' === $term->slug ) ? ' kit' : '';
										printf(
											'<a class="%1$s" href="%2$s">%3$s%4$s</a>',
											esc_attr( 'cat' . $kit ),
											esc_url( get_term_link( $term ) ),
											agx_icon( agx_cat_icon( $term->slug ) ), // phpcs:ignore
											esc_html( $term->name )
										);
									}
								}
								?>
								<a class="viewall" href="<?php echo esc_url( agx_shop_url() ); ?>"><?php esc_html_e( 'View All Products', 'alphagearx-bd' ); ?></a>
							</div>
							<a class="agx-feat" href="<?php echo esc_url( get_term_link( 'complete-kits', 'product_cat' ) ); ?>">
								<img src="<?php echo esc_url( AGX_URI . '/assets/products/kit-full.png' ); ?>" alt="<?php esc_attr_e( 'Complete Kits', 'alphagearx-bd' ); ?>">
								<span><?php esc_html_e( 'Best Value', 'alphagearx-bd' ); ?></span>
								<strong><?php esc_html_e( 'Complete Kits', 'alphagearx-bd' ); ?></strong>
							</a>
						</div>
					</li>
					<li><a class="agx-link <?php echo is_page( 'learn' ) ? 'active' : ''; ?>" href="<?php echo esc_url( agx_page_url( 'learn' ) ); ?>"><?php esc_html_e( 'Learn', 'alphagearx-bd' ); ?></a></li>
					<li><a class="agx-link <?php echo is_page( 'about' ) ? 'active' : ''; ?>" href="<?php echo esc_url( agx_page_url( 'about' ) ); ?>"><?php esc_html_e( 'About', 'alphagearx-bd' ); ?></a></li>
					<li><a class="agx-link <?php echo is_page( 'contact' ) ? 'active' : ''; ?>" href="<?php echo esc_url( agx_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Contact', 'alphagearx-bd' ); ?></a></li>
				</ul>

				<div class="agx-actions">
					<a class="agx-icbtn agx-icon-search" href="<?php echo esc_url( home_url( '/?post_type=product&s=' ) ); ?>" aria-label="<?php esc_attr_e( 'Search', 'alphagearx-bd' ); ?>"><?php echo agx_icon( 'search' ); // phpcs:ignore ?></a>
					<a class="agx-icbtn agx-cart" href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart/' ) ); ?>" aria-label="<?php esc_attr_e( 'Cart', 'alphagearx-bd' ); ?>">
						<?php echo agx_icon( 'cart' ); // phpcs:ignore ?>
						<?php echo agx_cart_count_html(); // phpcs:ignore ?>
					</a>
					<div class="agx-hamb" id="agx-hamb" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Menu', 'alphagearx-bd' ); ?>"><span></span><span></span><span></span></div>
				</div>

			</nav>
		</div>
	</div>
	<?php
}
