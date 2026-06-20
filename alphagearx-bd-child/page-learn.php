<?php
/**
 * Page template for the "Learn" page (auto-applies to a page with slug "learn").
 *
 * @package AlphaGearX_BD
 */

get_header();

$agx_guides = array(
	array( 'dumbbell', __( 'Master Your Lifting Form', 'alphagearx-bd' ), __( 'How a proper belt, wrist straps and barbell pad protect your joints and unlock heavier, safer lifts — the foundation of every strength journey.', 'alphagearx-bd' ) ),
	array( 'house', __( 'Build a Home Workout Routine', 'alphagearx-bd' ), __( 'No gym? No problem. Set up an effective routine with a pull-up bar, resistance bands and hand grips — train anywhere, anytime in Bangladesh.', 'alphagearx-bd' ) ),
	array( 'heart', __( 'Recover Faster After Training', 'alphagearx-bd' ), __( 'Foam rollers, knee support and ankle straps reduce soreness and prevent injury. The recovery habits that keep you training consistently.', 'alphagearx-bd' ) ),
);
?>
<div class="agx-site">
	<section class="agx-page-hero">
		<div class="agx-wrap">
			<div class="agx-crumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'alphagearx-bd' ); ?></a><span class="sep">/</span><span class="cur"><?php esc_html_e( 'Learn', 'alphagearx-bd' ); ?></span></div>
			<span class="eyebrow"><?php esc_html_e( 'Tips & Guides', 'alphagearx-bd' ); ?></span>
			<h1><?php esc_html_e( 'Learn', 'alphagearx-bd' ); ?></h1>
			<p><?php esc_html_e( 'Practical guides to help you train smarter, recover faster and get the most from your gear.', 'alphagearx-bd' ); ?></p>
		</div>
	</section>

	<section class="sec-pad" style="padding-top:14px">
		<div class="agx-wrap">
			<div class="agx-cards3">
				<?php
				foreach ( $agx_guides as $g ) {
					printf(
						'<div class="agx-card reveal"><div class="sic">%s</div><h3>%s</h3><p>%s</p></div>',
						agx_icon( $g[0] ), // phpcs:ignore
						esc_html( $g[1] ),
						esc_html( $g[2] )
					);
				}
				?>
			</div>
		</div>
	</section>
</div>
<?php
get_footer();
