<!DOCTYPE html>
<!--[if IE 7 | IE 8]>
<html class="ie" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/seed-core/js/vendor/html5shiv.js" type="text/javascript"></script>
<![endif]-->
<?php wp_enqueue_script("jquery"); ?>
<?php wp_head(); ?>
<?php blogberry_head(); ?>
</head>

<body <?php body_class(); ?>><?php seed_fb(seed_option('facebook_app_id')); ?>
<div id="page" class="group">
<header id="head" class="group">
	<div id="brand">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
		<div class="logo fadeInUp <?php blogberry_logo_border_style(); ?>"><?php if(has_logo()): ?><?php blogberry_logo(); ?><?php else: ?><?php endif; ?></div>
		<div class="name">
		<h2 class="title fadeIn"><?php bloginfo( 'name' ); ?></h2>
		<h3 class="desc fadeIn"><?php bloginfo( 'description' ); ?></h3>
		</div><!--name-->
		</a>
	</div>
	<nav id="nav" role="navigation">
		<div class="menu-toggle btn btn-large">Menu</div>
		<div id="mainnav">
		<div class="skip-link assistive-text"><a href="#content" title="Skip to content">Skip to content</a></div>
		<?php wp_nav_menu( array( 'theme_location' => 'main', 'menu_class' => 'main' ) ); ?>
		<div id="search" class="form-search">
		<div class="input-append">
			<form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="screen-reader-text" for="s">Search for:</label>
			<input type="text" name="s" id="s" class="search-query" placeholder="Search"/>
			<button type="submit" id="searchsubmit" class="btn"><i class="icon-search"></i></button> 
			</form>
		</div>
		</div><!--search-->
		</div><!--mainnav-->
	</nav>
	<?php get_sidebar(); ?>
</header>

<div id="main" class="group">
<div id="content" class="group" role="main">