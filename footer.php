			</div><!-- #torso -->
			<footer id="colophon" class="site-footer" role="contentinfo">
				<div class="site-info"><?php echo hgnm_copyright(); ?></div>
			</footer>
		</div><!-- #page -->

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?php _e (get_stylesheet_directory_uri() . '/js/vendor/jquery-1.11.0.min.js'); ?>"><\/script>')</script>
		<!-- Commented out to stop double load during development
		<script src="<?php _e (get_stylesheet_directory_uri() . '/js/main.js'); ?>"></script>
		<script src="<?php _e (get_stylesheet_directory_uri() . '/js/plugins.js'); ?>"></script>
		-->
		
				<!-- Extra calls for development purposes (links to stylesheets etc. when accessing localhost remotely) -->
				<script src="<?php _e (home_url('/wp-content/themes/hgnm-2014/js/main.js')); ?>"></script>
				<script src="<?php _e (home_url('/wp-content/themes/hgnm-2014/js/plugins.js')); ?>"></script>
				<!-- End dev calls -->
				
		<script>
			if( $('.popup-gallery').length ) {
				$(document).ready(function() {
					$('.popup-gallery').magnificPopup({
						delegate: 'a',
						type:'image',
						gallery:{enabled:true},
						disableOn: 720,
						zoom: { enabled:true, duration: 200 },
						preload: [1,3]
					});
				});
			}
		</script>
		
		<?php wp_footer(); ?>
	</body>
</html>