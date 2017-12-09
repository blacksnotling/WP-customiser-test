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

  /** elements for setting up the colour section **/
  $wp_customize->add_section( 'cd_colors' , array(
      'title'      => 'Coluors',
      'priority'   => 30,
  ) );

  $wp_customize->add_setting( 'background_color' , array(
    'default'     => '#43C6E4',
    'transport'   => 'postMessage', //allows live refresh
  ) );

  $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
    'label'        => 'Background Color',
    'section'    => 'cd_colors',
    'settings'   => 'background_color',
  ) ) );

  $wp_customize->add_section( 'cd_button' , array(
    'title'      => 'The Button',
    'priority'   => 20,
) );

  /** elements for setting up the button **/
  $wp_customize->add_setting( 'cd_button_display' , array(
    'default'     => true,
    'transport'   => 'postMessage',
  ) );

  $wp_customize->add_control( 'cd_button_display', array(
    'label' => 'Button Display',
    'section' => 'cd_button',
    'settings' => 'cd_button_display',
    'type' => 'radio',
    'choices' => array(
      'show' => 'Show Button',
      'hide' => 'Hide Button',
    ),
  ) );

  //Allows the button text to be changed
  $wp_customize->add_setting( 'cd_button_text' , array(
    'default'     => 'Come On In',
    'transport'   => 'postMessage',
  ) );

  $wp_customize->add_control( 'cd_button_text', array(
    'label' => 'Button Text',
    'section'	=> 'cd_button',
    'type'	 => 'text',
  ) );

  //Prevents the whole page from being unloaded when we hide/show the button.
  //Uses callback function cd_show_main_button
  $wp_customize->selective_refresh->add_partial( 'cd_button_display', array(
    'selector' => '#button-container',
    'render_callback' => 'cd_show_main_button',
  ) );

  /** Creates a slider using the class at the bottom of the function **/
  $wp_customize->add_setting( 'cd_photocount' , array(
    'default'     => 0,
    'transport'   => 'postMessage',
  ) );

  $wp_customize->add_control( new WP_Customize_Range( $wp_customize, 'cd_photocount', array(
    'label'	=>  'Photo Count',
    'min' => 10,
    'max' => 9999,
    'step' => 10,
    'section' => 'title_tagline',
  ) ) );

  /** Enables live preview for default elements **/
  $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
  $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

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

/**
 *
 * Enqueue's a JS file to enable live preview
 *
 */
add_action( 'customize_preview_init', 'cd_customizer' );
function cd_customizer() {
	wp_enqueue_script(
		  'cd_customizer',
		  get_template_directory_uri() . '/assets/customizer.js',
		  array( 'jquery','customize-preview' ),
		  '',
		  true
	);
}

/**
 *
 * Code to display "the button"
 *
 */
function cd_show_main_button() {
    if( get_theme_mod( 'cd_button_display', 'show' ) == 'show' ) {
        echo "<a href='' class='button'>" . get_theme_mod( 'cd_button_text', 'Come On In' ) . "</a>";
    }
}

/**
 *
 * Implements a class to add a slide to the customiser
 *
 */
 if( class_exists( 'WP_Customize_Control' ) ) {
	class WP_Customize_Range extends WP_Customize_Control {
		public $type = 'range';

        public function __construct( $manager, $id, $args = array() ) {
            parent::__construct( $manager, $id, $args );
            $defaults = array(
                'min' => 0,
                'max' => 10,
                'step' => 1
            );
            $args = wp_parse_args( $args, $defaults );

            $this->min = $args['min'];
            $this->max = $args['max'];
            $this->step = $args['step'];
        }

		public function render_content() {
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<input class='range-slider' min="<?php echo $this->min ?>" max="<?php echo $this->max ?>" step="<?php echo $this->step ?>" type='range' <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" oninput="jQuery(this).next('input').val( jQuery(this).val() )">
            <input onKeyUp="jQuery(this).prev('input').val( jQuery(this).val() )" type='text' value='<?php echo esc_attr( $this->value() ); ?>'>

		</label>
		<?php
		}
	}
}
