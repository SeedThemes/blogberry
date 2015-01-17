<?php if ( is_active_sidebar( 'seed-sidebar-foot' ) ) : ?>
<div id="foot-widgets">
<ul id="foot-widget"><?php dynamic_sidebar( 'seed-sidebar-foot' ); ?></ul>
</div>
<?php endif; ?>
</div><!--content-->

<footer id="foot" role="contentinfo">
<div class="credit"> 
	<?php powered_blogberry(); ?>
</div><!--credit-->
<div class="copyright">
	<?php copyright_blogberry(); ?>
</div><!--copyright-->	
</footer>
</div><!--main-->
</div><!--page-->
<?php wp_footer(); ?>
<?php blogberry_footer(); ?>
</body>
</html>