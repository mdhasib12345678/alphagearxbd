<?php
/**
 * Page template for the "About" page (auto-applies to a page with slug "about").
 *
 * @package AlphaGearX_BD
 */

get_header();

$agx_feats = array(
	array( 'spark', __( 'Quality You Can Trust', 'alphagearx-bd' ), __( 'Every product is selected for durability and real-world performance — gear that holds up session after session.', 'alphagearx-bd' ) ),
	array( 'truck', __( 'Cash on Delivery', 'alphagearx-bd' ), __( 'Shop with confidence. Pay when your gear arrives, with fast delivery across Bangladesh and friendly support.', 'alphagearx-bd' ) ),
	array( 'box', __( 'Fair, Honest Pricing', 'alphagearx-bd' ), __( 'Premium does not have to mean expensive. Our Complete Kits help you save by bundling the essentials.', 'alphagearx-bd' ) ),
);
?>
<div class="agx-site">
	<section class="agx-page-hero">
		<div class="agx-wrap">
			<div class="agx-crumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'alphagearx-bd' ); ?></a><span class="sep">/</span><span class="cur"><?php esc_html_e( 'About', 'alphagearx-bd' ); ?></span></div>
			<span class="eyebrow"><?php esc_html_e( 'Who We Are', 'alphagearx-bd' ); ?></span>
			<h1><?php esc_html_e( 'About AlphaGearX BD', 'alphagearx-bd' ); ?></h1>
		</div>
	</section>

	<section class="sec-pad" style="padding-top:14px">
		<div class="agx-wrap">
			<p class="agx-lead reveal"><?php echo wp_kses_post( __( 'AlphaGearX BD started with one belief: <strong>everyone in Bangladesh deserves access to quality fitness gear</strong> — without inflated prices or guesswork. From strength training and yoga to recovery and complete home-gym kits, we curate durable, value-for-money equipment and deliver it to your door with <strong>Cash on Delivery</strong> nationwide.', 'alphagearx-bd' ) ); ?></p>
			<div class="agx-cards3">
				<?php
				foreach ( $agx_feats as $f ) {
					printf(
						'<div class="agx-card reveal"><div class="sic">%s</div><h3>%s</h3><p>%s</p></div>',
						agx_icon( $f[0] ), // phpcs:ignore
						esc_html( $f[1] ),
						esc_html( $f[2] )
					);
				}
				?>
			</div>
		</div>
	</section>
</div>
<?php
get_footer();
