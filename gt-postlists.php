<?php
/*Plugin Name: GT: Post Lists*/
/*Plugin URI: http://generalthings.com*/
/*Version: 1.0*/
/*Author: Jeremy Linder*/

class GTPostLists {

  private function generic_template($page_type) {
    if (!in_array($page_type, array("post")))
      $page_type = "single";
      
    return dirname(__FILE__) . "/templates/single.php";
  }
  
  // This function wil find if the user made a custom template for the list / page_type
  private function find_template($page_type = 'single', $list_name = false) {
    // First, check for the theme directory for the plugin
    $theme = get_theme_root() . '/' . get_template();
    if (!is_dir($theme))
      return $this->generic_template($page_type);
    
    $theme .= "/plugins";
    if (!is_dir($theme))
      return $this->generic_template($page_type);
      
    $theme .= "/gt-postlists";
    if (!is_dir($theme))
      return $this->generic_template($page_type);
    
    /**
      * Now, we'll check in order of specifity.
      * From highest priority to lowest:
      * list_name = LN, page_type = PT
      *
      *   1. LN.PT.php
      *   2. LN.single.php
      *   3. PT.php
      *   4. single.php
      */
   
    if ($list_name) {
      $temp = $theme . "/" . $list_name . "." . $page_type . ".php";
      if (file_exists($temp))
        return $temp;
      
      $temp = "$theme/$list_name.single.php";
      if (file_exists($temp))
        return $temp;
    }
    
    $temp = $theme . "/" . $page_type . ".php";
    if (file_exists($temp))
      return $temp;
      
    $temp = "$theme/single.php";
    if (file_exists($temp))
      return $temp;
      
    return $this->generic_template($page_type);
  }
  
  private function get_options($opts) {
    $attr = array();
    // Includes
    if ( array_key_exists('include', $opts)) {
      $attr['include'] = explode(',', preg_replace('/[^0-9,]/', '', $opts['include']));
    }
    
    // Excludes
    if ( array_key_exists('exclude', $opts)) {
      $attr['exclude'] = explode(',', preg_replace('/[^0-9,]/', '', $opts['exclude']));
    }
    
    // Parent
    if ( array_key_exists('parent', $opts)) {
      $attr['post_parent'] = $opts['parent'];
    }
    
    // Type
    if ( array_key_exists('type', $opts)) {
      $attr['post_type'] = $opts['type'];
    } 
    
    // Size
    if ( array_key_exists('size', $opts)) {
      $attr['numberposts'] = $opts['size'];
    } else 
      $attr['numberposts'] = -1;
    
    // Meta Key
    if ( array_key_exists('meta_key', $opts)) {
      $attr['meta_key'] = $opts['meta_key'];
    }
    
    // Meta Value
    if ( array_key_exists('meta_value', $opts)) {
      $attr['meta_value'] = $opts['meta_value'];
    }
    
    // Order
    // TODO: Smarter Ordering
    if ( array_key_exists('orderby', $opts)) {
      $attr['orderby'] = $opts['orderby'];
    }
    if ( array_key_exists('order', $opts)) {
      $attr['order'] = $opts['order'];
    }
    
    // Categories
    if ( array_key_exists('category', $opts)) {
      $categories = explode(',', $opts['category']);
      foreach($categories as $i=>$cat) {
        if (is_numeric($cat))
          continue;
          
        $cat = get_category_by_slug($cat);
        if (!$cat)
          unset($categories[$i]);
        else
          $categories[$i] = $cat->term_id;
      }     
      
      $attr['category'] = '' . implode(',', $categories);
    }
    
    $attr = apply_filters("gt-postlist-options", $attr, $opts); 
    return $attr;
  }
  
  public function do_template() {
    global $post;
    include $this->find_template($post->post_type, $this->list_id);
  }
  
  public function do_shortcode($opts) {
    $this->list_id = false;
    global $post;
    $current_post = $post;
    $this->posts = get_posts($this->get_options($opts));
    ob_start();
    include( dirname(__FILE__) . "/templates/list.php");
    $out = ob_get_clean();
    
    $post = $current_post;
    return $out;
  }

}

global $gt_postlist;
$gt_postlist = new GTPostLists;

function gt_postlist($opts = false) {
  global $gt_postlist;
  if (!$opts) $opts = array();
  return $gt_postlist->do_shortcode($opts);
}

add_shortcode("gt-postlist", "gt_postlist");