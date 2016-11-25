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
