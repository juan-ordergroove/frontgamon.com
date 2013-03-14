<?php
require_once(PHP_LIVE . 'HtmlControl/HtmlRoundTable.inc.php');
require_once(PHP_LIVE . 'HtmlControl/HtmlInputControl.inc.php');
require_once(PHP_LIVE . 'HtmlControl/HtmlForm.inc.php');
require_once(PHP_LIVE . 'HtmlControl/HtmlLabel.inc.php');
require_once(PHP_LIVE . 'HtmlControl/HtmlDiv.inc.php');

require_once(PHP_LIVE . 'classes/FG/FG_Users.class.php');

if (HtmlForm::IsPostBack())
{
	if (HtmlForm::Clicked('submit'))
	{
		$username = (isset($_REQUEST['username']) ? $_REQUEST['username'] : '');
		$password = (isset($_REQUEST['password']) ? $_REQUEST['password'] : '');
		
		$user = new FG_Users();
		$user->Fetch($username);
		
		if ($user->UserPassword == md5($password))
		{
			session_start();
			
			$_SESSION['FG_Users'] = serialize($user);
			$_SESSION['fingerprint'] = md5(serialize($user));

			$host = $_SERVER["HTTP_HOST"];
			header("Location: http://$host/admin/");
		}
	}
}

require_once(PHP_LIVE . 'page-start.inc.php'); // Open HTML, set DOCTYPE

$PAGE_HEAD['title'] = "Frontgamon.com - Login"; // Set title

require_once(PHP_LIVE . 'page-open-head.inc.php'); // Open head
require_once(PHP_LIVE . 'includes.inc.php'); // JavaScript libraries and utilites
?>

<style>
label 
{
		font-family: Verdana;
		font-size: 10pt;
}
</style>

<?php
require_once(PHP_LIVE . 'page-close-head.inc.php'); // Close head
?>

<body>

<?php	require_once(PHP_LIVE . 'frontgamon-header.inc.php'); // Start of body and header ?> 

<img src="/images/spacer.gif" alt="" height="25">

<?php

$form = new HtmlForm('mainform');
$form->attributes['method'] = 'post';
$form->attributes['action'] = 'login.php';

$userName = new HtmlInput('username');
$userName->styles['width'] = '120px';
$userName->attributes['type'] = 'text';

$password = new HtmlInput('password');
$password->styles['width'] = '120px';
$password->attributes['type'] = 'password';

$submit = new HtmlInput('submit');
$submit->styles['width'] = '60px';
$submit->attributes['type'] = 'submit';
$submit->attributes['value'] = 'Submit';

$label = new HtmlLabel('loginLabel');
$label->styles['width'] = '120px';
$label->body = 'Login';

$liquid = new HtmlTable('loginTable');
$liquid->SetTableAttribute('align', 'center');
$liquid->SetTableAttribute('cellspacing', '0');
$liquid->SetTableAttribute('cellpadding', '0');
$liquid->SetTableAttribute('style', 'padding: 10px 30px;');
$liquid->className = 'fgReg';

$i = $liquid->AddRow();
$liquid->SetCellAttribute($i, 1, 'align', 'center');
$liquid->SetCellContent($i, 1, $label->Render(false));

$label->id = 'usernameLabel';
$label->styles['float'] = 'left';
$label->styles['width'] = '6em';
$label->styles['padding-top'] = '3px';
$label->body = 'Username: ';

$inputDiv = new HtmlDiv();
$inputDiv->id = 'usernameContainer';
$inputDiv->styles['padding-top'] = '10px';
$inputDiv->body = $label->Render(false) . $userName->Render(false) . '<br>';

$i = $liquid->AddRow();
$liquid->SetCellContent($i, 1, $inputDiv->Render(false));

$label->body = 'Password: ';
$label->id = 'passwordLabel';

$inputDiv->id = 'passwordContainer';
$inputDiv->styles['padding-top'] = '10px';
$inputDiv->body = $label->Render(false) . $password->Render(false);

$i = $liquid->AddRow();
$liquid->SetCellContent($i, 1, $inputDiv->Render(false));

$inputDiv->id = 'submitContainer';
$inputDiv->styles['padding-top'] = '10px';
$inputDiv->body = $submit->Render(false);

$i = $liquid->AddRow();
$liquid->SetCellAttribute($i, 1, 'align', 'center');
$liquid->SetCellContent($i, 1, $inputDiv->Render(false));

$form->body = $liquid->Render(false);
$form->Render();
?>

<?php	require_once(PHP_LIVE . 'footer.inc.php'); // Start of body and header ?> 

</body>
</html>
