<?php

/**
 * Create the section
 */
function my_custom_section( $wp_customize ) {

	// Create the "Main" section
	$wp_customize->add_section( 'main', array(
		'title'    => __( 'Logo Setting', 'blogberry' ),
		'priority' => 1
		) );

	// Create the "Addtional" section
	$wp_customize->add_section( 'intro', array(
		'title'    => __( 'Intro Background Setting', 'blogberry' ),
		'priority' => 2
		) );

	// Create the "Addtional" section
	$wp_customize->add_section( 'default', array(
		'title'    => __( 'Default Thumbnail', 'blogberry' ),
		'priority' => 3
		) );

	// Create the "Addtional" section
	$wp_customize->add_section( 'footer', array(
		'title'    => __( 'Text Footer', 'blogberry' ),
		'priority' => 4
		) );

	// Register the setting
	$wp_customize->add_setting( 'logo', array(
		'default'        => '',
		'type'           => 'theme_mod',
		'capability'     => 'edit_theme_options',
		) );

	// Register the setting
	$wp_customize->add_setting( 'uploads', array(
		'default'        => '',
		'type'           => 'theme_mod',
		'capability'     => 'edit_theme_options',
		) );

	// Register the setting
	$wp_customize->add_setting( 'border', array(
		'default'        => '',
		'type'           => 'theme_mod',
		'capability'     => 'edit_theme_options',
		) );

// Register the setting
	$wp_customize->add_setting( 'bg', array(
		'default'        => '',
		'type'           => 'theme_mod',
		'capability'     => 'edit_theme_options',
		) );

	// Register the setting
	$wp_customize->add_setting( 'text', array(
		'default'        => '',
		'type'           => 'theme_mod',
		'capability'     => 'edit_theme_options',
		) );


	// Register the setting
	$wp_customize->add_setting( 'postpic', array(
		'default'        => '',
		'type'           => 'theme_mod',
		'capability'     => 'edit_theme_options',
		) );

	// Register the setting
	$wp_customize->add_setting( 'color', array(
		'default'        => '#68944a',
		'type'           => 'theme_mod',
		'capability'     => 'edit_theme_options',
		) );		


// Footer Section

	// Register the setting
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
add_action( 'customize_register', 'my_custom_section' );


function my_custom_setting( $controls ) {

	$controls[] = array(
		'type'     => 'multicheck',
		'setting'  => 'logo',
		'label'    => __( 'Main Setting', 'blogberry' ),
		'section'  => 'main',
		'default'  => '',
		'priority' => 1,
		'choices'  => array(
			'option_1' => __( 'Logo / Avatar', 'blogberry' ),
			),
		);

	$controls[] = array(
		'type'     => 'image',
		'setting'  => 'uploads',
		'label'    => __( 'Logo Upload', 'blogberry' ),
		'section'  => 'main',
		'default'  => '',
		'priority' => 2,
		);


	$controls[] = array(
		'type'     => 'multicheck',
		'setting'  => 'bordered',
		'label'    => __( 'Logo Border', 'blogberry' ),
		'section'  => 'main',
		'default'  => '',
		'priority' => 3,
		'choices'  => array(
			'option_1' => __( 'Border', 'blogberry' ),
			),
		);


	$controls[] = array(
		'type'     => 'image',
		'setting'  => 'bg',
		'label'    => __( 'Intro Background', 'blogberry' ),
		'section'  => 'intro',
		'default'  => '',
		'priority' => 4,
		);

	$controls[] = array(
		'type'     => 'textarea',
		'setting'  => 'text',
		'label'    => __( 'Intro Text', 'blogberry' ),
		'section'  => 'intro',
		'default'  => __( 'Default text', 'blogberry' ),
		'priority' => 5,
		);

	$controls[] = array(
		'type'     => 'image',
		'setting'  => 'postpic',
		'label'    => __( 'Default Post Thumbnail', 'blogberry' ),
		'section'  => 'default',
		'default'  => '',
		'priority' => 1,
		);

	$controls[] = array(
		'type'     => 'color',
		'setting'  => 'color',
		'label'    => __( 'Link Color', 'blogberry' ),
		'section'  => 'colors', // section api default wordpress
		'default'  => '#68944a',
		'priority' => 2,
		);

// Footer Section 

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'footer',
		'label'    => __( 'Powered by', 'translation_domain' ),
		'section'  => 'footer',
		'default'  => 'Powered by WordPress and SeedThemes',
		'priority' => 1,
		);

	$controls[] = array(
		'type'     => 'text',
		'setting'  => 'copyright',
		'label'    => __( 'Copy Right', 'translation_domain' ),
		'section'  => 'footer',
		'default'  => 'Copyright © 2015, test blogberry, all rights reserved.',
		'priority' => 1,
		);


	return $controls;
}
add_filter( 'kirki/controls', 'my_custom_setting' );