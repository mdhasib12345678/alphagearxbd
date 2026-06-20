<?php
/**
 * Front page (homepage) — lean storefront landing.
 *
 * @package AlphaGearX_BD
 */

get_header();
?>
<div class="agx-site">
	<?php
	get_template_part( 'template-parts/hero-slider' );
	get_template_part( 'template-parts/shop-by-goal' );
	get_template_part( 'template-parts/bestsellers' );
	get_template_part( 'template-parts/trust-strip' );
	?>
</div>
<?php
get_footer();
