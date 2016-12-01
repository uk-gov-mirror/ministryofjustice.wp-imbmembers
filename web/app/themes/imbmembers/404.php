<article <?php post_class('entry'); ?>>
  <div class="entry-wrapper">
    <header>
      <?php get_template_part('templates/page', 'header'); ?>
    </header>
    <div class="entry-content">
      <div class="alert alert-warning">
        <?php _e('Sorry, but the page you were trying to view does not exist.', 'sage'); ?>
      </div>
    </div>
  </div>
</article>
