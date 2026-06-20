<?php
/**
 * Shop by Goal — single row of 4 intent tiles linking to category archives.
 *
 * @package AlphaGearX_BD
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$agx_goals = array(
	array(
		'title' => __( 'Build Muscle', 'alphagearx-bd' ),
		'img'   => 'goal-build-muscle.png',
		'cat'   => 'strength-training',
	),
	array(
		'title' => __( 'Increase Flexibility', 'alphagearx-bd' ),
		'img'   => 'goal-flexibility.png',
		'cat'   => 'yoga-flexibility',
	),
	array(
		'title' => __( 'Train at Home', 'alphagearx-bd' ),
		'img'   => 'goal-train-home.png',
		'cat'   => 'home-workout',
	),
	array(
		'title' => __( 'Recover & Support', 'alphagearx-bd' ),
		'img'   => 'goal-recover.png',
		'cat'   => 'recovery-support',
	),
);
?>
<section class="sec-pad">
	<div class="agx-wrap">
		<div class="sec-head reveal">
			<span class="eyebrow"><?php esc_html_e( 'Find Your Path', 'alphagearx-bd' ); ?></span>
			<h2><?php esc_html_e( 'Shop by Your Goal', 'alphagearx-bd' ); ?></h2>
		</div>
		<div class="agx-goals reveal">
			<?php
			foreach ( $agx_goals as $g ) {
				$term = get_term_by( 'slug', $g['cat'], 'product_cat' );
				$link = ( $term && ! is_wp_error( $term ) ) ? get_term_link( $term ) : agx_shop_url();
				printf(
					'<a class="agx-goal" href="%1$s"><img src="%2$s" alt="%3$s" loading="lazy"><h4>%3$s</h4><span class="glink">%4$s %5$s</span></a>',
					esc_url( $link ),
					esc_url( AGX_URI . '/assets/img/goals/' . $g['img'] ),
					esc_html( $g['title'] ),
					esc_html__( 'Shop Gear', 'alphagearx-bd' ),
					agx_icon( 'arrow' ) // phpcs:ignore
				);
			}
			?>
		</div>
	</div>
</section>
