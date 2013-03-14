<?php
require_once (PHP_DEV . 'admin/session.inc.php');

require_once(PHP_DEV . 'HtmlControl/HtmlImage.inc.php');
require_once(PHP_DEV . 'HtmlControl/HtmlAnchor.inc.php');

require_once(PHP_DEV . 'page-start.inc.php'); // Open HTML, set DOCTYPE

$PAGE_HEAD['title'] = "Frontgamon.com - Home"; // Set title

require_once(PHP_DEV . 'page-open-head.inc.php'); // Open head
require_once(PHP_DEV . 'includes.inc.php'); // JavaScript libraries and utilites
require_once(PHP_DEV . 'page-close-head.inc.php'); // Close head
?>

<body>
<?php require_once(PHP_DEV . 'frontgamon-header.inc.php'); // --Frontgamon.com header-- ?>

<?php
$spacer = new HtmlImage('spacer');
$spacer->src = '/images/spacer.gif';
$spacer->height = 25;
$spacer->Render();

$comingSoon = new HtmlTable('coming-soon');
$comingSoon->SetTableAttribute('cellspacing', '0');
$comingSoon->SetTableAttribute('cellpadding', '0');
$comingSoon->SetTableAttribute('align', 'center');
$comingSoon->SetTableAttribute('width', '600');
$comingSoon->className = 'fgReg';

$fgImg = new HtmlImage('frontgamon');
$fgImg->src = '/images/Frontgamon.png';
$fgImg->styles['padding'] = '10px';

$soonImg = new HtmlImage('soon');
$soonImg->src = '/images/coming-soon.png';
$soonImg->styles['padding'] = '100px';

$i = $comingSoon->AddRow();
$comingSoon->SetCellContent($i, 1, $fgImg->Render(false));

$i = $comingSoon->AddRow();
$comingSoon->SetCellAttribute($i, 1, 'align', 'center');
$comingSoon->SetCellContent($i, 1, $soonImg->Render(false));

$anchor = new HtmlAnchor('blah');
$anchor->href = '/admin/nyctaxifinder/';
$anchor->title = 'NYCTaxiFinder';

$i = $comingSoon->AddRow();
$comingSoon->SetCellContent($i, 1, 'Admin Links');
$comingSoon->SetCellAttribute($i, 1, 'align', 'center');

$i = $comingSoon->AddRow();
$comingSoon->SetCellContent($i, 1, $anchor->Render(false));
$comingSoon->SetCellAttribute($i, 1, 'align', 'center');
$comingSoon->SetCellAttribute($i, 1, 'style', 'padding-bottom: 10px;');
$comingSoon->Render();
?>

<?php require_once (PHP_DEV . 'admin/footer.inc.php'); ?>

</body>

</html>
