<?php

namespace Roots\Sage\Nav\Walkers;

use Walker_Nav_Menu;

class ButtonNavWalker extends Walker_Nav_Menu {
  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    $html = '';
    parent::start_el($html, $item, $depth, $args, $id);
    $html = preg_replace('/<\/?li.*?>/i', '', $html);

    $link_classes = array();
    $link_classes[] = 'btn btn-default';
    $html = preg_replace('/<a (.*?)>/', '<a $1 class="' . implode(' ', $link_classes) . '">', $html);

    $output .= $html;
  }

  function end_el(&$output, $item, $depth = 0, $args = array()) {
    $html = '';
    parent::end_el($html, $item, $depth, $args);
    $html = preg_replace('/<\/?li.*?>/i', '', $html);
    $output .= $html;
  }

  function start_lvl(&$output, $depth = 0, $args = array()) {
    return;
  }

  function end_lvl(&$output, $depth = 0, $args = array()) {
    return;
  }
}
