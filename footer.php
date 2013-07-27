<?php if ( is_active_sidebar( 'seed-sidebar-foot' ) ) : ?>
<div id="foot-widgets">
<ul id="foot-widget"><?php dynamic_sidebar( 'seed-sidebar-foot' ); ?></ul>
</div>
<?php endif; ?>
</div><!--content-->

<footer id="foot" role="contentinfo">
<div class="credit"> 
	Powered by <a href="http://www.wordpress.org" target="_blank">WordPress</a> and <a href="http://SeedThemes.com" target="_blank">SeedThemes</a>
</div><!--credit-->
<div class="copyright">
	Copyright &copy; <?php echo date("Y"); ?>, <?php bloginfo( 'name' ); ?>, all rights reserved.
</div><!--copyright-->	
</footer>
</div><!--main-->
</div><!--page-->
<?php wp_footer(); ?>
<?php blogberry_footer(); ?>
</body>
</html>