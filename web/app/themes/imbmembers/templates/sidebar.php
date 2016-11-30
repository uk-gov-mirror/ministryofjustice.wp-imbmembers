<div class="search hidden-md hidden-lg hidden-sm">
  <?php get_template_part('templates/searchform'); ?>
</div>
<nav class="widget widget_menu">
  <?php

  if (has_nav_menu('primary_navigation')) {
    wp_nav_menu(array(
      'theme_location' => 'primary_navigation',
      'walker'         => new \Roots\Sage\Nav\Walkers\TreeNavWalker(),
    ));
  }

  ?>
</nav>
