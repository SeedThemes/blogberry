<?php
remove_action( 'wp_head', 'jetpack_og_tags' );
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/seed-core/inc/' );

	require_once(rtrim(realpath(dirname(__FILE__)), "/\\")."/inc/options-framework.php");
}

/*******************************************************************
 * Class Name: twitter_bootstrap_nav_walker
 * GitHub URI: https://github.com/twittem/wp-bootstrap-navwalker
 * Description: A custom Wordpress nav walker to implement the Twitter Bootstrap 2 (https://github.com/twitter/bootstrap/) dropdown navigation using the Wordpress built in menu manager.
 * Version: 1.2.2
 * Author: Edward McIntyre - @twittem
 * Licence: WTFPL 2.0 (http://sam.zoy.org/wtfpl/COPYING)
********************************************************************/

class twitter_bootstrap_nav_walker extends Walker_Nav_Menu {
	
	/**
	 * @see Walker::start_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function start_lvl( &$output, $depth ) {
		$indent = str_repeat( "\t", $depth );
		$output	   .= "\n$indent<ul class=\"dropdown-menu\">\n";		
	}

	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		if (strcasecmp($item->title, 'divider')) {
			$class_names = $value = '';
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = ($item->current) ? 'active' : '';
			$classes[] = 'menu-item-' . $item->ID;
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

			if ($args->has_children && $depth > 0) {
				$class_names .= ' dropdown-submenu';
			} else if($args->has_children && $depth === 0) {
				$class_names .= ' dropdown';
			}

			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names .'>';

			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			$attributes .= ($args->has_children) 	    ? ' data-toggle="dropdown" data-target="#" class="dropdown-toggle"' : '';

			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			$item_output .= ($args->has_children && $depth == 0) ? ' <span class="caret"></span></a>' : '</a>';
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		} else {
			$output .= $indent . '<li class="divider">';
		}
	}


	/**
	 * Traverse elements to create list from elements.
	 *
	 * Display one element if the element doesn't have any children otherwise,
	 * display the element and its children. Will only traverse up to the max
	 * depth and no ignore elements under that depth. 
	 *
	 * This method shouldn't be called directly, use the walk() method instead.
	 *
	 * @see Walker::start_el()
	 * @since 2.5.0
	 *
	 * @param object $element Data object
	 * @param array $children_elements List of elements to continue traversing.
	 * @param int $max_depth Max depth to traverse.
	 * @param int $depth Depth of current element.
	 * @param array $args
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return null Null on failure with no changes to parameters.
	 */

	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
		
		if ( !$element ) {
			return;
		}
		
		$id_field = $this->db_fields['id'];

		//display this element
		if ( is_array( $args[0] ) ) 
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
		else if ( is_object( $args[0] ) ) 
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] ); 
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'start_el'), $cb_args);

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

			foreach( $children_elements[ $id ] as $child ){

				if ( !isset($newlevel) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
				unset( $children_elements[ $id ] );
		}

		if ( isset($newlevel) && $newlevel ){
			//end the child delimiter
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}

		//end this element
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}
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
		if(defined('SEED_KICKSTART') && (SEED_KICKSTART)) {
			wp_register_style('seed-framework', get_template_directory_uri()."/seed-core/css/kickstart/css/kickstart.css", array(), "", "all");
			wp_enqueue_style('seed-framework');
		} else {
			wp_register_style('seed-framework', get_template_directory_uri()."/seed-core/css/bootstrap/bootstrap.min.css", array(), "", "all");
			wp_enqueue_style('seed-framework');
		}

		wp_register_style('seed-font-awesome', get_template_directory_uri()."/seed-core/css/font-awesome.min.css", array("seed-framework"), "", "all");
		wp_enqueue_style('seed-font-awesome');
		wp_register_style('seed', get_template_directory_uri()."/seed-core/css/seed.css", array(), "seed-font-awesome", "all");
		wp_enqueue_style('seed');

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );	
			wp_enqueue_style( 'seed-style', get_stylesheet_uri() , array('seed'));

	}

	add_action('wp_enqueue_scripts', 'theme_styles');
?>