<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */
 
 	global $themename;
	global $fontface_files;

function optionsframework_option_name() {
 	global $themename;

	// This gets the theme name from the stylesheet
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	$logo_border_array = array(
		'bordered' => __('Bordered & shadowed', 'seed_options_theme'),
		'noborder' => __('No border, just image', 'seed_options_theme')
	);

	$editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);

	global $fontface_files;

	if(!is_array($fontface_files) || (count($fontface_files) == 0))
		$fontface_files = get_fontface_files();

	reset($fontface_files);

	$fontface_array = array();

	foreach($fontface_files as $fontface_name => $_fontface_css) {
		if(strtolower(substr($fontface_name, -3)) == '-th') {
			$fontface_array[$fontface_name] = substr($fontface_name, 0, strlen($fontface_name) - 3).__(' AcBbCc 123 กขคงจฉ');
		} elseif(strtolower(substr($fontface_name, -9)) == '-th-large') {
			$fontface_array[$fontface_name] = substr($fontface_name, 0, strlen($fontface_name) - 9).__(' AcBbCc 123 กขคงจฉ');
		} else {
			$fontface_array[$fontface_name] = $fontface_name.__(' AaBbCc 12345');
		}
	}

	// If using image radio buttons, define a directory path

	$options = array();

	$options[] = array(
		'name' => __('Main', 'seed_options_theme'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Logo / avatar', 'seed_options_theme'),
		'desc' => __('Show logo / avatar.', 'seed_options_theme'),
		'id' => 'logo_checkbox',
		'std' => '1',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('File', 'seed_options_theme'),
		'desc' => __('Upload your logo/avatar. Blogberry will resize to 150px width.', 'seed_options_theme'),
		'id' => 'logo_uploader',
		'class' => 'hidden',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Logo border', 'seed_options_theme'),
		'desc' => __('', 'seed_options_theme'),
		'id' => 'logo_border_radio',
		'std' => 'noborder',
		'type' => 'radio',
		'class' => 'hidden',
		'options' => $logo_border_array);

	$options[] = array(
		'name' =>  __('Intro background', 'seed_options_theme'),
		'desc' => __('', 'seed_options_theme'),
		'id' => 'intro_background',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Intro image background', 'seed_options_theme'),
		'desc' => __('Upload your image. 740px width is recommended', 'seed_options_theme'),
		'id' => 'intro_image_uploader',
		'type' => 'upload');

	$options[] = array(
		'name' => __('Intro text', 'seed_options_theme'),
		/* 'desc' => sprintf( __( 'You can also pass settings to the editor.  Read more about wp_editor in <a href="%1$s" target="_blank">the WordPress codex</a>', 'seed_options_theme' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ), */
		'desc' => __('Introduce yourself here.', 'seed_options_theme' ),
		'id' => 'intro_text_editor',
		'type' => 'editor',
		'settings' => $editor_settings );
		
	$options[] = array(
		'name' => __('Resize & justify text', 'seed_options_theme'),
		'desc' => __('Resize & justify a text with <a target="_blank" href="http://github.com/freqDec/slabText/">Slabtext</a>.', 'seed_options_theme'),
		'std' => '1',
		'id' => 'intro_slabtext_checkbox',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Additional', 'seed_options_theme'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Default post thumbnail', 'seed_options_theme'),
		'desc' => __('Upload your own default post thumbnail. 150px width is recommended', 'seed_options_theme'),
		'id' => 'default_thumbnail_uploader',
		'type' => 'upload');

	$options[] = array(
		'name' =>  __('Link color', 'seed_options_theme'),
		'desc' => __('', 'seed_options_theme'),
		'id' => 'link_color',
		'type' => 'color' );

	$options[] = array(
		'name' => __('Facebook comment', 'seed_options_theme'),
		'desc' => __('Use Facebook comment', 'seed_options_theme'),
		'id' => 'facebook_comment_checkbox',
		'type' => 'checkbox');

	$options[] = array(
		'name' => __('Facebook App ID', 'seed_options_theme'),
		'desc' => __('To moderate comment, you need to setup Facebook App ID. Please google for "How to setup facebook app id"</a>', 'seed_options_theme'),
		'id' => 'facebook_app_id',
		'class' => 'hidden',
		'type' => 'text');

	$options[] = array(
		'name' => __('Footer Text Editor', 'seed_options_theme'),
		'desc' => sprintf( __( 'You can also pass settings to the editor.  Read more about wp_editor in <a href="%1$s" target="_blank">the WordPress codex</a>', 'seed_options_theme' ), 'http://codex.wordpress.org/Function_Reference/wp_editor' ),
		'id' => 'footer_text_editor',
		'type' => 'editor',
		'class' => 'hidden',
		'settings' => $editor_settings );
		
	$options[] = array(
		'name' => __('Custom CSS', 'seed_options_theme'),
		'desc' => __('You can override CSS here.', 'seed_options_theme'),
		'id' => 'custom_css_editor',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('Font', 'seed_options_theme'),
		'type' => 'heading');

	reset($fontface_files);

	$options[] = array(
		'name' => __('Font', 'seed_options_theme'),
		'id' => "fontface_radio",
		'type' => "radio",
		'std' => key($fontface_files),
		'options' => $fontface_array
	);

	return $options;
}

/*
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() {
	global $themename;
	global $fontface_files;

	if(!is_array($fontface_files) || (count($fontface_files) == 0))
		$fontface_files = get_fontface_files();

	reset($fontface_files);
?>
<style type="text/css">
<?php foreach($fontface_files as $fontface_css) { ?>
<?php echo $fontface_css; ?>
<?php } ?>
</style>

<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#logo_checkbox').click(function() {
		jQuery('#section-logo_uploader, #section-logo_border_radio').fadeToggle(400);
	});

	if (jQuery('#logo_checkbox:checked').val() !== undefined) {
		jQuery('#section-logo_uploader, #section-logo_border_radio').show();
	}

	jQuery('#facebook_comment_checkbox').click(function() {
		jQuery('#section-facebook_app_id').fadeToggle(400);
	});

	if (jQuery('#facebook_comment_checkbox:checked').val() !== undefined) {
		jQuery('#section-facebook_app_id').show();
	}

	<?php foreach($fontface_files as $fontface_name => $fontface_css) { ?>
	jQuery('label[for="<?php echo $themename; ?>-fontface_radio-<?php echo $fontface_name; ?>"]').css('font-family', '<?php echo $fontface_name; ?>').css('font-weight', 'normal').css('font-size', '24px').css('line-height', '1.3em').css('white-space','nowrap');
	<?php } ?>
});
</script>
<?php
	}