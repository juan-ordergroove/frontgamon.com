<?php
require_once(PHP_DEV . 'HtmlControl/HtmlImage.inc.php');

require_once(PHP_DEV . 'page-start.inc.php'); // Open HTML, set DOCTYPE

$PAGE_HEAD['title'] = "Frontgamon.com - About Us"; // Set title

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

$innerTable = new HtmlTable('coming-soon');
$innerTable->SetTableAttribute('cellspacing', '0');
$innerTable->SetTableAttribute('cellpadding', '0');
$innerTable->SetTableAttribute('align', 'center');
$innerTable->SetTableAttribute('width', '600');
$innerTable->className = 'fgReg';

$fgImg = new HtmlImage('frontgamon');
$fgImg->src = '/images/Frontgamon.png';
$fgImg->styles['padding'] = '10px';

$i = $innerTable->AddRow();
$innerTable->SetCellContent($i, 1, $fgImg->Render(false));

$nameDiv = new HtmlDiv();
$nameDiv->styles['padding'] = '10px 10px 10px 20px';
$nameDiv->styles['font-family'] = 'Verdana';
$nameDiv->styles['font-size'] = '13px';
$nameDiv->styles['font-weight'] = 'bold';
$nameDiv->value = "BBQ Bob";

$bioDiv = new HtmlDiv();
$bioDiv->styles['padding-left'] = '15px';
$bioDiv->styles['padding-right'] = '15px';
$bioDiv->styles['font-family'] = 'Verdana';
$bioDiv->styles['font-size'] = '13px';

$i = $innerTable->AddRow();
$innerTable->SetCellContent($i, 1, $nameDiv->Render(false));

$nameDiv->value = "J Leah";
$bioDiv->value = "";

$i = $innerTable->AddRow();
$innerTable->SetCellContent($i, 1, $nameDiv->Render(false));

$i = $innerTable->AddRow();
$innerTable->SetCellContent($i, 1, $bioDiv->Render(false));

$nameDiv->value = "Bones Mahones";
$bioDiv->value = "&nbsp;&nbsp;Bones Mahones has been a contributor to this site since its inception. He also acts as 
Frontgamon.com's administrator. A Jersey boy with a Computer Science degree checking to see if anyone's listening.";

$i = $innerTable->AddRow();
$innerTable->SetCellContent($i, 1, $nameDiv->Render(false));

$i = $innerTable->AddRow();
$innerTable->SetCellContent($i, 1, $bioDiv->Render(false));

$nameDiv->value = "Babyback";
$bioDiv->value = "&nbsp;&nbsp;Babyback is just this guy ya know.  Hailing from the most badass state in the Union, 
New Jersey Babyback has developed a deep appreciation for all things funky.  As in life as in BBQ Low and Slow 
is the only way to go.  Slappin Funky Beats and Rubbin Tasty Meats all you need in life is a grill and a funky 
bass line to groove with.";

$i = $innerTable->AddRow();
$innerTable->SetCellContent($i, 1, $nameDiv->Render(false));

$i = $innerTable->AddRow();
$innerTable->SetCellContent($i, 1, $bioDiv->Render(false));

$nameDiv->value = "DB";
$bioDiv->value = " ";

$i = $innerTable->AddRow();
$innerTable->SetCellContent($i, 1, $nameDiv->Render(false));

$i = $innerTable->AddRow();
$innerTable->SetCellContent($i, 1, $bioDiv->Render(false));

$nameDiv->value = "Mikeen";
$bioDiv->value = "";

$i = $innerTable->AddRow();
$innerTable->SetCellContent($i, 1, $nameDiv->Render(false));

$i = $innerTable->AddRow();
$innerTable->SetCellContent($i, 1, $bioDiv->Render(false));

$nameDiv->value = "Y";
$bioDiv->value = "";

$i = $innerTable->AddRow();
$innerTable->SetCellContent($i, 1, $nameDiv->Render(false));

$i = $innerTable->AddRow();
$innerTable->SetCellContent($i, 1, $bioDiv->Render(false));

$innerTable->Render();
?>

</body>

</html>
