<?php

use Roots\Sage\ChangePassword;

$changePassword = ChangePassword\get_page();
$user = wp_get_current_user();

?>

<div class="search d-md-none d-lg-none d-sm-none">
    <?php get_template_part('templates/searchform'); ?>
</div>
<nav class="widget widget_menu">
    <?php

    if (has_nav_menu('primary_navigation')) {
        wp_nav_menu(array(
            'theme_location' => 'primary_navigation',
            'walker' => new \Roots\Sage\Nav\Walkers\TreeNavWalker(),
        ));
    }

    ?>
</nav>
<hr class="d-md-none d-lg-none d-sm-none">
<div class="widget widget_logout d-md-none d-lg-none d-sm-none">
    <p class="text-center"><?= esc_html("{$user->user_firstname} {$user->user_lastname}") ?></p>
    <a href="<?= get_the_permalink($changePassword) ?>" class="btn btn-block btn-link"><span
            class="glyphicon glyphicon-lock" aria-hidden="true"></span> <?= get_the_title($changePassword) ?></a>
    <a href="<?= wp_logout_url() ?>" class="btn btn-block btn-link"><span class="glyphicon glyphicon-log-out"
                                                                          aria-hidden="true"></span> Logout</a>
</div>
