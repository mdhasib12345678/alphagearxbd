<?php
/**
 * Trust strip — 3 slim text items (no images).
 *
 * @package AlphaGearX_BD
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$agx_trust = array(
	array( 'truck', __( 'Cash on Delivery', 'alphagearx-bd' ) ),
	array( 'shield', __( 'Free Delivery over ৳2000', 'alphagearx-bd' ) ),
	array( 'refresh', __( '7-Day Easy Return', 'alphagearx-bd' ) ),
);
?>
<section class="sec-pad--tight">
	<div class="agx-wrap">
		<div class="agx-trust reveal">
			<?php
			foreach ( $agx_trust as $t ) {
				printf( '<div class="item">%s<span>%s</span></div>', agx_icon( $t[0] ), esc_html( $t[1] ) ); // phpcs:ignore
			}
			?>
		</div>
	</div>
</section>
