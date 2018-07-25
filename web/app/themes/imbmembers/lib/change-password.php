<?php

namespace Roots\Sage\ChangePassword;

use \WP_Query;

/**
 * Get the 'Change Password' page
 * This is determined as the page which uses the 'change-password.php' template.
 *
 * @return \WP_Post
 */
function get_page()
{
    $query = new WP_Query([
        'post_type' => 'page',
        'meta_key' => '_wp_page_template',
        'meta_value' => 'change-password.php',
        'posts_per_page' => 1,
    ]);
    return $query->post;
}
