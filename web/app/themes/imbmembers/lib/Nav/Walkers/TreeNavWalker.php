<?php

namespace Roots\Sage\Nav\Walkers;

use Walker_Nav_Menu;
use Roots\Sage\Utils;

class TreeNavWalker extends Walker_Nav_Menu {
  private $cpt; // Boolean, is current post a custom post type
  private $archive; // Stores the archive page for current URL

  public function __construct() {
    add_filter('nav_menu_css_class', array($this, 'cssClasses'), 10, 2);
    add_filter('nav_menu_item_id', '__return_null');
    $cpt           = get_post_type();
    $this->cpt     = in_array($cpt, get_post_types(array('_builtin' => false)));
    $this->archive = get_post_type_archive_link($cpt);
    add_filter('wp_nav_menu_args', array($this, 'nav_menu_args'));
  }

  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    $item_html = '';
    parent::start_el($item_html, $item, $depth, $args, $id);

    $link_classes = array();
    $link_classes[] = 'tree-link';
    $item_html = preg_replace('/<a (.*?)>/', '<a $1 class="' . implode(' ', $link_classes) . '">', $item_html);

    if ($item->is_dropdown) {
      $item_html = preg_replace('/<a (.*?)>/', '<a href="#" class="toggle-children"><i class="fa fa-caret-right" aria-hidden="true"></i></a><a $1>', $item_html);
    }

    $output .= $item_html;
  }

  function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
    $element->is_dropdown = ((!empty($children_elements[$element->ID]) && (($depth + 1) < $max_depth || ($max_depth === 0))));

    if ($element->is_dropdown) {
      $element->classes[] = 'has-children';

      foreach ($children_elements[$element->ID] as $child) {
        if ($child->current_item_parent || Utils\url_compare($this->archive, $child->url)) {
//          $element->classes[] = 'active';
        }
      }
    }

    $element->is_active = strpos($this->archive, $element->url);

    if ($element->is_active) {
//      $element->classes[] = 'active';
    }

    parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
  }

  public function cssClasses($classes, $item) {
    $slug = sanitize_title($item->title);

    if ($this->cpt) {
      $classes = str_replace('current_page_parent', '', $classes);

      if (Utils\url_compare($this->archive, $item->url)) {
//        $classes[] = 'active';
      }
    }

    $classes = str_replace('current-menu-item', 'active', $classes);
    $classes = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'disableactive', $classes);
    $classes = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);

    $classes[] = 'menu-' . $slug;

    $classes = array_unique($classes);

    return array_filter($classes, 'Roots\\Sage\\Utils\\is_element_empty');
  }

  /**
   * Clean up wp_nav_menu_args
   *
   * Remove the container
   * Remove the id="" on nav menu items
   *
   * @param array $args
   * @return array
   */
  function nav_menu_args($args = array()) {
    $menu_class = isset($args['menu_class']) ? $args['menu_class'] : '';

    $menu_class .= ' tree tree-no-js';

    $args['menu_class'] = $menu_class;

    return $args;
  }
}
