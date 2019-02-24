      </main><!-- #torso -->
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

    <script src="https://polyfill.io/v2/polyfill.min.js?features=IntersectionObserver"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/lozad/dist/lozad.min.js"></script>
    <script type="text/javascript">
        const observer = lozad();
        observer.observe();
    </script>

    <?php wp_footer(); ?>
  </body>
</html>
