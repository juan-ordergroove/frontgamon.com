<?php
require_once(PHP_DEV . 'HtmlControl/HtmlDiv.inc.php');
require_once(PHP_DEV . 'HtmlControl/HtmlImage.inc.php');
require_once(PHP_DEV . 'HtmlControl/HtmlTable.inc.php');
require_once(PHP_DEV . 'HtmlControl/HtmlAnchor.inc.php');

$headerTable = new HtmlTable('header-table');
$headerTable->SetTableAttribute('cellpadding', '0');
$headerTable->SetTableAttribute('cellspacing', '0');
$headerTable->SetTableAttribute('align', 'center');

$fgLogo = new HtmlImage('fg-logo');
$fgLogo->src = '/images/fg-logo.png';

$diceCup = new HtmlImage('dice-cup');
$diceCup->src = '/images/dice-cup.png';
$diceCup->styles['padding-left'] = '30px';

$dice = new HtmlImage('dice');
$dice->src = '/images/dice.png';

$menuTable = new HtmlTable('menu-table');
$menuTable->SetTableAttribute('cellpadding', '0');
$menuTable->SetTableAttribute('cellspacing', '0');
$menuTable->SetTableAttribute('align', 'right');
$menuTable->SetTableAttribute('width', '400');

$anchorHome = new HtmlAnchor('home');
$anchorHome->styles['font'] = 'Verdana';
$anchorHome->href = 'http://frontgamon.com';
$anchorHome->title = 'Home';

$anchorAbout = new HtmlAnchor('about-us');
$anchorAbout->styles['font'] = 'Verdana';
$anchorAbout->href = 'about.php';
$anchorAbout->title = 'About Us';

$anchorContact = new HtmlAnchor('contact-us');
$anchorContact->styles['font'] = 'Verdana';
$anchorContact->href = 'contact.php';
$anchorContact->title = 'Contact Us';

$menuLine = new HtmlImage('menu-line');
$menuLine->src = '/images/menu-line.png';

$menuBar = new HtmlTable('menu-bar');
$menuBar->SetTableAttribute('cellpadding', '0');
$menuBar->SetTableAttribute('cellspacing', '0');
$menuBar->SetTableAttribute('align', 'right');

$i = $menuBar->AddRow();
$menuBar->SetCellContent($i, 1, $anchorHome->Render(false));
$menuBar->SetCellContent($i, 2, $menuLine->Render(false));
$menuBar->SetCellContent($i, 3, $anchorAbout->Render(false));
$menuBar->SetCellContent($i, 4, $menuLine->Render(false));
$menuBar->SetCellContent($i, 5, $anchorContact->Render(false));

$i = $menuTable->AddRow();
$menuTable->SetCellContent($i, 1, $menuBar->Render(false));
$menuTable->SetCellAttribute($i, 1, 'align', 'right');

$i = $headerTable->AddRow();
$headerTable->SetCellContent($i, 1, $fgLogo->Render(false));
$headerTable->SetCellContent($i, 2, $diceCup->Render(false));
$headerTable->SetCellContent($i, 3, $dice->Render(false));
$headerTable->SetCellContent($i, 4, $menuTable->Render(false));
$headerTable->SetCellAttribute($i, 1, 'valign', 'bottom');
$headerTable->SetCellAttribute($i, 3, 'valign', 'bottom');
$headerTable->SetCellAttribute($i, 4, 'valign', 'bottom');

$i = $headerTable->AddRow();
$headerTable->SetCellContent($i, 1, '&nbsp;');
$headerTable->SetCellColSpan($i, 1, 4);
$headerTable->SetCellStyle($i, 1, 'border-bottom: 2px solid white; font-size: 10px');

$bannerTable = new HtmlTable('banner');
$bannerTable->SetTableAttribute('width', '100%');
$bannerTable->SetTableAttribute('align', 'center');
$bannerTable->SetTableAttribute('style', 'background: url(/images/top-banner.png) repeat-x;');

$i = $bannerTable->AddRow();
$bannerTable->SetCellContent($i, 1, $headerTable->Render(false));
$bannerTable->Render();
?>
