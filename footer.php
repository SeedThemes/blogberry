<?php if ( is_active_sidebar( 'sidebar-foot' ) ) : ?>
<div id="foot-widgets">
<ul id="foot-widget"><?php dynamic_sidebar( 'sidebar-foot' ); ?></ul>
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
<script src="<?php echo get_template_directory_uri(); ?>/seed-core/js/vendor/bootstrap.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/seed-custom/js/main.js"></script>
<?php wp_footer(); ?>
</body>
</html>