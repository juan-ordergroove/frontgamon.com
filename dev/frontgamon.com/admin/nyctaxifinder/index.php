<?php
require_once (PHP_DEV . 'admin/session.inc.php');

require_once (PHP_DEV . 'classes/NYC/YellowCabDriversMedallion.class.php');

require_once(PHP_DEV . 'HtmlControl/HtmlImage.inc.php');
require_once(PHP_DEV . 'HtmlControl/HtmlAnchor.inc.php');
require_once(PHP_DEV . 'HtmlControl/HtmlInputControl.inc.php');
require_once(PHP_DEV . 'HtmlControl/HtmlLabel.inc.php');
require_once(PHP_DEV . 'HtmlControl/HtmlForm.inc.php');

require_once(PHP_DEV . 'page-start.inc.php'); // Open HTML, set DOCTYPE

function GroupDriversByAgentLicensee($driverData)
{
  $newData = array();
  for ($i = 0; $i < count($driverData); $i++)
  {
    if (!isset($driverData[$i]['AgentLicensee']))
      return array();
    
    foreach ($driverData[$i] as $key => $value)
    {
      if (strpos($key, 'Agent') === false)
      {
        $agentLicensee = $driverData[$i]['AgentLicensee'];
        $newData[$agentLicensee][$i][$key] = $value;
      }
    }
  }

  return $newData;
}

$PAGE_HEAD['title'] = "NYC Taxi Finder"; // Set title

$driverData = array();
$columnHeaders = array();
$faceboxAddress = array();
$bDataExpandable = false;

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
      {
	      $rs = $driversMedallion->LimitedInfoByMedallionWithAgentNumber($medallionNumber);
        $bDataExpandable = (count($rs->fields)) > 0 ? true : false;
      }
    }
    else
    {
      $bDataExpandable = true;
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
        if ($key == 'AgentLicensee')
          $agentLicensee = $driverData[$i][$key];
        if ($key == 'AgentStreetAddress' || $key == 'AgentCity' || $key == 'AgentState' || $key == 'AgentZipCode' || $key == 'AgentTelephone' || $key == 'AgentType')
          $faceboxAddress[$agentLicensee][$key] = $value;
      }
    }
    $rs->Close();
  }
}
?>

<?php
$js_include[] = '/js/jQuery/jQuery.js';

require_once(PHP_DEV . 'page-open-head.inc.php'); // Open head
require_once(PHP_DEV . 'includes.inc.php'); // JavaScript libraries and utilites

require_once(PHP_DEV . 'page-close-head.inc.php'); // Close head
?>

<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAA75yExUyA2Yj3zhLGYAaBmxQJsJA7Zu2adCr7nhYxGwuUkYpeYBS-C6nK4W9Esog_G2j2y6818HjX7Q">
</script>
<script type='text/javascript' src='/js/facebox/facebox.js'></script>
<script type='text/javascript'>
var map = null;
var geocoder = null;
google.load('maps', '2.x');

function setAddress(address)
{
  var inputAddress = document.getElementById('address');
  inputAddress.value = address;
}

function getMapAtAddress()
{
  var inputAddress = document.getElementById('address').value;
  var geocoder = new google.maps.ClientGeocoder();
  
  var map = new google.maps.Map2(document.getElementById('mapContainer'));
  map.setUIToDefault();
  
  geocoder.getLatLng(inputAddress, function (point) {
      if (!point)
      {
        alert(inputAddress + ' not found.');
      }
      else
      {
        map.setCenter(point, 13);
        var marker = new google.maps.Marker(point);
        map.addOverlay(marker);
        marker.openInfoWindowHtml(inputAddress);
      }
      map.checkResize();
    });
}

function toggleDriverRow(agentLicensee)
{
  $('#' + agentLicensee).slideToggle( function () {
      if ($(this).css('display') == 'block')
        $(this).css('display', 'table-row');
      });
  return false;
}

jQuery(document).ready(function($) {
  $('a[rel*=facebox]').facebox({
    loading_image : 'loading.gif',
    close_image   : 'closelabel.gif'
  });
});

</script>
<link rel="stylesheet" type="text/css" href="/css/facebox/facebox.css" />

<style>
label, td
{
  font-family: Verdana;
  font-size: 10pt;
}
</style>

<body onunload="GUnload()">

<?php require_once(PHP_DEV . 'frontgamon-header.inc.php'); // --Frontgamon.com header-- ?>

<?php
$form = new HtmlForm('taxifinder');

$spacer = new HtmlImage('spacer');
$spacer->src = '/images/spacer.gif';
$spacer->height = 25;
$spacer->Render();

$searchTable = new HtmlTable('search-table');
$searchTable->SetTableAttribute('cellspacing', '0');
$searchTable->SetTableAttribute('cellpadding', '0');
$searchTable->SetTableAttribute('align', 'center');
$searchTable->SetTableAttribute('width', '600');
$searchTable->className = 'fgReg';

$input = new HtmlInput('medallionNumber');
$input->styles['width'] = '80px';
$input->type = 'text';
$input->value = $medallionNumber;

$label = new HtmlLabel('medallionLabel');
$label->styles['width'] = '120px';
$label->body = 'Medallion #:';

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

$i = $searchTable->AddRow();
$searchTable->SetCellContent($i, 1, $inputDiv->Render(false));
$searchTable->SetCellAttribute($i, 2, 'align', 'center');
$searchTable->SetCellContent($i, 2, $buttonDiv->Render(false));

$i = $searchTable->AddRow();
$searchTable->SetCellContent($i, 1, $spacer->Render(false));
$searchTable->SetCellColSpan($i, 1, 2);

$mainTable = new HtmlTable('main-table');
$mainTable->SetTableAttribute('cellspacing', '0');
$mainTable->SetTableAttribute('cellspacing', '0');
$mainTable->SetTableAttribute('align', 'center');
$mainTable->SetTableAttribute('width', '600');

$i = $mainTable->AddRow();
$mainTable->SetCellContent($i, 1, $searchTable->Render(false));

$driverTable = new HtmlTable('driver-table');
$driverTable->SetTableAttribute('cellspacing', '0');
$driverTable->SetTableAttribute('cellpadding', '0');
$driverTable->SetTableAttribute('align', 'center');
$driverTable->SetTableAttribute('width', '600');
$driverTable->className = 'fgReg';

//echo $bDataExpandable ? 'true' : 'false';
if (count($driverData))
{
  $infoByLicensee = GroupDriversByAgentLicensee($driverData);
  //new Dump($driverData);
  //new Dump($infoByLicensee);
  //new Dump($faceboxAddress);
  $col = 1;
  $columnHeaders = array();
  $i = $driverTable->AddRow();
  
  if ($bDataExpandable)
    $columnHeaders = array_merge(array('AgentLicensee'), array_keys($faceboxAddress[$driverData[0]['AgentLicensee']]));
  else
    $columnHeaders = array_keys($driverData[0]);

  foreach ($columnHeaders as $columnTitle)
  {
    $driverTable->SetCellContent($i, $col, $columnTitle);
    $driverTable->SetCellAttribute($i, $col, 'align', 'center');
    $driverTable->SetCellStyle($i, $col, 'font-weight: bold; padding: 5px');
				
    $col++;
  }
	
  $bGroupRows = count($infoByLicensee) > 0;
  
  if (!$bDataExpandable)
  {
    foreach ($driverData as $driver)
    {
      $col = 1;
      $i = $driverTable->AddRow();
    
      foreach ($driver as $key => $value)
      {
        if ($key == 'AgentLicensee')
        {
          $addressParameters = '';
          foreach ($faceboxAddress[$value] as $addKey => $addValue)
            $addressParameters = sprintf('%s %s', $addressParameters, $addValue);

          $anchor = new HtmlAnchor();
          $anchor->href = 'get-map.html';
          $anchor->body = $value;
          $anchor->events['onclick'] = sprintf('setAddress("%s")', $addressParameters); 
          $anchor->attributes['rel'] = 'facebox';
        
          $driverTable->SetCellContent($i, $col, $anchor->Render(false));
        }
        else
          $driverTable->SetCellContent($i, $col, $value);
        $driverTable->SetCellAttribute($i, $col, 'align', 'center');
        $driverTable->SetCellStyle($i, $col, 'padding: 5px');
        $col++;
      }
    }
  }
  else
  {
    foreach ($faceboxAddress as $agentLicensee => $agentData)
    {
      $col = 1;
      $i = $driverTable->AddRow();

      $addressParameters = '';
      foreach ($faceboxAddress[$agentLicensee] as $addKey => $addValue)
      {
        if ($addKey == 'AgentTelephone')
            continue;

        $addressParameters = sprintf('%s %s', $addressParameters, $addValue);
      }

      $anchor = new HtmlAnchor();
      $anchor->href = 'get-map.html';
      $anchor->body = $agentLicensee;
      $anchor->events['onclick'] = sprintf('setAddress("%s")', $addressParameters);
      $anchor->attributes['rel'] = 'facebox';
      
      $agentLicenseeId = str_replace(array(' ', '.', '&'), '', $agentLicensee);
      $driverTable->SetRowAttributes($i, array('onclick' => sprintf('toggleDriverRow("%s")', $agentLicenseeId), 'style' => 'cursor:pointer'));
      $driverTable->SetCellContent($i, $col, $anchor->Render(false));
      $driverTable->SetCellAttribute($i, $col, 'align', 'center');
      $driverTable->SetCellStyle($i, $col, 'padding:5px');
      $col++;

      foreach($agentData as $key => $value)
      {
        $driverTable->SetCellContent($i, $col, $value);
        $driverTable->SetCellAttribute($i, $col, 'align', 'center');
        $driverTable->SetCellStyle($i, $col, 'padding:5px');
        $col++;
      }

      $divs = array();
      foreach($infoByLicensee[$agentLicensee] as $drivers)
      {
        $div = new HtmlDiv();
        foreach ($drivers as $key => $value)
          $div->body .= $value . '&nbsp;&nbsp;&nbsp;';

        $div->attributes['align'] = 'center';
        $div->styles['padding'] = '5px';
        $divs[] = $div->Render(false);
      }

      $i = $driverTable->AddRow();
      $driverTable->SetRowAttributes($i, array('style' => 'display:none', 'id' => $agentLicenseeId));
      $driverTable->SetCellContent($i, 1, implode("\n", $divs));
      $driverTable->SetCellColSpan($i, 1, count($agentData) + 1);
    }
  }
}
else if (HtmlForm::IsPostBack())
{
  $i = $driverTable->AddRow();
  $driverTable->SetCellContent($i, 1, 'No search results. Please make sure you have the correct medallion number.');
  $driverTable->SetCellAttribute($i, 1, 'align', 'center');
  $driverTable->SetCellStyle($i, 1, 'padding: 5px');		
}

if (HtmlForm::IsPostBack())
{
  $i = $mainTable->AddRow();
  $mainTable->SetCellContent($i, 1, $spacer->Render(false));
		
  $i = $mainTable->AddRow();
  $mainTable->SetCellContent($i, 1, $driverTable->Render(false));
}

$input = new HtmlInput('address');
$input->type = 'hidden';
$input->value = '';

$form->body = $mainTable->Render(false) . $input->Render(false);
$form->Render();
?>

<!-- <div id='mapContainer' style='width: 500px; height: 300px; display: none;'>
</div>
-->

<?php require_once (PHP_DEV . 'admin/footer.inc.php'); ?>

</body>

</html>
