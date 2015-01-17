<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>


	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header>
			<h1 class="title"><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
			<div class="meta">
				<i class="fa fa-calendar"> <?php the_date(); ?></i>
				<i class="fa fa-clock-o"> <?php echo get_the_time(); ?></i>
				<i class="fa fa-folder-open"> <?php the_category(', ') ?> </i>
				<?php the_tags( '<i class="fa fa-tag"> ', ', ', '</i>'); ?>
			</div><!--meta-->
		</header>
		<div class="entry">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . 'Pages:', 'after' => '</div>' ) ); ?>
		</div><!--entry-->
		<footer>
			<?php edit_post_link('Edit', '<span class="edit-link">', '</span>' ); ?>
		</footer>
	</article>

<?php endwhile; /* end of the loop. */ ?>

<?php
// If comments are open or we have at least one comment, load up the comment template
if ( comments_open() || get_comments_number() ) :
	comments_template();
endif;
?>

<?php get_footer(); ?>