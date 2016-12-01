<?php
/**
 * Class to generate breadcrumb navigation
 */

namespace Roots\Sage\Nav;

use WP_Post;
use WP_Term;

class Breadcrumbs {
  /**
   * @var WP_Post
   */
  protected $post = null;

  /**
   * @var array
   */
  protected $trail = array();

  /**
   * Roots_Breadcrumbs constructor.
   *
   * @param WP_Post|null $post
   */
  public function __construct($post = null) {
    if (is_null($post)) {
      $post = get_post();
    }
    $this->post = $post;
  }

  public function get_crumbs() {
    $trail = $this->get_trail();
    $crumbs = array();

    foreach ($trail as $item) {
      switch (get_class($item)) {
        case 'WP_Post':
          $crumbs[] = array(
            'title' => get_the_title($item),
            'url' => get_permalink($item),
          );
          break;

        case 'WP_Term':
          $crumbs[] = array(
            'title' => $item->name,
            'url' => get_term_link($item),
          );
          break;

        case 'stdClass':
          $crumbs[] = array(
            'title' => $item->title,
            'url' => $item->url,
          );
          break;
      }
    }

    return $crumbs;
  }

  public function get_trail() {
    $this->trail = array();

    $this->add_front_page();

    if (is_page()) {
      $this->add_page_trail();
    }
    else if (is_single()) {
      $this->add_single();
    }
    else if (is_category()) {
      $this->add_category();
    }
    else if (is_404()) {
      $this->add_404();
    }

    return $this->trail;
  }

  public function add_front_page() {
    if (get_option('show_on_front') == 'page') {
      $front_page_id = get_option( 'page_on_front' );
      $this->trail[] = get_post( $front_page_id );
    }
    else {
      $this->trail[] = (object) array(
        'title' => 'Home',
        'url' => get_home_url(),
      );
    }
  }

  public function add_404() {
    $this->trail[] = (object) array(
      'title' => 'Page not found',
      'url' => $_SERVER['REQUEST_URI'],
    );
  }

  public function add_page_trail() {
    $ancestors = $this->post->ancestors;
    $ancestors = array_reverse($ancestors);

    foreach ($ancestors as $ancestor) {
      $this->trail[] = get_post($ancestor);
    }

    $this->trail[] = $this->post;
  }

  public function add_single() {
    $categories = get_the_category($this->post->ID);

    // Remove 'uncategorized' category
    $categories = array_filter($categories, function($category) {
      return ( $category->slug !== 'uncategorized' );
    });

    if (count($categories) > 0) {
      $category = $categories[0];

      $parent = $this->__get_parent_for_category($category);
      if ($parent) {
        $this->trail[] = $parent;
        $category->name = 'News';
      }

      $this->trail[] = $category;
    }

    $this->trail[] = $this->post;
  }

  public function add_category() {
    $category = get_queried_object();

    $parent = $this->__get_parent_for_category($category);
    if ($parent) {
      $this->trail[] = $parent;
      $category->name = 'News';
    }

    $this->trail[] = $category;
  }

  /**
   * @param WP_Term $category
   * @return WP_Post|false
   */
  protected function __get_parent_for_category($category) {
    $pages = new WP_Query(array(
      'post_type' => 'page',
      'post_status' => 'publish',
      'posts_per_page' => 1,
      'meta_key' => 'news-category',
      'meta_value' => $category->slug,
    ));

    if ($pages->post_count > 0) {
      return $pages->post;
    }
    else {
      return false;
    }
  }
}
