<?php
/**
 * Bestsellers — up to 8 products (featured first, then top-selling/recent).
 *
 * @package AlphaGearX_BD
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wc_get_template_part' ) ) {
	return; // WooCommerce inactive.
}

// Featured products first.
$agx_q = new WP_Query(
	array(
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'posts_per_page'      => 8,
		'ignore_sticky_posts' => true,
		'meta_key'            => 'total_sales', // phpcs:ignore WordPress.DB.SlowDBQuery
		'orderby'             => array(
			'menu_order' => 'ASC',
			'meta_value_num' => 'DESC',
			'date'       => 'DESC',
		),
		'tax_query'           => array( // phpcs:ignore WordPress.DB.SlowDBQuery
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'exclude-from-catalog',
				'operator' => 'NOT IN',
			),
		),
	)
);

if ( ! $agx_q->have_posts() ) {
	wp_reset_postdata();
	return;
}
?>
<section class="sec-pad" style="padding-top:24px">
	<div class="agx-wrap">
		<div class="sec-head reveal">
			<span class="eyebrow"><?php esc_html_e( 'Most Popular', 'alphagearx-bd' ); ?></span>
			<h2><?php esc_html_e( 'Bestsellers', 'alphagearx-bd' ); ?></h2>
		</div>

		<ul class="products agx-grid">
			<?php
			while ( $agx_q->have_posts() ) {
				$agx_q->the_post();
				wc_get_template_part( 'content', 'product' );
			}
			?>
		</ul>
		<?php wp_reset_postdata(); ?>

		<div style="text-align:center;margin-top:44px" class="reveal">
			<a class="btn btn-primary" href="<?php echo esc_url( agx_shop_url() ); ?>"><?php esc_html_e( 'View All Products', 'alphagearx-bd' ); ?></a>
		</div>
	</div>
</section>
