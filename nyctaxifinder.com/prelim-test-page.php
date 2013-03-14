<?php
require_once (PHP_LIVE . 'classes/NYC/YellowCabDriversMedallion.class.php');

require_once(PHP_LIVE . 'HtmlControl/HtmlImage.inc.php');
require_once(PHP_LIVE . 'HtmlControl/HtmlAnchor.inc.php');
require_once(PHP_LIVE . 'HtmlControl/HtmlInputControl.inc.php');
require_once(PHP_LIVE . 'HtmlControl/HtmlLabel.inc.php');
require_once(PHP_LIVE . 'HtmlControl/HtmlForm.inc.php');
require_once(PHP_LIVE . 'HtmlControl/HtmlDiv.inc.php');

require_once(PHP_LIVE . 'page-start.inc.php'); // Open HTML, set DOCTYPE

$PAGE_HEAD['title'] = "NYC Taxi Finder"; // Set title

require_once(PHP_LIVE . 'page-open-head.inc.php'); // Open head
require_once(PHP_LIVE . 'includes.inc.php'); // JavaScript libraries and utilites
require_once(PHP_LIVE . 'page-close-head.inc.php'); // Close head

$driverData = array();
$columnHeaders = array();

if (HtmlForm::IsPostBack())
{
		if (HtmlForm::Clicked('submit'))
		{
				$medallionNumber = isset($_REQUEST['medallionNumber']) ? $_REQUEST['medallionNumber'] : '';
				
				$i = 0;
				$driversMedallion = new YellowCabDriversMedallion();
				
				$rs = $driversMedallion->InfoByMedallionWithAgentNumber($medallionNumber);
				if (!count($rs->fields))
				{
						$rs = $driversMedallion->InfoByMedallionWithoutAgentNumber($medallionNumber);
						if (!count($rs->fields))
								$rs = $driversMedallion->LimitedInfoByMedallionWithAgentNumber($medallionNumber);
				}
				
				for (; !$rs->EOF; $rs->MoveNext(), $i++)
				{
						foreach ($rs->fields as $key => $value)
						{
								if (is_numeric($key))
										continue;
								
								if (!isset($columnHeaders[$key]))
										$columnHeaders[$key] = true;
								
								$driverData[$i][$key] = $value;
						}
				}
				$rs->Close();
		}
}
?>

<style>
label, td
{
  font-family: Verdana;
		font-size: 10pt;
}
</style>

<body>

<?php
$form = new HtmlForm('taxifinder');

$input = new HtmlInput('medallionNumber');
$input->styles['width'] = '80px';
$input->type = 'text';
$input->value = $medallionNumber;

$label = new HtmlLabel('medallionLabel');
$label->styles['width'] = '120px';
$label->body = 'Field value:';

$inputDiv = new HtmlDiv();
$inputDiv->id = 'medallionContainer';
$inputDiv->styles['padding-top'] = '10px';
$inputDiv->styles['padding-left'] = '10px';
$inputDiv->body = $label->Render(false) . $input->Render(false);

$submit = new HtmlInput('submit');
$submit->styles['width'] = '60px';
$submit->attributes['type'] = 'submit';
$submit->attributes['value'] = 'Submit';

$buttonDiv = new HtmlDiv();
$buttonDiv->id = 'submitContainer';
$buttonDiv->styles['padding-top'] = '10px';
$buttonDiv->body = $submit->Render(false);

$form->body = $inputDiv->Render(false) . $buttonDiv->Render(false);
$form->Render();

if (count($driverData))
{
		$driverDiv = new HtmlDiv();
		$driverDiv->id = 'nameContainer';
		$driverDiv->styles['font-weight'] = 'bold';
		$driverDiv->body = 'Name(s)';
		$driverDiv->Render();
		
		$driverCount = 0;

		foreach (array_keys($driverData) as $driverIdx)
		{
				foreach ($driverData[$driverIdx] as $key => $value)
				{
						if (is_numeric($key))
								continue;
						
						if ($key == 'DriverName')
						{
								$driverCount++;
								
								$driverDiv = new HtmlDiv();
								$driverDiv->id = sprintf('name[%s]', $value);
								$driverDiv->body = $value;
								$driverDiv->Render();
						}
				}
				
				if (!$driverCount)
				{
						$driverDiv = new HtmlDiv();
						$driverDiv->id = 'driverContainer';
						$driverDiv->styles['font-weight'] = 'bold';
						$driverDiv->body = 'No names available.';
						$driverDiv->Render();
				}
		}
}
else if (HtmlForm::IsPostBack())
{
		echo "<br>No results.<br>";
}
?>

</body>

</html>
