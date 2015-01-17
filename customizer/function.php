<?php
function blogberry_scripts_method() {
	wp_enqueue_script( 'seed-scripts', get_template_directory_uri() . '/customizer/assets/js/main.js');
	wp_enqueue_script( 'slabtext', get_template_directory_uri() . '/customizer/assets/js/jquery.slabtext.min.js', array('jquery'));
}

	add_action( 'wp_enqueue_scripts', 'blogberry_scripts_method' ); // wp_enqueue_scripts action hook to link only on the front-end

	global $blogberry;
	global $themename;
	global $fontface_files;

	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$blogberry = get_option($themename);

	if(!is_array($blogberry))
		$blogberry = array();

	$blogberry = $blogberry + array(
		"logo_checkbox" => 1,
		"uploads" => "",
		"border" => "noborder",
		"bg" => "",
		"text" => "",
		"default_thumbnail_uploader" => "",
		"intro_slabtext_checkbox" => 1,
		"link_color" => "",
		);


	function has_logo() {
		global $blogberry;

		return intval($blogberry['logo_checkbox']);
	}

	function logo() {
		global $blogberry;

		echo get_theme_mod('uploads');
	}

	function get_logo() {
		global $blogberry;

		return get_theme_mod('uploads');
	}

	function has_logo_border() {
		global $blogberry;

		return !strcmp(get_theme_mod('bordered'), 'bordered');
	}

	function intro_background() {
		global $blogberry;

		echo get_theme_mod('bg');
	}

	function get_intro_background() {
		global $blogberry;

		return get_theme_mod('bg');
	}


	function get_intro_image(){

		global $blogberry;

		return get_theme_mod('bg');;
	}


	function intro_text_with_slabtext() {
		global $blogberry;

		$return = get_theme_mod('text');

		if(trim($return) != '') {
			$return = str_replace("&nbsp;", " ", $return);
			$return = str_replace("\r", "", $return);

			while(false !== strpos($return, "  ")) {
				$return = str_replace("  ", " ", $return);
			}

			$return = str_replace("\n ", "\n", $return);
			$return = str_replace(" \n", "\n", $return);

			while(strpos($return, "\n\n")) {
				$return = str_replace("\n\n", "\n", $return);
			}

			$return_with_slabtext = '';

			foreach(explode("\n", trim($return)) as $_line) {
				$return_with_slabtext .= '<span class="slabtext">'.$_line.'</span>';
			}
		} else {
			$return_with_slabtext = '<a href="'.home_url().'/wp-admin/customize.php" class="edit-this-intro" /><span class="slabtext">INTRO AREA, INTRODUCE YOURSELF HERE. </span><span class="slabtext"> YOU CAN CHANGE TEXT, BACKGROUND COLOR AND BACKGROUND IMAGE
		</span><span class="slabtext">CLICK TO EDIT THIS TEXT.</span></a>';
	}

	echo $return_with_slabtext;
}

function default_thumbnail() {

	echo get_theme_mod('postpic');
}

function get_default_thumbnail() {

	return get_theme_mod('postpic');
}

function use_intro_slabtext() {
	global $blogberry;

	return intval($blogberry['intro_slabtext_checkbox']);
}

function custom_css() {
	global $blogberry;

	echo $blogberry['custom_css_editor'];
}

function get_custom_css() {
	global $blogberry;

	return $blogberry['custom_css_editor'];
}

function link_color() {
	global $blogberry;

	echo $blogberry['link_color'];
}

function get_link_color() {
	global $blogberry;

	return $blogberry['link_color'];
}


function footer_text() {
	global $blogberry;

	echo $blogberry['footer_text_editor'];
}

function get_footer_text() {
	global $blogberry;

	return $blogberry['footer_text_editor'];
}


function get_blogberry_logo_border_style() {
	$return = '';

	if(get_theme_mod('bordered') == true)
		$return = 'bordered';
	else
		$return = 'noborder';

	return $return;
}

function blogberry_logo_border_style() {
	echo get_blogberry_logo_border_style();
}

function get_blogberry_logo() {
	$logo = '';

	if(has_logo()) {
		$upload_dir = wp_upload_dir();
		$img = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], get_logo());


		if($img != '') {
			if(has_logo_border()) {
				$image = vt_resize('', $img, 150, 150, true);

				$image['url'] = str_replace($upload_dir['basedir'], $upload_dir['baseurl'], $image['url']);

				$logo = '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" />';

			} else {
				$image = vt_resize('', $img, 150, 1000, false);

				$image['url'] = str_replace($upload_dir['basedir'], $upload_dir['baseurl'], $image['url']);

				$logo = '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" class="noborder" />';
			}

		}
		else {
			$logo = '<img src="'.get_stylesheet_directory_uri().'/customizer/assets/images/default-logo.png" /><a href="'.home_url().'/wp-admin/customize.php" class="edit-this-logo">Edit this logo</a>';	
		}
	}

	return $logo;
}

function blogberry_logo() {
	echo get_blogberry_logo();
}

function blogberry_head() {
	global $blogberry;
	global $post;

	$head = '';

	$type = is_singular() ? "article" : "website";
	$title = wp_title('&laquo;', false, 'right');
	$url = 	"http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	$image = "";

	if(is_front_page()) {
		$image = get_logo();
	} else if(is_singular()) {
		$post_thumbnail_id = get_post_thumbnail_id( $post->ID);

		$image_properties = wp_get_attachment_image_src($post_thumbnail_id,  "full");

		$image = $image_properties[0];
	}

	if(trim($image) == "")
		$image = get_stylesheet_directory_uri()."/customizer/assets/images/default-logo.png";

	$path = substr($image, 0, strrpos($image, "/"));
	$filename = substr($image, strrpos($image, "/") + 1);

	$image = $path."/".urlencode($filename);

	$site_name = get_bloginfo('name');

	$descriptions = strip_tags(htmlspecialchars(get_bloginfo('description')));

	if(is_singular()) {
		$post_data = get_post( $post->ID );

		the_post();
		$excerpt = htmlspecialchars(get_the_excerpt());
		rewind_posts();

		$descriptions = strip_tags(htmlspecialchars($excerpt));
	}


	$head .= '<meta property="og:type" content="'.$type.'" />'."\r\n";
	$head .= '<meta property="og:title" content="'.$title.'" />'."\r\n";
	$head .= '<meta property="og:url" content="'.$url.'" />'."\r\n";
	$head .= '<meta property="og:image" content="'.$image.'" />'."\r\n";
	$head .= '<meta property="og:site_name" content="'.$site_name.'" />'."\r\n";
	$head .= '<meta property="og:description" content="'.$descriptions.'" />'."\r\n";
	$head .= "\r\n";

	$head .= '<style type="text/css">'."\r\n";

	if(!has_logo_border()) {
		$head .= "#brand .logo-avatar, #brand .logo-avatar img { border-radius: 0; }\r\n";
	}

	if(get_theme_mod('color') != '') {
		$head .= "a { color: ".get_theme_mod('color')." }\r\n";
		$head .= "a:hover  { color: ".adjustBrightness(get_theme_mod('color'), 15 * 255 / 100)." }\r\n";
		$head .= "a:active { color: ".adjustBrightness(get_theme_mod('color'), (-15) * 255 / 100)." }\r\n";
	}

	if(get_theme_mod('bg') != '') {
		$head .= "#intro, #content h1.title { background-color: ".get_theme_mod('bg').";}\r\n";
	}

	if(get_intro_image() != '') {
		$head .= "#intro, #content h1.title { background-image:url('".get_intro_image()."');}\r\n";
	}


	if(trim(get_custom_css()) != '')
		$head .= trim(get_custom_css())."\r\n";

	$head .= "</style>\r\n";

	if($head != '')
		?>
	<?php echo $head; ?>
	<?php
}

function blogberry_footer() {
	$foot = '';

	if(defined('SEED_KICKSTART') && (SEED_KICKSTART)) {
		$foot .= "<script src=\"".get_template_directory_uri()."/customizer/assets/js/kickstart.js\"></script>\r\n";
	} else {
		$foot .= "<script src=\"".get_template_directory_uri()."/customizer/assets/js/bootstrap.min.js\"></script>\r\n";
	}

	$foot .= "<script src=\"".get_template_directory_uri()."/customizer/assets/js/main.js\"></script>\r\n";

	if($foot != '')
		?>
	<?php echo $foot; ?>
	<?php
}

function adjustBrightness($hex, $steps) {
		// Steps should be between -255 and 255. Negative = darker, positive = lighter
	$steps = max(-255, min(255, $steps));

		// Format the hex color string
	$hex = str_replace('#', '', $hex);
	if (strlen($hex) == 3) {
		$hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
	}

		// Get decimal values
	$r = hexdec(substr($hex,0,2));
	$g = hexdec(substr($hex,2,2));
	$b = hexdec(substr($hex,4,2));

		// Adjust number of steps and keep it inside 0 to 255
	$r = max(0,min(255,$r + $steps));
	$g = max(0,min(255,$g + $steps));  
	$b = max(0,min(255,$b + $steps));

	$r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
	$g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
	$b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

	return '#'.$r_hex.$g_hex.$b_hex;
}

function powered_blogberry(){
	if( get_theme_mod('footer') != '' ){
		echo get_theme_mod('footer');
	}else{
		echo 'Powered by <a href="http://www.wordpress.org" target="_blank">WordPress</a> and <a href="http://SeedThemes.com" target="_blank">SeedThemes</a>';
	}
}

function copyright_blogberry() {

	if( get_theme_mod('copyright') != '' ){
		echo get_theme_mod('copyright');
	}else{ ?>
		<p>Copyright &copy;<?php date("Y"); ?>, <?php bloginfo( 'name' ); ?>, all rights reserved.</p>
	<?php }

}