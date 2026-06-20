<?php
/**
 * Custom site footer. Hooked onto `astra_footer`.
 *
 * @package AlphaGearX_BD
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function agx_footer_markup() {
	?>
	<footer class="agx-footer">
		<div class="agx-wrap">
			<div class="agx-fcols">

				<div class="agx-fcol">
					<div class="agx-fbrand">
						<?php
						if ( has_custom_logo() ) {
							$logo_id = get_theme_mod( 'custom_logo' );
							echo wp_get_attachment_image( $logo_id, 'thumbnail', false, array( 'alt' => get_bloginfo( 'name' ) ) );
						} else {
							echo '<span class="agx-logo">AG</span><span>AlphaGearX BD</span>';
						}
						?>
					</div>
					<p><?php esc_html_e( 'Premium yoga & gym gear for Bangladesh. Quality equipment, fair prices, and Cash on Delivery nationwide.', 'alphagearx-bd' ); ?></p>
					<div class="agx-social">
						<a href="#" aria-label="Facebook">f</a>
						<a href="#" aria-label="Instagram">ig</a>
						<a href="#" aria-label="WhatsApp">wa</a>
					</div>
				</div>

				<div class="agx-fcol">
					<h5><?php esc_html_e( 'Shop', 'alphagearx-bd' ); ?></h5>
					<?php
					$terms = get_terms(
						array(
							'taxonomy'   => 'product_cat',
							'hide_empty' => false,
							'exclude'    => array( get_option( 'default_product_cat' ) ),
							'number'     => 6,
						)
					);
					if ( ! is_wp_error( $terms ) && $terms ) {
						foreach ( $terms as $term ) {
							printf( '<a href="%s">%s</a>', esc_url( get_term_link( $term ) ), esc_html( $term->name ) );
						}
					}
					?>
				</div>

				<div class="agx-fcol">
					<h5><?php esc_html_e( 'Help', 'alphagearx-bd' ); ?></h5>
					<a href="<?php echo esc_url( agx_page_url( 'contact' ) ); ?>"><?php esc_html_e( 'Contact Us', 'alphagearx-bd' ); ?></a>
					<a href="<?php echo esc_url( agx_page_url( 'learn' ) ); ?>"><?php esc_html_e( 'Tips & Guides', 'alphagearx-bd' ); ?></a>
					<a href="<?php echo esc_url( function_exists( 'wc_get_account_endpoint_url' ) ? wc_get_account_endpoint_url( 'orders' ) : home_url( '/my-account/' ) ); ?>"><?php esc_html_e( 'Track Order', 'alphagearx-bd' ); ?></a>
					<a href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart/' ) ); ?>"><?php esc_html_e( 'Cart', 'alphagearx-bd' ); ?></a>
				</div>

				<div class="agx-fcol">
					<h5><?php esc_html_e( 'Stay in the loop', 'alphagearx-bd' ); ?></h5>
					<p><?php esc_html_e( 'New arrivals & offers, no spam.', 'alphagearx-bd' ); ?></p>
					<form class="agx-newsletter" action="#" method="post" onsubmit="return false">
						<input type="email" placeholder="<?php esc_attr_e( 'Email address', 'alphagearx-bd' ); ?>" aria-label="<?php esc_attr_e( 'Email address', 'alphagearx-bd' ); ?>">
						<button type="submit"><?php esc_html_e( 'Join', 'alphagearx-bd' ); ?></button>
					</form>
				</div>

			</div>
			<div class="agx-fbar">
				<?php
				printf(
					/* translators: %s: year */
					esc_html__( '© %s AlphaGearX BD. All rights reserved. · Cash on Delivery across Bangladesh.', 'alphagearx-bd' ),
					esc_html( gmdate( 'Y' ) )
				);
				?>
			</div>
		</div>
	</footer>
	<?php
}
