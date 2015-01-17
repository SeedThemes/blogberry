<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header>
			<h1 class="title"><?php the_title(); ?></h1>
		</header>

		<div class="entry">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">Pages:', 'after' => '</div>' ) ); ?>
		</div><!--entry-->
		<?php edit_post_link( 'Edit', '<p class="edit-link">', '</p>' ); ?>
	</article>
<?php endwhile; ?>
<?php
// If comments are open or we have at least one comment, load up the comment template
if ( comments_open() || get_comments_number() ) :
	comments_template();
endif;
?>
<?php get_footer(); ?>