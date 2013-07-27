<?php get_header(); ?>


<?php if(is_front_page()) {?>
<?php if(use_intro_slabtext()): ?><h1 id="intro" class="slabheader" style="display:none;"><?php intro_text_with_slabtext(); ?></h1>
<?php else: ?>
<h1 id="intro"><?php intro_text(); ?></h1>
<?php endif; ?>

<?php } ?>


<?php if ( have_posts() ) : ?>

<?php if ( is_tag() || is_category() || is_day() || is_month() || is_year() || is_search() ) : ?> 
	<header><h1 class="title">
	<?php if (is_tag()) 			{ ?>Tag: <?php single_tag_title(); ?>
	<?php } elseif (is_category()) 	{ ?><?php single_cat_title(); ?>
	<?php } elseif (is_day()) 		{ ?>Day: <?php the_time(get_option( 'date_format' )); ?>
	<?php } elseif (is_month())		{ ?>Month: <?php the_time('F Y'); ?>
	<?php } elseif (is_year()) 		{ ?>Year: <?php the_time('Y'); ?>
	<?php } elseif (is_search())	{ ?>Searched for: <?php the_search_query(); ?>
	<?php } ?>
	</h1></header>
<?php endif; ?>
<div class="items group">
<?php while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="item group">
	

	<div class="pic">
	<a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark">
	<?php if(has_post_thumbnail()) { the_post_thumbnail();} else { ?><?php if(get_default_thumbnail() != ''): ?><img src='<?php default_thumbnail(); ?>' /><?php else: ?><img src="<?php echo get_template_directory_uri(); ?>/img/thumb.jpg" /><?php endif; ?><?php }?>
	</a>
	</div><!--pic-->

	<div class="info">
	<header>
	<h3><a href="<?php the_permalink(); ?>" title="Permalink to <?php the_title_attribute(); ?>" rel="bookmark"><?php if ( is_sticky() ) : ?><span class="featured-post"><i class="icon-star-empty"></i></span> <?php endif; ?><?php the_title(); ?></a></h3>
	</header>

	<div class="meta"><i class="icon-calendar"> <?php echo get_the_date(); ?></i></div><!--meta-->

	<?php the_excerpt(); ?>
	<?php /* the_content(); */ ?>

	</div><!--info-->


	</div><!--item-->
	</article>
<?php endwhile; ?>
</div><!--items-->

<?php seed_pagination();?>


<?php else : ?>

	<article id="post-0" class="post no-results not-found">
	<header>
		<h1 class="title">Nothing Found</h1>
	</header>
	<div class="entry">
		<p>Apologies, but no results were found. Perhaps searching will help find a related post.</p>
		<?php get_search_form(); ?>
	</div><!--entry-->
	</article>
	
<?php endif; ?>


<?php get_footer(); ?>