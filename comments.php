<?php if ( post_password_required() )
	return;
?>

<div id="comments">

<?php if ( have_comments() ) : ?>
	<h2>Comments</h2>

	<ol>
		<?php wp_list_comments( array( 'style' => 'ol' ) ); ?>
	</ol>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav" class="navigation group" role="navigation">
		<div class="prev alignleft"><?php previous_comments_link(); ?></div>
		<div class="next alignright"><?php next_comments_link(); ?></div>
	</nav>
	<?php endif; ?>

<?php elseif ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :?>
	<p class="nocomments">Comments are closed.</p>
<?php endif; ?>

<?php comment_form(); ?>

</div><!--comments-->