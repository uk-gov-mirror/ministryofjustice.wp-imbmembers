<section class="widget widget_menu">
  <?php

  if (has_nav_menu('primary_navigation')) {
    wp_nav_menu(array(
      'theme_location' => 'primary_navigation',
      'walker'         => new \Roots\Sage\Nav\Walkers\TreeNavWalker(),
      'menu_class'     => 'tree',
//      'walker' => new wp_bootstrap_navwalker(),
    ));
  }

  ?>
</section>

<section class="widget widget_bug">
  <small>Spotted a bug? <a href="https://github.com/ministryofjustice/wp-weekly/issues" target="_blank">Report it here.</a></small>
</section>
