<?php
if (isset($yui_include))
{
  $yui_js = array();
  $yui_css = array();

  foreach ($yui_include as $yui_obj)
  {
  switch($yui_obj) {
    case 'connection':
      $yui_js[] = JS_INCLUDE_DIR . 'yui/yahoo/yahoo-min.js';
      $yui_js[] = JS_INCLUDE_DIR . 'yui/event/event-min.js';
      $yui_js[] = JS_INCLUDE_DIR . 'yui/connection/connection-min.js';
      break;
    case 'menu':
      $yui_js[] = JS_INCLUDE_DIR . 'yui/yahoo-dom-event/yahoo-dom-event.js';
      $yui_js[] = JS_INCLUDE_DIR . 'yui/container/container_core-min.js';
      $yui_js[] = JS_INCLUDE_DIR . 'yui/menu/menu-min.js';
  
      $yui_css[] = JS_INCLUDE_DIR .'yui/menu/assets/skins/sam/menu.css';
      break;
    case 'dom':
      $yui_js[] = JS_INCLUDE_DIR . 'yui/yahoo/yahoo-min.js';
      $yui_js[] = JS_INCLUDE_DIR .'yui/dom/dom-min.js';
      break;
    }
  }

  $yui_js = array_unique($yui_js);
  $yui_css = array_unique($yui_css);

  $yui_include = $yui_js;

  if (isset($css_include))
    $css_include = array_merge($css_include, $yui_css);
  else
    $css_include = $yui_css;
}
?>
