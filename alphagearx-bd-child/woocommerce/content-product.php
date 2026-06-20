<?php
/**
 * Product card in the loop — reproduces the AlphaGearX BD card design.
 * Override of woocommerce/content-product.php
 *
 * @package AlphaGearX_BD
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$cat_terms = get_the_terms( $product->get_id(), 'product_cat' );
$cat_name  = '';
$is_kit    = false;
if ( $cat_terms && ! is_wp_error( $cat_terms ) ) {
	$cat_name = $cat_terms[0]->name;
	foreach ( $cat_terms as $t ) {
		if ( 'complete-kits' === $t->slug ) {
			$is_kit = true;
		}
	}
}
$review_count = $product->get_review_count();
$rating       = (float) $product->get_average_rating();
?>
<li <?php wc_product_class( $is_kit ? 'is-kit' : '', $product ); ?>>
	<div class="pcard<?php echo $is_kit ? ' kit' : ''; ?>">
		<a class="pthumb" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( $product->get_name() ); ?>">
			<?php
			if ( $product->is_on_sale() ) {
				echo '<span class="pbadge">' . esc_html__( 'Sale', 'alphagearx-bd' ) . '</span>';
			} elseif ( $product->is_featured() ) {
				echo '<span class="pbadge' . ( $is_kit ? ' kit' : '' ) . '">' . ( $is_kit ? esc_html__( 'Kit', 'alphagearx-bd' ) : esc_html__( 'New', 'alphagearx-bd' ) ) . '</span>';
			}
			?>
			<span class="pfav" data-fav="<?php echo esc_attr( $product->get_id() ); ?>" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Add to favourites', 'alphagearx-bd' ); ?>"><?php echo agx_icon( 'heart' ); // phpcs:ignore ?></span>
			<?php echo $product->get_image( 'woocommerce_thumbnail' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</a>

		<?php if ( $cat_name ) : ?>
			<span class="pcat"><?php echo esc_html( $cat_name ); ?></span>
		<?php endif; ?>

		<h3><a href="<?php the_permalink(); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h3>

		<div class="prating">
			<?php
			echo agx_stars(); // phpcs:ignore
			if ( $review_count > 0 ) {
				echo ' ' . esc_html( number_format( $rating, 1 ) ) . ' (' . esc_html( $review_count ) . ')';
			}
			?>
		</div>

		<div class="price-row"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>

		<?php
		woocommerce_template_loop_add_to_cart(
			array(
				'class' => 'shop-btn add-btn button',
			)
		);
		?>
	</div>
</li>
