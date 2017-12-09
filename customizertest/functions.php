<?php

add_action( 'wp_enqueue_scripts', 'cd_assets' );
function cd_assets() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700' );
}

add_filter( 'show_admin_bar', '__return_false' );

add_action( 'after_setup_theme', 'cd_setup' );
function cd_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

}

/**
*
 * The code for the customiser starts here
 *
 */
add_action( 'customize_register', 'cd_customizer_settings' );

/**
 *
 * Sets up the visible fields in the customiser and registers the settings and the controls
 *
 */
function cd_customizer_settings( $wp_customize ) {

  $wp_customize->add_section( 'cd_colors' , array(
      'title'      => 'Colors',
      'priority'   => 30,
  ) );

  $wp_customize->add_setting( 'background_color' , array(
    'default'     => '#43C6E4',
    'transport'   => 'refresh',
  ) );

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
    'label'        => 'Background Color',
    'section'    => 'cd_colors',
    'settings'   => 'background_color',
  ) ) );

}

/**
 *
 * Applies the settings to our theme
 *
 */
add_action( 'wp_head', 'cd_customizer_css');
function cd_customizer_css()
{
    ?>
         <style type="text/css">
             body { background: #<?php echo get_theme_mod('background_color', '#43C6E4'); ?>; }
         </style>
    <?php
}
