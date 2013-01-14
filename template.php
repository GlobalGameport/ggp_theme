<?php

/**
 * Preprocess and Process Functions SEE: http://drupal.org/node/254940#variables-processor
 * 1. Rename each function and instance of "adaptivetheme_subtheme" to match
 *    your subthemes name, e.g. if you name your theme "footheme" then the function
 *    name will be "footheme_preprocess_hook". Tip - you can search/replace
 *    on "adaptivetheme_subtheme".
 * 2. Uncomment the required function to use.
 */

/**
 * Override or insert variables into the html templates.
 */
function ggp_theme_preprocess_html(&$vars) {
  // Load the media queries styles
  // Remember to rename these files to match the names used here - they are
  // in the CSS directory of your subtheme.
  $media_queries_css = array(
    'ggp_theme.responsive.style.css',
    'ggp_theme.responsive.gpanels.css'
  );
  load_subtheme_media_queries($media_queries_css, 'ggp_theme');

 // Load Layout CSS
  global $theme;
  $path = "public://at_css";

  $responsive_css = $theme . '_responsive_background_file_css';
  $file = variable_get($responsive_css);

  // Load the Responsive layout
  if (!empty($file)) {
    $filepath = $path . '/' . $file;
    if (file_exists($filepath)) {
      drupal_add_css($filepath, array(
        'preprocess' => variable_get('preprocess_css', '') == 1 ? TRUE : FALSE,
        'group' => CSS_THEME,
        'media' => 'all',
        'every_page' => TRUE,
        'weight' => 1000,
        )
      );
    }
  }
 /**
  * Load IE specific stylesheets
  * AT automates adding IE stylesheets, simply add to the array using
  * the conditional comment as the key and the stylesheet name as the value.
  *
  * See our online help: http://adaptivethemes.com/documentation/working-with-internet-explorer
  *
  * For example to add a stylesheet for IE8 only use:
  *
  *  'IE 8' => 'ie-8.css',
  *
  * Your IE CSS file must be in the /css/ directory in your subtheme.
  */
  /* -- Delete this line to add a conditional stylesheet for IE 7 or less.
  $ie_files = array(
    'lte IE 7' => 'ie-lte-7.css',
  );
  load_subtheme_ie_styles($ie_files, 'ggp_theme');
  // */
}

 /*-- Delete this line if you want to use this function
function ggp_theme_process_html(&$vars) {

}
// */

/**
 * Override or insert variables into the page templates.
 */
/* -- Delete this line if you want to use these functions
function ggp_theme_preprocess_page(&$vars) {
}

function ggp_theme_process_page(&$vars) {
}
// */

/**
 * Override or insert variables into the node templates.
 */
/* -- Delete this line if you want to use these functions
function ggp_theme_preprocess_node(&$vars) {
}

function ggp_theme_process_node(&$vars) {
}
// */

/**
 * Override or insert variables into the comment templates.
 */
/* -- Delete this line if you want to use these functions
function ggp_theme_preprocess_comment(&$vars) {
}

function ggp_theme_process_comment(&$vars) {
}
// */

/**
 * Override or insert variables into the block templates.
 */
function ggp_theme_preprocess_block(&$vars) {
  if ($vars['block']->module == 'superfish' || $vars['block']->module == 'nice_menu') {
    $vars['content_attributes_array']['class'][] = 'clearfix';
  }
  if (!$vars['block']->subject) {
    $vars['content_attributes_array']['class'][] = 'no-title';
  }
  if ($vars['block']->region == 'menu_bar' || $vars['block']->region == 'top_menu') {
    $vars['title_attributes_array']['class'][] = 'element-invisible';
  }
}

function ggp_theme_process_block(&$vars) {
}
// */

/**
 * Add the Style Schemes if enabled.
 * NOTE: You MUST make changes in your subthemes theme-settings.php file
 * also to enable Style Schemes.
 */
/* -- Delete this line if you want to enable style schemes.
// DONT TOUCH THIS STUFF...
function get_at_styles() {
  $scheme = theme_get_setting('style_schemes');
  if (!$scheme) {
    $scheme = 'style-default.css';
  }
  if (isset($_COOKIE["atstyles"])) {
    $scheme = $_COOKIE["atstyles"];
  }
  return $scheme;
}
if (theme_get_setting('style_enable_schemes') == 'on') {
  $style = get_at_styles();
  if ($style != 'none') {
    drupal_add_css(path_to_theme() . '/css/schemes/' . $style, array(
      'group' => CSS_THEME,
      'preprocess' => TRUE,
      )
    );
  }
}
// */

/**
 * Override or insert variables into the field template.
 */
function ggp_theme_preprocess_field(&$vars) {
  $element = $vars['element'];
  $vars['classes_array'][] = 'view-mode-' . $element['#view_mode'];
  $vars['image_caption_teaser'] = FALSE;
  $vars['image_caption_full'] = FALSE;
  if (theme_get_setting('image_caption_teaser') == 1) {
    $vars['image_caption_teaser'] = TRUE;
  }
  if (theme_get_setting('image_caption_full') == 1) {
    $vars['image_caption_full'] = TRUE;
  }
  $vars['field_view_mode'] = '';
  $vars['field_view_mode'] = $element['#view_mode'];
}


/**
 * Returns HTML for a breadcrumb trail.
 */
function ggp_theme_breadcrumb($vars) {
  $breadcrumb = $vars['breadcrumb'];
  $show_breadcrumb = theme_get_setting('breadcrumb_display');
  if ($show_breadcrumb == 'yes') {
    $show_breadcrumb_home = theme_get_setting('breadcrumb_home');
    if (!$show_breadcrumb_home) {
      array_shift($breadcrumb);
    }
    if (!empty($breadcrumb)) {
      $heading = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
      $separator = filter_xss(theme_get_setting('breadcrumb_separator'));
      $output = '';
      foreach ($breadcrumb as $key => $val) {
        if ($key == 0) {
          $output .= '<li class="crumb">' . $val . '</li>';
        }
        else {
          $output .= '<li class="crumb"><span>' . $separator . '</span>' . $val . '</li>';
        }
      }
      $output .= '<li class="crumb"><span>' . $separator . '</span>' . drupal_get_title() . '</li>';
      return $heading . '<ol id="crumbs">' . $output . '</ol>';
    }
  }
  return '';
}
/**
 * Adds collapse to Menu.
 */
function ggp_theme_menu_link(array $variables) {
  // $cookieE = &drupal_static(__FUNCTION__);
  // $cookieC = &drupal_static(__FUNCTION__);
  $element = $variables['element'];
  $sub_menu = '';
  $collapse = '';
  $collapsed = false;


// // Parse the cookie, if it is enabled.
// if (!isset($cookieC) || !isset($cookieE)) {
//         $cookieE = explode(',', @$_COOKIE['Drupal_expanded_menus']);
//         $cookieC = explode(',', @$_COOKIE['Drupal_collapsed_menus']);
// }
  // If there are children, but they were not loaded, load them.
  if ($element['#original_link']['has_children'] && empty($element['#below'])) {
   $element['#below'] = _menu_subtree($element['#original_link']['menu_name'], $element['#original_link']['mlid']);
  }

  $element['#attributes']['id'] = 'menu-item-' . _unique_id($element['#original_link']['mlid']);

  // If the current item can expand, and is neither saved as open nor in the active trail, close it.
  if ($element['#original_link']['has_children'] && !$element['#original_link']['in_active_trail'] ) { //&& in_array($element['#attributes']['id'], $cookieC) && !in_array($element['#attributes']['id'], $cookieE)
    $variables['element']['#attributes']['class'][] = 'collapsed';
    $collapsed = true;
  }
  // if($collapsed == true && in_array($element['#attributes']['id'], $cookieE)){
  //   $collapsed == false;
  // }


  if ($element['#below']) {
    $collapse = (!$collapsed) ? '<span class="collapse"></span>': '<span class="expand"></span>';
    $sub_menu = drupal_render($element['#below']);
  }

  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>'. $collapse . $output . $sub_menu . "</li>\n";
}
/**
 * Traverses the menu tree and returns the sub-tree of the item
 * indicated by the parameter.
 *
 * @param $menu_name
 * The internal name of the menu.
 * @param $mlid
 * The menu link ID.
 *
 * @return
 * The tree below the menu item, as a renderable array, or an empty array.
 */
function _menu_subtree($menu_name, $mlid) {
  static $index = array();
  static $indexed = array();

  // This looks expensive, but menu_tree_all_data uses static caching.
  $tree = menu_tree_all_data($menu_name);

  // Index the menu tree to find ancestor paths for each item.
  if (!isset($indexed[$menu_name])) {
    $index += _menu_index($tree);
    $indexed[$menu_name] = TRUE;
  }
  // If the menu tree does not contain this item, stop.
  if (!isset($index[$mlid])) {
    return array();
  }


  // Traverse the tree using the ancestor path.
  foreach ($index[$mlid]['parents'] as $id) {
    $key = $index[$id]['key'];
    if (isset($tree[$key])) {
      $tree = $tree[$key]['below'];
    }
    else {
      return array();
    }
  }

  // Go one level further to go below the current item.
  $key = $index[$mlid]['key'];
  return isset($tree[$key]) ? menu_tree_output($tree[$key]['below']) : array();
}
function _menu_index($tree, $ancestors = array(), $parent = NULL) {
  $index = array();
  if ($parent) {
    $ancestors[] = $parent;
  }

  foreach ($tree as $key => $item) {
    $index[$item['link']['mlid']] = array(
      'key' => $key,
      'parents' => $ancestors,
    );
    if (!empty($item['below'])) {
      $index += _menu_index($item['below'], $ancestors, $item['link']['mlid']);
    }
  }
  return $index;
}
function _unique_id($id) {
  static $ids = array();
  if (!isset($ids[$id])) {
    $ids[$id] = 1;
    return $id;
  }
  else {
    return $id . '-' . $ids[$id]++;
  }
}


/**
* Override theme_media_gallery_item() - media_gallery/media_gallery.theme.inc
*/
function ggp_theme_media_gallery_item($variables) {
  $image = $variables['image'];
  $link_path = $variables['link_path'];
  $attributes = array();

  if (!empty($variables['classes'])) {
    $attributes['class'] = $variables['classes'];
  }
  if (!empty($variables['title'])) {
    $new_image = str_replace(array('title=""', 'alt=""'), array('', ''), $image);
    $image = str_replace('/>', ' title="'.$variables['title'].'" alt="'.$variables['title'].'" />', $new_image);;
  }

  // FANCYBOX HACK
  preg_match('|\/sites\/(.*)\/files\/styles\/media_gallery_thumbnail\/public\/([^\"]*)|', $image, $matches);
  $link_path = 'sites/'.$matches[1].'/files/styles/media_gallery_large/public/' . $matches[2];
  $attributes['class'][] = 'fancybox';
  $attributes['rel'][] = 'gallery';
  // FANCYBOX HACK
//}

  $item = '<div class="media-gallery-item"><div class="top"><div class="top-inset-1"><div class="top-inset-2"></div></div></div><div class="gallery-thumb-outer"><div class="gallery-thumb-inner">';
  $item .= empty($variables['no_link']) ? l($image, $link_path, array('html' => TRUE, 'attributes' => $attributes)) : $image;
  $item .= '</div></div><div class="bottom"><div class="bottom-inset-1"><div class="bottom-inset-2"></div></div></div></div>';
  return $item;
}
