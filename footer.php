      </div><!-- #torso -->
      <footer id="colophon" class="site-footer">
        <div class="site-info"><?= component('copyright'); ?> • <a href="<?php echo admin_url(); ?>">Login</a></div>
      </footer>
    </div><!-- #page -->

    <script src="<?php _e(get_stylesheet_directory_uri() . '/js/main.js'); ?>"></script>
    <script src="<?php _e(get_stylesheet_directory_uri() . '/js/vendor/baguetteBox-1.10.0.min.js'); ?>"></script>

    <script>
      var galleries = document.querySelectorAll('.popup-gallery')
      if(galleries.length) {
        ready(function () {
          baguetteBox.run('.popup-gallery', {
            async: true
          })
        });
      }
      // var mapPopups = document.querySelectorAll('.map-popup')
      // if(mapPopups.length) {
      //   ready(function() {
      //     $('.map-popup').magnificPopup({
      //       delegate: 'a',
      //       type:'iframe',
      //       disableOn: 720,
      //       iframe: {
      //         patterns: {
      //           gmaps: {
      //               index: 'google.com/maps',
      //               src: 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d11789.547215682222!2d-71.1170215!3d42.3769058!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e3774164253f4d%3A0x4139366065ac28ee!2sMusic+Building!5e0!3m2!1sen!2sus!4v1410030676671'
      //             }
      //         }
      //       }
      //     });
      //   });
      // }
    </script>

    <?php wp_footer(); ?>
  </body>
</html>
