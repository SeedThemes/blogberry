<?php if ( is_active_sidebar( 'seed-sidebar-foot' ) ) : ?>
	<div id="foot-widgets">
		<ul id="foot-widget"><?php dynamic_sidebar( 'seed-sidebar-foot' ); ?></ul>
	</div>
<?php endif; ?>
</div><!--content-->

<footer id="foot" role="contentinfo">
	<div class="credit"> 
		<a href="<?php echo esc_url('http://www.wordpress.org');?>" target="_blank"><?php printf( __( 'Powered by WordPress', 'blogberry' ) ); ?></a>
		&amp; 
		<a href="<?php echo esc_url('http://SeedThemes.com');?>" target="_blank"><?php printf( __( 'SeedThemes', 'blogberry' ) ); ?></a>

	</div><!--credit-->
	<div class="copyright">
		<p>
			<?php 
			if( get_theme_mod('copyright') != '' ){
				echo get_theme_mod('copyright');
			}else{ ?>
			&copy; <?php echo date("Y"); ?> <?php bloginfo( 'name' ); ?>, all rights reserved.
			<?php }
			?>
		</p>
	</div><!--copyright-->	
</footer>
</div><!--main-->
</div><!--page-->

<script type="text/javascript">
	jQuery(document).ready(function() {  

		jQuery('.menu-toggle').click(function() {
			jQuery('#mainnav').toggleClass('show');
		});
	});

</script>
<?php wp_footer(); ?>
</body>
</html>