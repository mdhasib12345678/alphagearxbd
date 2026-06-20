<?php
/**
 * Hero Slider — Customizer panel.
 * Lets the client swap hero images (desktop + mobile), captions and CTAs without code.
 *
 * @package AlphaGearX_BD
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Bundled default desktop banners (slides 1-3). */
function agx_hero_default_img( $i ) {
	$d = array(
		1 => 'slide-1-desktop.jpg',
		2 => 'slide-2-desktop.jpg',
		3 => 'slide-3-desktop.jpg',
	);
	return isset( $d[ $i ] ) ? AGX_URI . '/assets/img/hero/' . $d[ $i ] : '';
}

/** Collected hero slides (only those with a desktop image set). */
function agx_get_hero_slides() {
	$slides = array();
	for ( $i = 1; $i <= 5; $i++ ) {
		$img = get_theme_mod( "agx_hero_slide{$i}_img", agx_hero_default_img( $i ) );
		if ( empty( $img ) ) {
			continue;
		}
		$slides[] = array(
			'img'      => $img,
			'mobile'   => get_theme_mod( "agx_hero_slide{$i}_img_mobile", '' ),
			'heading'  => get_theme_mod( "agx_hero_slide{$i}_heading", '' ),
			'sub'      => get_theme_mod( "agx_hero_slide{$i}_sub", '' ),
			'btn_text' => get_theme_mod( "agx_hero_slide{$i}_btn_text", '' ),
			'btn_link' => get_theme_mod( "agx_hero_slide{$i}_btn_link", '' ),
		);
	}
	return $slides;
}

add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_section(
		'agx_hero',
		array(
			'title'       => __( 'Hero Slider', 'alphagearx-bd' ),
			'priority'    => 30,
			'description' => __( 'Up to 5 slides. Set a desktop image (required) and an optional mobile image per slide. Leave heading empty if the banner already contains text.', 'alphagearx-bd' ),
		)
	);

	for ( $i = 1; $i <= 5; $i++ ) {
		$default_img = agx_hero_default_img( $i );

		// Desktop image.
		$wp_customize->add_setting(
			"agx_hero_slide{$i}_img",
			array(
				'default'           => $default_img,
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				"agx_hero_slide{$i}_img",
				array(
					'label'   => sprintf( /* translators: %d slide number */ __( 'Slide %d — Desktop image', 'alphagearx-bd' ), $i ),
					'section' => 'agx_hero',
				)
			)
		);

		// Mobile image.
		$wp_customize->add_setting(
			"agx_hero_slide{$i}_img_mobile",
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				"agx_hero_slide{$i}_img_mobile",
				array(
					'label'   => sprintf( /* translators: %d slide number */ __( 'Slide %d — Mobile image (optional)', 'alphagearx-bd' ), $i ),
					'section' => 'agx_hero',
				)
			)
		);

		// Heading.
		$wp_customize->add_setting( "agx_hero_slide{$i}_heading", array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( "agx_hero_slide{$i}_heading", array(
			'label'   => sprintf( __( 'Slide %d — Heading (optional)', 'alphagearx-bd' ), $i ),
			'section' => 'agx_hero',
			'type'    => 'text',
		) );

		// Subheading.
		$wp_customize->add_setting( "agx_hero_slide{$i}_sub", array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( "agx_hero_slide{$i}_sub", array(
			'label'   => sprintf( __( 'Slide %d — Subheading (optional)', 'alphagearx-bd' ), $i ),
			'section' => 'agx_hero',
			'type'    => 'text',
		) );

		// Button text.
		$wp_customize->add_setting( "agx_hero_slide{$i}_btn_text", array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
		$wp_customize->add_control( "agx_hero_slide{$i}_btn_text", array(
			'label'   => sprintf( __( 'Slide %d — Button text (optional)', 'alphagearx-bd' ), $i ),
			'section' => 'agx_hero',
			'type'    => 'text',
		) );

		// Button link.
		$wp_customize->add_setting( "agx_hero_slide{$i}_btn_link", array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
		$wp_customize->add_control( "agx_hero_slide{$i}_btn_link", array(
			'label'   => sprintf( __( 'Slide %d — Button link (optional)', 'alphagearx-bd' ), $i ),
			'section' => 'agx_hero',
			'type'    => 'url',
		) );
	}
} );
