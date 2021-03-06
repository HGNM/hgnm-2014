<?php
get_header();
?>

<article id="404" class="404-error member type-member status-publish has-post-thumbnail p-section no-primary">
  <h2 class="post-title fname entry-title">404</h2>
  <section class="secondary clearfix">
    <h3>Oops! Sorry, that page doesn’t exist…</h3>
    <div class="featured-img">
      <img src="<?php echo get_bloginfo('template_directory') ?>/img/404.gif" alt="Sad cat">
    </div>
  </section>
  <section class="composers-link">
    <?= component('button_link', array(
      'href' => esc_url(home_url('/')),
      'html' => 'Back to the home page »',
      'attrs' => array(
        'rel' => 'home'
      )
    )) ?>
  </section>
</article>

<?php
get_footer();
?>
