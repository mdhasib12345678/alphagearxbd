<?php
/**
 * Page template for the "Contact" page (auto-applies to a page with slug "contact").
 * Left: contact details. Right: the page content (drop a Contact Form 7 / WPForms
 * shortcode here) — falls back to a simple styled form if the page is empty.
 *
 * @package AlphaGearX_BD
 */

get_header();
?>
<div class="agx-site">
	<section class="agx-page-hero">
		<div class="agx-wrap">
			<div class="agx-crumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'alphagearx-bd' ); ?></a><span class="sep">/</span><span class="cur"><?php esc_html_e( 'Contact', 'alphagearx-bd' ); ?></span></div>
			<span class="eyebrow"><?php esc_html_e( 'Get in Touch', 'alphagearx-bd' ); ?></span>
			<h1><?php esc_html_e( 'Contact Us', 'alphagearx-bd' ); ?></h1>
			<p><?php esc_html_e( 'Questions about an order or a product? We are here to help.', 'alphagearx-bd' ); ?></p>
		</div>
	</section>

	<section class="sec-pad" style="padding-top:14px">
		<div class="agx-wrap">
			<div class="agx-contact">
				<div class="info reveal">
					<p><?php echo agx_icon( 'phone' ); // phpcs:ignore ?><span><?php esc_html_e( 'Phone: +880 1XXX-XXXXXX', 'alphagearx-bd' ); ?></span></p>
					<p><?php echo agx_icon( 'phone' ); // phpcs:ignore ?><span><?php esc_html_e( 'WhatsApp: +880 1XXX-XXXXXX', 'alphagearx-bd' ); ?></span></p>
					<p><?php echo agx_icon( 'mail' ); // phpcs:ignore ?><span><?php esc_html_e( 'Email: hello@alphagearxbd.com', 'alphagearx-bd' ); ?></span></p>
					<p><?php echo agx_icon( 'pin' ); // phpcs:ignore ?><span><?php esc_html_e( 'Dhaka, Bangladesh', 'alphagearx-bd' ); ?></span></p>
					<p style="margin-top:18px;color:var(--violet-soft)"><?php echo agx_icon( 'truck' ); // phpcs:ignore ?><span><?php esc_html_e( 'Cash on Delivery across Bangladesh', 'alphagearx-bd' ); ?></span></p>
				</div>

				<div class="form reveal">
					<?php
					while ( have_posts() ) {
						the_post();
						$agx_content = trim( get_the_content() );
						if ( '' !== $agx_content ) {
							// Render page content (e.g. a Contact Form 7 shortcode).
							the_content();
						} else {
							// Fallback styled form (connect to a form plugin to make it send).
							?>
							<form action="#" method="post" onsubmit="return false">
								<input type="text" name="agx_name" placeholder="<?php esc_attr_e( 'Your name', 'alphagearx-bd' ); ?>" aria-label="<?php esc_attr_e( 'Your name', 'alphagearx-bd' ); ?>">
								<input type="text" name="agx_phone" placeholder="<?php esc_attr_e( 'Mobile number', 'alphagearx-bd' ); ?>" aria-label="<?php esc_attr_e( 'Mobile number', 'alphagearx-bd' ); ?>">
								<textarea name="agx_msg" placeholder="<?php esc_attr_e( 'How can we help?', 'alphagearx-bd' ); ?>" aria-label="<?php esc_attr_e( 'Message', 'alphagearx-bd' ); ?>"></textarea>
								<button type="submit" class="btn btn-primary"><?php esc_html_e( 'Send Message', 'alphagearx-bd' ); ?></button>
							</form>
							<p style="color:var(--muted);font-size:13px;margin-top:10px"><?php esc_html_e( 'Tip: add a Contact Form 7 or WPForms shortcode to this page to make the form send.', 'alphagearx-bd' ); ?></p>
							<?php
						}
					}
					?>
				</div>
			</div>
		</div>
	</section>
</div>
<?php
get_footer();
