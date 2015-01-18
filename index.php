<?php get_header(); ?>


<?php if(is_front_page()):?>
	<div id="intro">

		<?php if( get_theme_mod('intro-text') != '' ): ?>
			<?php echo get_theme_mod('intro-text');?>
		<?php else: ?>
			<?php if (current_user_can( 'manage_options' )) : ?>
				<a href="<?php echo esc_url( admin_url() .'customize.php');?>" class="edit-this-intro" />
					<?php _e('<h1>Intro area, introduce yourself here.</h1><h3>You can use HTML (H1-H6) to adjust text size.</h3><h4>And change other options with Customizer: Click Here!</h4>', 'blogberry');?>
				</a>
			<?php else: ?>
				<h2><?php bloginfo( 'description' ); ?></h2>
			<?php endif; ?>
		<?php endif; ?>
	</div>
<?php endif; ?>


<?php if ( have_posts() ) : ?>

	<?php if ( is_tag() || is_category() || is_day() || is_month() || is_year() || is_search() ) : ?> 
		<header><?php the_archive_title( '<h1 class="page-title title">', '</h1>' );?></header>
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

							<div class="meta"><i class="fa fa-calendar"> <?php the_time(get_option( 'date_format' )); ?></i></div><!--meta-->

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