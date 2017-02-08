<?php

if (is_front_page()) {
  get_template_part('templates/quick-links');
}

?>

<?php get_template_part('templates/page-header'); ?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content-excerpt'); ?>
<?php endwhile; ?>
