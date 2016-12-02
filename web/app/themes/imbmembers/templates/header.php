<?php use Roots\Sage\Nav; ?>

<header class="banner navbar navbar-default navbar-fixed-top" role="banner">
  <div class="container">
    <div class="navbar-header">

      <button type="button" class="sidebar-toggle menu-toggle">
        <div class="menu-toggle__hamburger">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <div class="menu-toggle__cross">
          <span></span>
          <span></span>
        </div>
      </button>

      <a class="navbar-brand" href="<?= esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>
    </div>

    <nav class="collapse navbar-collapse" role="navigation">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My Account <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Change my password</a></li>
            <li class="divider"></li>
            <li><a href="<?= wp_logout_url(); ?>">Logout</a></li>
          </ul>
        </li>
      </ul>
      <div class="navbar-form navbar-right">
        <?php get_template_part('templates/searchform'); ?>
      </div>
    </nav>
  </div>
</header>
