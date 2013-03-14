<?php
require_once(PHP_LIVE . 'HtmlControl/HtmlRoundTable.inc.php');
require_once(PHP_LIVE . 'HtmlControl/HtmlList.inc.php');

require_once(PHP_LIVE . 'page-start.inc.php'); // Open HTML, set DOCTYPE

$PAGE_HEAD['title'] = "Frontgamon.com - Task list"; // Set title

require_once(PHP_LIVE . 'page-open-head.inc.php'); // Open head
require_once(PHP_LIVE . 'includes.inc.php'); // JavaScript libraries and utilites
?>

<?php
require_once(PHP_LIVE . 'page-close-head.inc.php'); // Close head
?>

<body>

<?php require_once(PHP_LIVE . 'frontgamon-header.inc.php'); // Start of body and header ?>

<img src="/images/spacer.gif" alt="" height="25">

<?php
$taskItems = array(
  'Other color schemes',
		'Other vide page layouts',
		'User profile content',
		'Other/Missing categories',
		'Logo',
		'Flash A/V Player - <b>Juan</b>',
		'Search results layout',
		'Comments layout',
		'General layout',
		'<i>About Us</i> content',
		'Rating/Tagging System? - <b>Juan</b>',
		'Upload interface',
		'<i>FAQ</i> & <i>Helpful Links</i> content',
		'Invite friends',
		'Send friends video',
);

$list = new HtmlList('task-list', true);
$list->AddItems($taskItems);

$table = new HtmlTable('loginTable');
$table->SetTableAttribute('width', '500');
$table->SetTableAttribute('align', 'center');
$table->SetTableAttribute('cellspacing', '0');
$table->SetTableAttribute('cellpadding', '0');
$table->SetTableAttribute('style', 'padding: 10px 30px;');
$table->className = 'fgReg';

$i = $table->AddRow();
$table->SetCellContent($i, 1, $list->Render(false));

$table->Render();
?>

<?php require_once(PHP_LIVE . 'footer.inc.php'); // Start of body and header ?>

</body>
</html>
