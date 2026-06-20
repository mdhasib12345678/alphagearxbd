<?php
/**
 * Shop / category archive — slim page hero + filter rail + product grid.
 * Override of woocommerce/archive-product.php
 *
 * @package AlphaGearX_BD
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$agx_title = woocommerce_page_title( false );
$agx_is_cat = is_product_category() || is_product_tag();
?>
<div class="agx-site">

	<section class="agx-page-hero">
		<div class="agx-wrap">
			<div class="agx-crumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'alphagearx-bd' ); ?></a>
				<span class="sep">/</span>
				<?php if ( $agx_is_cat ) : ?>
					<a href="<?php echo esc_url( agx_shop_url() ); ?>"><?php esc_html_e( 'Shop', 'alphagearx-bd' ); ?></a>
					<span class="sep">/</span><span class="cur"><?php echo esc_html( $agx_title ); ?></span>
				<?php else : ?>
					<span class="cur"><?php esc_html_e( 'Shop', 'alphagearx-bd' ); ?></span>
				<?php endif; ?>
			</div>
			<h1><?php echo esc_html( $agx_title ); ?></h1>
			<?php
			if ( is_product_category() ) {
				$agx_term = get_queried_object();
				if ( $agx_term && ! empty( $agx_term->description ) ) {
					echo '<p>' . wp_kses_post( wp_trim_words( wp_strip_all_tags( $agx_term->description ), 28 ) ) . '</p>';
				}
			} else {
				echo '<p>' . esc_html__( 'Premium yoga & gym gear — everything you need to train, recover and stay consistent.', 'alphagearx-bd' ) . '</p>';
			}
			?>
		</div>
	</section>

	<section class="sec-pad" style="padding-top:6px">
		<div class="agx-wrap">
			<div class="agx-shop-layout">

				<aside class="agx-filter">
					<?php agx_shop_filter_rail(); ?>
				</aside>

				<div class="agx-shop-main">
					<div class="agx-shop-bar">
						<?php woocommerce_result_count(); ?>
						<?php woocommerce_catalog_ordering(); ?>
					</div>

					<?php
					if ( woocommerce_product_loop() ) {

						woocommerce_product_loop_start();

						if ( wc_get_loop_prop( 'total' ) ) {
							while ( have_posts() ) {
								the_post();
								wc_get_template_part( 'content', 'product' );
							}
						}

						woocommerce_product_loop_end();

						do_action( 'woocommerce_after_shop_loop' );

					} else {
						echo '<p class="empty">' . esc_html__( 'No products found here yet — check back soon.', 'alphagearx-bd' ) . '</p>';
					}
					?>
				</div>

			</div>
		</div>
	</section>

</div>
<?php
get_footer();
