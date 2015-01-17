<?php

/* by SeedThemes */


global $blogberry;
global $themename;
global $fontface_files;

$themename = get_option( 'stylesheet' );
$themename = preg_replace("/\W/", "_", strtolower($themename) );

$blogberry = get_option($themename);

if(!is_array($blogberry))
	$blogberry = array();

$blogberry = $blogberry + array(
	"uploads" => "",
	"border" => "noborder",
	"bg" => "",
	"text" => "",
	"default_thumbnail_uploader" => "",
	);




function has_logo_border() {
	global $blogberry;

	return !strcmp(get_theme_mod('bordered'), 'bordered');
}


function default_thumbnail() {

	echo get_theme_mod('postpic');
}

function get_default_thumbnail() {

	return get_theme_mod('postpic');
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



function blogberry_head() {
	global $blogberry;
	global $post;

	$head = '<style type="text/css">'."\r\n";

	if(!has_logo_border()) {
		$head .= "#brand .logo-avatar, #brand .logo-avatar img { border-radius: 0; }\r\n";
	}

	if(get_theme_mod('main-color') != '') {
		$head .= "a { color: ".get_theme_mod('main-color')." }\r\n";
		$head .= "#intro, #content h1.title { background-color: ".get_theme_mod('main-color')." }\r\n";
	}

	if(get_theme_mod('side-color') != '') {
		$head .= "#head, #head a, #foot, #foot a { color: ".get_theme_mod('side-color')." }\r\n";
	}




	$head .= "</style>\r\n";

	if($head != '')
		?>
	<?php echo $head; ?>
	<?php
}







/*******************************************************************
Bootstrap Pagination 
http://www.lanexa.net/2012/09/add-twitter-bootstrap-pagination-to-your-wordpress-theme/
********************************************************************/

function bootstrap_pagination($pages = '', $range = 2)
{
	$showitems = ($range * 2)+1;

	global $paged;
	if(empty($paged)) $paged = 1;

	if($pages == '')
	{
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages)
		{
			$pages = 1;
		}
	}

	if(1 != $pages)
	{
		echo "<div class='pagination'><ul>";
		if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."'>&laquo;</a></li>";
		if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a></li>";

		for ($i=1; $i <= $pages; $i++)
		{
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
			{
				echo ($paged == $i)? "<li class='active'><span class='current'>".$i."</span></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a></li>";
			}
		}

		if ($paged < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>";
		if ($paged < $pages-1 && $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."'>&raquo;</a></li>";
		echo "</ul></div>\n";
	}
}



/*******************************************************************
* Redimensiona imagens dinamicamente utilizando funções nativas do wp
* Victor Teixeira *
* php 5.2+
*
* Example code:
* 
* <?php 
* $thumb = get_post_thumbnail_id(); 
* $image = vt_resize( $thumb,'' , 140, 110, true, 80 );
* ?>
* <img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" />
*
* @param int $attach_id
* @param string $img_url
* @param int $width
* @param int $height
* @param bool $crop
* @return array
********************************************************************/
function vt_resize( $attach_id = null, $img_url = null, $width, $height, $crop = false, $jpeg_quality = 90 ) 
{
	if ( $attach_id ) {
		$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
		$file_path = get_attached_file( $attach_id );
	} else if ( $img_url ) {
		$file_path = parse_url( $img_url );
//		$file_path = ltrim( $file_path['path'], '/' );
		$file_path = $file_path['path'];
		$orig_size = getimagesize( $file_path );
		$image_src[0] = $img_url;
		$image_src[1] = $orig_size[0];
		$image_src[2] = $orig_size[1];
	}
	$file_info = pathinfo( $file_path );
	$extension = '.'. $file_info['extension'];
	$no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];
	$cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;
	$new_img_path = $cropped_img_path;
	if ( $image_src[1] > $width || $image_src[2] > $height ) {
		if ( file_exists( $cropped_img_path ) ) {
			$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
			$vt_image = array (
				'url' => $cropped_img_url,
				'width' => $width,
				'height' => $height
				);			
			return $vt_image;
		}
		if ( $crop == false ) {
			$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
			$resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;			
			$new_img_path = $resized_img_path;
			if ( file_exists( $resized_img_path ) ) {

				$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );
				$vt_image = array (
					'url' => $resized_img_url,
					'width' => $proportional_size[0],
					'height' => $proportional_size[1]
					);
				
				return $vt_image;
			}
		}

		$new_image = wp_get_image_editor($file_path);

		if ( ! is_wp_error( $new_image ) ) {
			$new_image->set_quality($jpeg_quality);
			$new_image->resize( $width, $height, $crop );
			$new_image->save( $new_img_path );
		}

//		$new_img_path = image_resize( $file_path, $width, $height, $crop, $jpeg_quality );

		$new_img_size = getimagesize( $new_img_path );
		$new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );
		$vt_image = array (
			'url' => $new_img,
			'width' => $new_img_size[0],
			'height' => $new_img_size[1]
			);
		
		return $vt_image;
	}
	$vt_image = array (
		'url' => $image_src[0],
		'width' => $image_src[1],
		'height' => $image_src[2]
		);	
	return $vt_image;
}

function seed_pagination() {
	bootstrap_pagination();

	paginate_links();
}

function seed_option($option) {
	$return = '';

	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	global $seed_options;
	$seed_options = get_option($themename);

	if(is_array($seed_options))
		if(array_key_exists($option, $seed_options))
			$return = $seed_options[$option];

		return $return;
	}

	function seed_fb($facebook_app_id = '') { ?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo $facebook_app_id; ?>";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<?php
}

function seed_comment($fb = false) {
	if(comments_open()) {
		if($fb) { ?>
		<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-num-posts="10"></div>
		<?php
	} else {
		if ( comments_open() || '0' != get_comments_number() ) comments_template( '', true );
	}
}
}

function seed_socials() {
	?>
	<div class="social group">
		<div class="more">
			<div class="twitter">
				<a href="<?php echo esc_url( __( 'https://twitter.com/share', 'seed' ) ); ?>" class="twitter-share-button">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</div><!--twitter-->
			<div class="gplus">
				<g:plusone size="medium"></g:plusone>
				<script type="text/javascript">
					(function() {
						var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
						po.src = 'https://apis.google.com/js/plusone.js';
						var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
					})();
				</script>
			</div><!--gplus-->
		</div>
		<div class="facebook">
			<div class="fb-like" data-href="<?php the_permalink(); ?>" data-width="500" data-show-faces="false"></div>
		</div><!--facebook-->
	</div><!--social-->
	<?php
}

function seed_ua_code($ua_code) {
	?>
	<script type="text/javascript">

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo $ua_code; ?>']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

	</script>
	<?php
}

function theme_styles() {

	wp_register_style('seed', get_template_directory_uri()."/inc/seed.css");
	wp_enqueue_style('seed');

	wp_register_style('font-awesome', get_template_directory_uri()."/inc/font-awesome/css/font-awesome.min.css");
	wp_enqueue_style('font-awesome');
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );	
	wp_enqueue_style( 'seed-style', get_stylesheet_uri() , array('seed'));

}

add_action('wp_enqueue_scripts', 'theme_styles');
?>