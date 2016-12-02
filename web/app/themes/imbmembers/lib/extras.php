<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Config;

/**
 * Don't show admin bar for subscribers.
 */
function show_admin_bar() {
  return !current_user_can('subscriber');
}
add_filter('show_admin_bar', __NAMESPACE__ . '\\show_admin_bar');

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Config\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

/**
 * Filter media library items to those belonging to the current user,
 * if the user cannot edit others' posts.
 *
 * @param $wp_query
 * @return mixed
 */
function limit_media_library_to_own_items($wp_query) {
  if (is_admin() && $wp_query->get('post_type') == 'attachment' && !current_user_can('edit_others_posts')) {
      $wp_query->set('author', get_current_user_id());
  }
  return $wp_query;
}
add_filter('parse_query', __NAMESPACE__ . '\\limit_media_library_to_own_items');

/**
 * Configure 'Force Strong Passwords' plugin to only enforce
 * strong passwords for users with the returned capabilities.
 *
 * @param array $caps
 * @return array
 */
function fsp_caps_check($caps) {
  return array(
    'update_core',
  );
}
add_filter('slt_fsp_caps_check', __NAMESPACE__ . '\\fsp_caps_check');

/**
 * Redirect users to the frontend after login, unless a redirect URL
 * was specified.
 */
function login_redirect($redirect_to, $requested_redirect_to, $user) {
  if (get_class($user) == 'WP_User') {
    if (strpos($requested_redirect_to, '/wp-admin/') !== false) {
      $redirect_to = get_home_url();
    }
  }
  return $redirect_to;
}
add_filter('login_redirect', __NAMESPACE__ . '\\login_redirect', 10, 3);

/**
 * Make oEmbed embedded videos responsive using bootstrap's embed-responsive
 * component.
 *
 * @param string $html
 * @return string
 */
function wrap_embed_with_div($html) {
  $tags = array('<iframe ', '<embed ', '<video ', '<object ');
  foreach ($tags as $tag) {
    if (stripos($html, $tag) !== false) {
      return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
    }
  }
  return $html;
}
add_filter('embed_oembed_html', __NAMESPACE__ . '\\wrap_embed_with_div');

/**
 * Don't allow subscribers to access wp-admin
 */
function disable_wp_admin_for_subscribers() {
  if (current_user_can('subscriber') && (!defined('DOING_AJAX') || !DOING_AJAX)) {
    wp_redirect(home_url());
    exit;
  }
}
add_action('admin_init', __NAMESPACE__ . '\\disable_wp_admin_for_subscribers');

/**
 * Show all posts at once for archive and search results pages.
 * Sets posts_per_page to -1.
 *
 * @param $query
 */
function show_all_posts($query) {
  if ($query->is_main_query() && !is_admin() && ($query->is_archive() || $query->is_search()) ) {
    $query->set('posts_per_page', '-1');
  }
}
add_action('pre_get_posts', __NAMESPACE__ . '\\show_all_posts');

function nicer_archive_title($title) {
  if (is_month()) {
    $title = get_the_date(_x('F Y', 'monthly archives date format'));
  }

  if (is_year()) {
    $title = get_the_date(_x('Y', 'yearly archives date format'));
  }

  return 'News from ' . $title;
}
add_filter('get_the_archive_title', __NAMESPACE__ . '\\nicer_archive_title');

/**
 * Filter HTML output of Breadcrumb Trail plugin to make them use the
 * bootstrap breadcrumbs component.
 */
function make_breadcrumbs_bootstrap($html) {
  $html = str_replace('<h2 class="trail-browse"></h2>', '', $html);
  $html = str_replace('<ul class="trail-items"', '<ol class="trail-items breadcrumb"', $html);
  return $html;
}
add_filter('breadcrumb_trail', __NAMESPACE__ . '\\make_breadcrumbs_bootstrap');
