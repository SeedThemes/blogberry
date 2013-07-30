<?php

/*******************************************************************
* Collected by @iMenn, SeedThemes.com
*
* Check first,
*
* $content_width (650)
* custom-background -> default-color
* set_post_thumbnail_size
*
********************************************************************/

if ( ! isset( $content_width ) ) $content_width = 650;

function seed_setup() {
	add_editor_style();
	add_theme_support( 'automatic-feed-links' );
	register_nav_menus( array('main' => __( 'Main Navigation', 'seed' )));
	add_theme_support( 'custom-background', array('default-color' => 'e4e4e4'));
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, TRUE );
}
add_action( 'after_setup_theme', 'seed_setup' );

function seed_wp_title( $title, $sep ) {
	global $paged, $page;
	if ( is_feed() ) return $title;
	$title .= get_bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );	
	if ( $site_description && ( is_home() || is_front_page() ) ) $title = "$title $sep $site_description";
	if ( $paged >= 2 || $page >= 2 ) $title = "$title $sep " . sprintf( __( 'Page %s', 'seed' ), max( $paged, $page ) );
	return $title;
}
add_filter( 'wp_title', 'seed_wp_title', 10, 2 );


function seed_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Side Area', 'seed' ),
		'id' => 'seed-sidebar-main',
		'description' => __( 'Appears on side, recommend for 160px width banners', 'seed' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area', 'seed' ),
		'id' => 'seed-sidebar-foot',
		'description' => __( 'Appears below content', 'seed' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	

}
add_action( 'widgets_init', 'seed_widgets_init' );

function seed_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'seed_customize_register' );

function seed_customize_preview_js() {
	wp_enqueue_script( 'seed-customizer', get_template_directory_uri() . '/seed-core/js/theme-customizer.js', array( 'customize-preview' ), '20121027', true );
}
add_action( 'customize_preview_init', 'seed_customize_preview_js' );


require_once(rtrim(realpath(dirname(__FILE__)), "/\\")."/seed-core/functions.php");
require_once(rtrim(realpath(dirname(__FILE__)), "/\\")."/seed-custom/functions.php");
?>