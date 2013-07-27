<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header>
		<h1 class="title"><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<div class="meta">
		<i class="icon-calendar"> <?php the_date(); ?></i>
		<i class="icon-time"> <?php echo get_the_time(); ?></i>
		<i class="icon-folder-open"> <?php the_category(', ') ?> </i>
		<?php the_tags( '<i class="icon-tag"> ', ', ', '</i>'); ?>
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


<?php seed_socials(); ?>

<?php seed_comment(seed_option('facebook_comment_checkbox')); ?>

<?php endwhile; /* end of the loop. */ ?>

<?php get_footer(); ?>