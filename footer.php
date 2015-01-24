			</div><!-- #torso -->
			<footer id="colophon" class="site-footer" role="contentinfo">
				<div class="site-info"><?php echo hgnm_copyright(); ?> • <a href="<?php echo admin_url(); ?>">Login</a></div>
			</footer>
		</div><!-- #page -->

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="<?php _e (get_stylesheet_directory_uri() . '/js/vendor/jquery-1.11.0.min.js'); ?>"><\/script>')</script>

		<script src="<?php _e (get_stylesheet_directory_uri() . '/js/main.js'); ?>"></script>
		<script src="<?php _e (get_stylesheet_directory_uri() . '/js/plugins.js'); ?>"></script>
				
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
			if( $('.map-popup').length ) {
				$(document).ready(function() {
					$('.map-popup').magnificPopup({
						delegate: 'a',
						type:'iframe',
						disableOn: 720,
						iframe: {
							patterns: {
								gmaps: {
							      index: 'google.com/maps',
							      src: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d11789.547215682222!2d-71.1170215!3d42.3769058!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e3774164253f4d%3A0x4139366065ac28ee!2sMusic+Building!5e0!3m2!1sen!2sus!4v1410030676671'
							    }
							}
						}
					});
				});
			}
		</script>
		
		<?php wp_footer(); ?>
	</body>
</html>