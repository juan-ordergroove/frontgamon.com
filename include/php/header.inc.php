<?php
require_once('HtmlControl/HtmlTable.inc.php');
require_once('HtmlControl/HtmlDiv.inc.php');
require_once('HtmlControl/HtmlImage.inc.php');
require_once('HtmlControl/HtmlAnchor.inc.php');
require_once('HtmlControl/HtmlSpan.inc.php');

$span = new HtmlSpan('menu-home');
$anchor = new HtmlAnchor();

$menuTable = new HtmlTable('menu');
$menuTable->SetTableAttribute('cellspacing', '0');
$menuTable->SetTableAttribute('align', 'center');

$col = 1;
$i = $menuTable->AddRow();
$menuTable->SetCellStyle($i, $col, "background: url(/images/title-bar-left.gif) repeat-x;");
$menuTable->SetCellContent($i, $col++, '');

$anchor->href = 'index.php';
$anchor->title = 'Home';
$span->value = $anchor->Render(false);
$menuTable->SetCellContent($i, $col, $span->Render(false));
$menuTable->SetCellAttribute($i, $col, 'class', 'captionText');
$menuTable->SetCellStyle($i, $col++, "padding: 2px 20px;");

$anchor->href = 'comics.php';
$anchor->title = 'Comics';
$span->id = 'menu-comic';
$span->value = $anchor->Render(false);
$menuTable->SetCellContent($i, $col, $span->Render(false));
$menuTable->SetCellStyle($i, $col, "text-align: center; padding: 2px 20px;");
$menuTable->SetCellAttribute($i, $col++, 'class', 'captionText');

$anchor->href = 'articles.php';
$anchor->title = 'Articles';
$span->id = 'menu-articles';
$span->value = $anchor->Render(false);
$menuTable->SetCellContent($i, $col, $span->Render(false));
$menuTable->SetCellStyle($i, $col, "text-align: center; padding: 2px 20px;");
$menuTable->SetCellAttribute($i, $col++, 'class', 'captionText');

$anchor->href = 'about.php';
$anchor->title = 'About Us';
$span->id = 'menu-about';
$span->value = $anchor->Render(false);
$menuTable->SetCellContent($i, $col, $span->Render(false));
$menuTable->SetCellStyle($i, $col, "text-align: center; padding: 2px 20px;");
$menuTable->SetCellAttribute($i, $col++, 'class', 'captionText');

$anchor->href = 'contact.php';
$anchor->title = 'Contact Us';
$span->id = 'menu-contact';
$span->value = $anchor->Render(false);
$menuTable->SetCellContent($i, $col, $span->Render(false));
$menuTable->SetCellStyle($i, $col, "text-align: center; padding: 2px 20px;");
$menuTable->SetCellAttribute($i, $col++, 'class', 'captionText');

$menuTable->SetCellStyle($i, $col, "background: url(/images/title-bar-right.gif);");
$menuTable->SetCellContent($i, $col++, '&nbsp;');

$headerImg = new HtmlImage();
$headerImg->src = IMAGES_DIR . "header.gif";

$spacer = new HtmlImage();
$spacer->height = '8';
$spacer->src = IMAGES_DIR . "spacer.gif";
$spacer->styles['display'] = 'block';

$headerDiv = new HtmlDiv('header');
$headerDiv->styles['text-align'] = 'center';
$headerDiv->value = $headerImg->Render(false);
$headerDiv->value .= $spacer->Render(false) ;

$spacer->height = '15';
$headerDiv->value .= $menuTable->Render(false); 
$headerDiv->value .= $spacer->Render(false);
$headerDiv->Render();
?>
