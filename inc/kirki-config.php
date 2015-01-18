<?php
/**
 * The configuration options for the Shoestrap Customizer
 */
function shoestrap_customizer_config() {

	$args = array(

		// Change the logo image. (URL)
		// If omitted, the default theme info will be displayed.
		// A good size for the logo is 250x50.
		//'logo_image'   => get_template_directory_uri() . '/assets/img/logo.png',

		// The color of active menu items, help bullets etc.
		//'color_active' => '#1abc9c',

		// Color used for secondary elements and desable/inactive controls
		//'color_light'  => '#8cddcd',

		// Color used for button-set controls and other elements
		//'color_select' => '#34495e',

		// Color used on slider controls and image selects
		//'color_accent' => '#FF5740',

		// The generic background color.
		// You should choose a dark color here as we're using white for the text color.
		//'color_back'   => '#222',

		// If Kirki is embedded in your theme, then you can use this line to specify its location.
		// This will be used to properly enqueue the necessary stylesheets and scripts.
		// If you are using kirki as a plugin then please delete this line.
		'url_path'     => get_template_directory_uri() . '/inc/kirki/',

		// If you want to take advantage of the backround control's 'output',
		// then you'll have to specify the ID of your stylesheet here.
		// The "ID" of your stylesheet is its "handle" on the wp_enqueue_style() function.
		// http://codex.wordpress.org/Function_Reference/wp_enqueue_style
		// 'stylesheet_id' => 'shoestrap',

		);

return $args;

}
add_filter( 'kirki/config', 'shoestrap_customizer_config' );



/**
 * Create the section
 */
function blogberry_section( $wp_customize ) {


	// Create Sections
	$wp_customize->add_section( 'intro', array(
		'title'    => __( 'Introduction Text', 'blogberry' ),
		'priority' => 20
		) );
	$wp_customize->add_section( 'thumbnail', array(
		'title'    => __( 'Featured Image', 'blogberry' ),
		'priority' => 80
		) );
	$wp_customize->add_section( 'footer', array(
		'title'    => __( 'Footer Text', 'blogberry' ),
		'priority' => 90
		) );




	// Register the setting
	$wp_customize->add_setting( 'border', array(
		'default'        => '',
		'type'           => 'theme_mod',
		'capability'     => 'edit_theme_options',
		) );

	$wp_customize->add_setting( 'bg', array(
		'default'        => '',
		'type'           => 'theme_mod',
		'capability'     => 'edit_theme_options',
		) );

	$wp_customize->add_setting( 'postpic', array(
		'default'        => '',
		'type'           => 'theme_mod',
		'capability'     => 'edit_theme_options',
		) );

	$wp_customize->add_setting( 'main-color', array(
		'default'        => '#68944a',
		'type'           => 'theme_mod',
		'capability'     => 'edit_theme_options',
		) );


	$wp_customize->add_setting( 'side-color', array(
		'default'        => '#fff',
		'type'           => 'theme_mod',
		'capability'     => 'edit_theme_options',
		) );


	$wp_customize->add_setting( 'footer', array(
		'default'        => '',
		'type'           => 'theme_mod',
		'capability'     => 'edit_theme_options',
		) );

	$wp_customize->add_setting( 'copyright', array(
		'default'        => '',
		'type'           => 'theme_mod',
		'capability'     => 'edit_theme_options',
		) );		

}
add_action( 'customize_register', 'blogberry_section' );


function blogberry_setting( $controls ) {


	$controls[] = array(
		'type'     => 'multicheck',
		'setting'  => 'bordered',
		'label'    => __( 'Image Border', 'blogberry' ),
		'section'  => 'header_image',
		'default'  => '',
		'priority' => 1,
		'choices'  => array(
			'option_1' => __( 'Add Border', 'blogberry' ),
			),
		);

	$introtext = __('<h1>Intro area, introduce yourself here.</h1><h3>You can use HTML (H1-H6) to adjust text size.</h3><h4>And change other options with Customizer: Click Here!</h4>', 'blogberry');
	$controls[] = array(
		'type'     => 'textarea',
		'setting'  => 'intro-text',
		'label'    => __( 'Text on Home Page', 'blogberry' ),
		'section'  => 'intro',
		'default'  => __( $introtext, 'blogberry' ),
		'priority' => 5,
		);

	$controls[] = array(
		'type'     => 'image',
		'setting'  => 'postpic',
		'label'    => __( 'Default (Blank) Featured Image', 'blogberry' ),
		'section'  => 'thumbnail',
		'default'  => get_template_directory_uri() . '/img/thumb.jpg',
		'priority' => 1,
		);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'main-color',
		'label'    => __( 'Main Color (Links &amp; Intro Background) ', 'blogberry' ),
		'section'  => 'colors', // section api default wordpress
		'default'  => '#68944a',
		'priority' => 1,
		);


	$controls[] = array(
		'type'     => 'select',
		'setting'  => 'side-color',
		'label'    => __( 'Side Text Color', 'blogberry' ),
		'section'  => 'colors',
		'default'  => '#000',
		'priority' => 11,
		'choices'  => array(
			'#000' => __( 'Black', 'blogberry' ),
			'#fff' => __( 'White', 'blogberry' ),
			),
		);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'copyright',
		'label'    => __( 'Copyright', 'blogberry' ),
		'section'  => 'footer',
		'default'  => '&copy; '. date("Y") . ' ' . get_bloginfo('name') . ', all rights reserved.',
		'priority' => 1,
		);


	return $controls;
}
add_filter( 'kirki/controls', 'blogberry_setting' );

?>