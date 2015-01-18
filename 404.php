<?php get_header(); ?>

<div id="content" class="full" role="main">
	<article id="post-0" class="post error404 no-results not-found">
		<header>
			<h1 class="title"><?php printf( __('This is somewhat embarrassing, isn&rsquo;t it?','blogberry')); ?></h1>
		</header>
		<div class="entry">
			<p><?php printf( __('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.' ,'blogberry')); ?></p>
			<?php get_search_form(); ?>
		</div><!--entry-->
	</article>
</div><!--content-->

<?php get_footer(); ?>