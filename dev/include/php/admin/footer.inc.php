<?php
require_once (PHP_DEV . 'HtmlControl/HtmlDiv.inc.php');
require_once (PHP_DEV . 'HtmlControl/HtmlAnchor.inc.php');
require_once (PHP_DEV . 'HtmlControl/HtmlImage.inc.php');

$spacer = new HtmlImage('spacer');
$spacer->src = '/images/spacer.gif';
$spacer->height = 15;
$spacer->Render();

$anchor = new HtmlAnchor();
$anchor->href = '/admin/logout.php';
$anchor->title = 'Logout';

$div = new HtmlDiv('logout');
$div->styles['text-align'] = 'center';
$div->value = $anchor->Render(false);
$div->Render();
?>
