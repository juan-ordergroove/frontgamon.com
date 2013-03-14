<?php
require_once(PHP_LIVE . 'HtmlControl/HtmlImage.inc.php');

require_once(PHP_LIVE . 'page-start.inc.php'); // Open HTML, set DOCTYPE

$PAGE_HEAD['title'] = "Frontgamon.com - Contact Us"; // Set title

require_once(PHP_LIVE . 'page-open-head.inc.php'); // Open head
require_once(PHP_LIVE . 'includes.inc.php'); // JavaScript libraries and utilites
require_once(PHP_LIVE . 'page-close-head.inc.php'); // Close head
?>

<body>

<?php require_once(PHP_LIVE . 'frontgamon-header.inc.php'); // --Frontgamon.com header-- ?>

<?php
$spacer = new HtmlImage('spacer');
$spacer->src = '/images/spacer.gif';
$spacer->height = 25;
$spacer->Render();

$innerTable = new HtmlTable('coming-soon');
$innerTable->SetTableAttribute('cellspacing', '0');
$innerTable->SetTableAttribute('cellpadding', '0');
$innerTable->SetTableAttribute('align', 'center');
$innerTable->SetTableAttribute('width', '600');
$innerTable->className = 'fgReg';

$fgImg = new HtmlImage('frontgamon');
$fgImg->src = '/images/Frontgamon.png';
$fgImg->styles['padding'] = '10px';

$soonImg = new HtmlImage('soon');
$soonImg->src = '/images/coming-soon.png';
$soonImg->styles['padding'] = '120px';
$soonImg->styles['padding-top'] = '100px';

$i = $innerTable->AddRow();
$innerTable->SetCellContent($i, 1, $fgImg->Render(false));

$i = $innerTable->AddRow();
$innerTable->SetCellAttribute($i, 1, 'align', 'center');
$innerTable->SetCellContent($i, 1, $soonImg->Render(false));

$innerTable->Render();
?>

</body>

</html>
