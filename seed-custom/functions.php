<?php
	function blogberry_scripts_method() {
	    wp_enqueue_script( 'seed-scripts', get_template_directory_uri() . '/seed-custom/js/main.js');
	    wp_enqueue_script( 'slabtext', get_template_directory_uri() . '/seed-custom/js/jquery.slabtext.min.js', array('jquery'));
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
											"logo_uploader" => "",
											"logo_border_radio" => "noborder",
											"intro_background" => "",
											"intro_image_uploader" => "",
											"intro_text_editor" => "",
											"default_thumbnail_uploader" => "",
											"intro_slabtext_checkbox" => 1,
											"custom_css_editor" => "",
											"link_color" => "",
											"facebook_comment_checkbox" => 0,
											"facebook_app_id" => "",
											"fontface_radio" => ""
										);

	if($blogberry["fontface_radio"] == "") {
		if(!is_array($fontface_files) || (count($fontface_files) == 0))
			$fontface_files = get_fontface_files();

		reset($fontface_files);

		$blogberry["fontface_radio"] = key($fontface_files);
	}

	function has_logo() {
		global $blogberry;

		return intval($blogberry['logo_checkbox']);
	}

	function logo() {
		global $blogberry;

		echo $blogberry['logo_uploader'];
	}

	function get_logo() {
		global $blogberry;

		return $blogberry['logo_uploader'];
	}

	function has_logo_border() {
		global $blogberry;

		return !strcmp($blogberry['logo_border_radio'], 'bordered');
	}

	function intro_background() {
		global $blogberry;

		echo $blogberry['intro_background'];
	}

	function get_intro_background() {
		global $blogberry;

		return $blogberry['intro_background'];
	}

	function intro_image() {
		global $blogberry;

		echo $blogberry['intro_image_uploader'];
	}

	function get_intro_image() {
		global $blogberry;

		return $blogberry['intro_image_uploader'];
	}

	function get_intro_text() {
		global $blogberry;

		$return = $blogberry['intro_text_editor'];

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
		} else {
			$return = '<a href="'.home_url().'/wp-admin/themes.php?page=options-framework" class="edit-default-intro">INTRO AREA, INTRODUCE YOURSELF HERE.<br>YOU CAN CHANGE TEXT, BACKGROUND COLOR AND BACKGROUND IMAGE<br>CLICK TO EDIT THIS TEXT.</a>';
		}

		return $return;
	}

	function intro_text() {
		echo nl2br(trim(get_intro_text()));
	}

	function intro_text_with_slabtext() {
		global $blogberry;

		$return = $blogberry['intro_text_editor'];

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
			$return_with_slabtext = '<a href="'.home_url().'/wp-admin/themes.php?page=options-framework" class="edit-this-intro" /><span class="slabtext">INTRO AREA, INTRODUCE YOURSELF HERE. </span><span class="slabtext"> YOU CAN CHANGE TEXT, BACKGROUND COLOR AND BACKGROUND IMAGE
</span><span class="slabtext">CLICK TO EDIT THIS TEXT.</span></a>';
		}

		echo $return_with_slabtext;
	}

	function default_thumbnail() {
		global $blogberry;

		echo $blogberry['default_thumbnail_uploader'];
	}

	function get_default_thumbnail() {
		global $blogberry;

		return $blogberry['default_thumbnail_uploader'];
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

	function use_facebook_comment() {
		global $blogberry;

		return intval($blogberry['facebook_comment_checkbox']);
	}

	function facebook_app_id() {
		global $blogberry;

		echo $blogberry['facebook_app_id'];
	}

	function get_facebook_app_id() {
		global $blogberry;

		return $blogberry['facebook_app_id'];
	}

	function footer_text() {
		global $blogberry;

		echo $blogberry['footer_text_editor'];
	}

	function get_footer_text() {
		global $blogberry;

		return $blogberry['footer_text_editor'];
	}

	function fontface() {
		global $blogberry;

		echo $blogberry['fontface_radio'];
	}

	function get_fontface() {
		global $blogberry;

		return $blogberry['fontface_radio'];
	}

	function get_blogberry_logo_border_style() {
		$return = '';

		if(has_logo() && has_logo_border())
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
			$img = trim(get_logo());

			$root_path = rtrim(realpath(dirname(__FILE__)."/../../../../"), "/\\");

			if(strpos($img, home_url() ) !== false) {
				$img = $root_path."/".ltrim(str_replace(home_url() , '', $img), '/');
			}

			if($img != '') {
				if(has_logo_border()) {
					$image = vt_resize('', $img, 150, 150, true);

					$image['url'] = rtrim(home_url(), "/")."/".ltrim(str_replace($root_path, '', $image['url']), "/");

					$logo = '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" />';

				} else {
					$image = vt_resize('', $img, 150, 1000, false);

					$image['url'] = rtrim(home_url(), "/")."/".ltrim(str_replace($root_path, '', $image['url']), "/");

					$logo = '<img src="'.$image['url'].'" width="'.$image['width'].'" height="'.$image['height'].'" class="noborder" />';
				}

			}
			else {
				$logo = '<img src="'.get_stylesheet_directory_uri().'/seed-core/img/default-logo.png" /><a href="'.home_url().'/wp-admin/themes.php?page=options-framework" class="edit-this-logo">Edit this logo</a>';	
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
			$image = get_stylesheet_directory_uri()."/img/seed-core/img/default-logo.png";

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

		$app_id = get_facebook_app_id();

		$head .= '<meta property="og:type" content="'.$type.'" />'."\r\n";
		$head .= '<meta property="og:title" content="'.$title.'" />'."\r\n";
		$head .= '<meta property="og:url" content="'.$url.'" />'."\r\n";
		$head .= '<meta property="og:image" content="'.$image.'" />'."\r\n";
		$head .= '<meta property="og:site_name" content="'.$site_name.'" />'."\r\n";
		if($app_id != '') {
			$head .= '<meta property="fb:app_id" content="'.$app_id.'" /> '."\r\n";
		}
		$head .= '<meta property="og:description" content="'.$descriptions.'" />'."\r\n";
		$head .= "\r\n";

		$head .= '<style type="text/css">'."\r\n";

		if(!has_logo_border()) {
			$head .= "#brand .logo-avatar, #brand .logo-avatar img { border-radius: 0; }\r\n";
		}

		if(get_link_color() != '') {
			$head .= "a { color: ".get_link_color()." }\r\n";
			$head .= "a:hover  { color: ".adjustBrightness(get_link_color(), 15 * 255 / 100)." }\r\n";
			$head .= "a:active { color: ".adjustBrightness(get_link_color(), (-15) * 255 / 100)." }\r\n";
		}

		if(get_intro_background() != '') {
			$head .= "#intro, #content h1.title { background-color: ".get_intro_background().";}\r\n";
		}

		if(get_intro_image() != '') {
			$head .= "#intro, #content h1.title { background-image:url('".get_intro_image()."');}\r\n";
		}

		$font = get_fontface();

		if($font != '') {
			$head .= "@font-face {\r\n";
			$head .= "	font-family: '".$font."';\r\n";
			$head .= "	src: url('".get_bloginfo('stylesheet_directory')."/seed-custom/font/".$font.".eot');\r\n";
			$head .= "	src: url('".get_bloginfo('stylesheet_directory')."/seed-custom/font/".$font.".eot?#iefix') format('embedded-opentype'),\r\n";
			$head .= "	url('".get_bloginfo('stylesheet_directory')."/seed-custom/font/".$font.".woff') format('woff'),\r\n";
			$head .= "	url('".get_bloginfo('stylesheet_directory')."/seed-custom/font/".$font.".ttf') format('truetype'),\r\n";
			$head .= "	url('".get_bloginfo('stylesheet_directory')."/seed-custom/font/".$font.".svg#".$font."') format('svg');\r\n";
			$head .= "	font-weight: normal;font-style: normal;\r\n";
			$head .= "}\r\n";
			$head .= "\r\n";
			$head .= "h1,h2,h3,h4, #nav{\r\n";
			$head .= "	font-family:".$font.",sans-serif;\r\n";
			$head .= "	font-weight: normal;\r\n";
			$head .= "	line-height: 1.3em;\r\n";
			$head .= "}\r\n";
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
			$foot .= "<script src=\"".get_template_directory_uri()."/seed-core/js/vendor/kickstart.js\"></script>\r\n";
		} else {
			$foot .= "<script src=\"".get_template_directory_uri()."/seed-core/js/vendor/bootstrap.min.js\"></script>\r\n";
		}

		$foot .= "<script src=\"".get_template_directory_uri()."/seed-custom/js/main.js\"></script>\r\n";

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

	function get_fontface_files() {
		$fontface_files = array();

		$all_fontface_files = array();

		$fontface_extensions = array('woff', 'ttf', 'svg', 'eot');

		foreach(scandir(get_template_directory().'/seed-custom/font/') as $_file) {
			if(($_file != '.') && ($_file != '..')) {
				$file_info = pathinfo(get_template_directory().'seed-custom/font/'.$_file);

				if(in_array($file_info['extension'], $fontface_extensions)) {
					$all_fontface_files[$file_info['filename']][] = $file_info['extension'];
				}
			}
		}

		$fontface_files = array();

		foreach($all_fontface_files as $_name => $_files) {
			if(count($_files) == 4) {
				$fontface_css = "@font-face {\r\n";
				$fontface_css .= "	font-family: '".$_name."';\r\n";
				$fontface_css .= "	src: url('".get_bloginfo('stylesheet_directory')."/seed-custom/font/".$_name.".eot');\r\n";
				$fontface_css .= "	src: url('".get_bloginfo('stylesheet_directory')."/seed-custom/font/".$_name.".eot?#iefix') format('embedded-opentype'),\r\n";
				$fontface_css .= "	url('".get_bloginfo('stylesheet_directory')."/seed-custom/font/".$_name.".woff') format('woff'),\r\n";
				$fontface_css .= "	url('".get_bloginfo('stylesheet_directory')."/seed-custom/font/".$_name.".ttf') format('truetype'),\r\n";
				$fontface_css .= "	url('".get_bloginfo('stylesheet_directory')."/seed-custom/font/".$_name.".svg#".$_name."') format('svg');\r\n";
				$fontface_css .= "	font-weight: normal;font-style: normal;\r\n";
				$fontface_css .= "}\r\n";

				$fontface_files[$_name] = $fontface_css;
			}
		}

		return $fontface_files;
	}

	// Add specific CSS class by filter
	add_filter('body_class','add_font_class');

	function add_font_class($classes) {
		$font = get_fontface();

		if(substr($font, -3) == '-th') {
			$classes[] = 'font-th';
		} elseif(substr($font, -9) == '-th-large') {
			$classes[] = 'font-th-large';
		}

		return $classes;	
	}

	function blogberry_admin_theme_style() {
		wp_enqueue_style('seed-admin-theme', get_template_directory_uri().'/seed-custom/css/admin.css');
	}

	add_action('admin_enqueue_scripts', 'blogberry_admin_theme_style');
	add_action('login_enqueue_scripts', 'blogberry_admin_theme_style');