<?php
/**
 * Hero image slider (responsive, desktop/mobile sources).
 *
 * @package AlphaGearX_BD
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$agx_slides = function_exists( 'agx_get_hero_slides' ) ? agx_get_hero_slides() : array();
if ( empty( $agx_slides ) ) {
	return;
}
?>
<section class="agx-hero" aria-label="<?php esc_attr_e( 'Featured', 'alphagearx-bd' ); ?>">
	<div class="agx-slides">
		<?php foreach ( $agx_slides as $i => $s ) : ?>
			<div class="agx-slide<?php echo 0 === $i ? ' active' : ''; ?>">
				<picture>
					<?php if ( ! empty( $s['mobile'] ) ) : ?>
						<source media="(max-width:767px)" srcset="<?php echo esc_url( $s['mobile'] ); ?>">
					<?php endif; ?>
					<img src="<?php echo esc_url( $s['img'] ); ?>"
						alt="<?php echo esc_attr( $s['heading'] ? $s['heading'] : get_bloginfo( 'name' ) ); ?>"
						<?php echo 0 === $i ? 'fetchpriority="high"' : 'loading="lazy"'; ?>>
				</picture>

				<?php if ( $s['heading'] || $s['sub'] || ( $s['btn_text'] && $s['btn_link'] ) ) : ?>
					<div class="agx-wrap agx-slide-cap has-text">
						<?php if ( $s['heading'] ) : ?><h2><?php echo esc_html( $s['heading'] ); ?></h2><?php endif; ?>
						<?php if ( $s['sub'] ) : ?><p><?php echo esc_html( $s['sub'] ); ?></p><?php endif; ?>
						<?php if ( $s['btn_text'] && $s['btn_link'] ) : ?>
							<a class="btn btn-primary" href="<?php echo esc_url( $s['btn_link'] ); ?>"><?php echo esc_html( $s['btn_text'] ); ?></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>

		<?php if ( count( $agx_slides ) > 1 ) : ?>
			<button class="agx-arrow prev" type="button" aria-label="<?php esc_attr_e( 'Previous slide', 'alphagearx-bd' ); ?>"><?php echo agx_icon( 'arrow' ); // phpcs:ignore ?></button>
			<button class="agx-arrow next" type="button" aria-label="<?php esc_attr_e( 'Next slide', 'alphagearx-bd' ); ?>"><?php echo agx_icon( 'arrow' ); // phpcs:ignore ?></button>
			<div class="agx-dots"></div>
		<?php endif; ?>
	</div>
</section>
