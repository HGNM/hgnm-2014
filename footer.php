      </div><!-- #torso -->
      <footer id="colophon" class="site-footer">
        <div class="site-info"><?= component('hgnm_copyright'); ?> • <a href="<?php echo admin_url(); ?>">Login</a></div>
      </footer>
    </div><!-- #page -->

    <script src="<?php _e(get_stylesheet_directory_uri() . '/js/main.js'); ?>"></script>
    <?= component('analytics') ?>
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
    </script>

    <?php wp_footer(); ?>
  </body>
</html>
