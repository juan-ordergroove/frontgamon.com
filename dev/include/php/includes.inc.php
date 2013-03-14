<?php
require_once('yui.inc.php');

if (!isset($js_include))
  $js_include = array();

if (isset($jQuery_include))
  $js_include = array_merge($js_include, $jQuery_include);
if (isset($yui_include))
  $js_include = array_merge($js_include, $yui_include);

if (isset($js_include))
  foreach ($js_include as $script)
    echo "<script type='text/javascript' src='{$script}'></script>\n";

$css_include[] = CSS_INCLUDE_DIR . 'styles.css';
if (isset($css_include))
{
  foreach ($css_include as $stylesheet)
    echo "<link type='text/css' rel='STYLESHEET' href='{$stylesheet}'>\n";
}
?>
