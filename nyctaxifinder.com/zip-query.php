<?php
require_once(PHP_LIVE . 'classes/NYC/YellowCabMedallion.class.php');

require_once(PHP_LIVE . 'HtmlControl/HtmlTable.inc.php');
require_once(PHP_LIVE . 'HtmlControl/HtmlAccordion.inc.php');

function QueryCabTable($yellowCabMedallion, $columnName, $columnValue, $table)
{
  $results = array();

	$sql = new SQLQueryBuilder('SELECT');
	$sql->SetTable($table);
	$sql->addColumn('*');
	$sql->setWhere(sprintf('%s = "%s"', $columnName, $columnValue));

	$rs = $yellowCabMedallion->Execute($sql->buildQuery());
	if (!$rs->fields)
  {
    return false;
  }
  else
	{
	  for (; !$rs->EOF; $rs->MoveNext())
		  $results[] = $rs->fields;
		$rs->Close();
	}

  return $results;
}

function GenerateDataTable($bIsYellowCab, $tableId, $baseData)
{
	$table = new HtmlTable($tableId);
	$table->SetTableAttribute('cellspacing', 0);
	$table->SetTableAttribute('cellpadding', '4');
	$table->SetTableAttribute('border', 1);
	$table->SetTableAttribute('align', 'center');

  $i = $table->AddRow();
	$table->SetCellContent($i, 1, '<b>License Number</b>');
	$table->SetCellAttribute($i, 1, 'align', 'center');
	$table->SetCellContent($i, 2, '<b>Licensee Name</b>');
	$table->SetCellAttribute($i, 2, 'align', 'center');
	$table->SetCellContent($i, 3, '<b>Address</b>');
	$table->SetCellAttribute($i, 3, 'align', 'center');
	$table->SetCellContent($i, 4, '<b>Telephone</b>');
	$table->SetCellAttribute($i, 4, 'align', 'center');
	
	$licenseeColumn = $bIsYellowCab ? 'NameOfLicensee' : 'LicenseeName';
	foreach ($baseData as $base)
	{
		$i = $table->AddRow();
		$table->SetCellContent($i, 1, $base['LicenseNumber']);
		$table->SetCellAttribute($i, 1, 'align', 'center');
		$table->SetCellContent($i, 2, $base[$licenseeColumn]);
		$table->SetCellAttribute($i, 2, 'align', 'center');
		$table->SetCellContent($i, 3, sprintf('%s %s %s', $base['StreetAddress'], $base['City'], $base['State']));
		$table->SetCellAttribute($i, 3, 'align', 'center');
		$table->SetCellContent($i, 4, $base['Telephone']);
		$table->SetCellAttribute($i, 4, 'align', 'center');
  }
		
	return $table->Render(false);
}

$zipCode = isset($_REQUEST['zipCode']) ? trim($_REQUEST['zipCode']) : '';
if (!preg_match('/^\d\d\d\d\d$/', $zipCode))
  $zipCode = '';

$yellowCabMedallion = new YellowCabMedallion();

$zipData = array();
$zipData['yellow'] = QueryCabTable($yellowCabMedallion, 'ZipCode', $zipCode, 'YellowCabMedallionLicenseType');
$zipData['para'] = QueryCabTable($yellowCabMedallion, 'ZipCode', $zipCode, 'ParatransitBase');
$zipData['commuter'] = QueryCabTable($yellowCabMedallion, 'ZipCode', $zipCode, 'CommuterVanBase');
$zipData['fhv']['blackCar'] = QueryCabTable($yellowCabMedallion, 'ZipCode', $zipCode, 'BlackCarBase');
$zipData['fhv']['community'] = QueryCabTable($yellowCabMedallion, 'ZipCode', $zipCode, 'CommunityCarBase');
$zipData['fhv']['limo'] = QueryCabTable($yellowCabMedallion, 'ZipCode', $zipCode, 'LuxuryLimoBase');

$accordion = new HtmlAccordion();

if ($zipData['yellow'])
{
  $header = sprintf("<label><a href='#'>Yellow Cabs<span> - %s</span></a></label>", $zipCode);
  $accordion->AddAccordion('accordion-yellowZip', $header, GenerateDataTable(true, 'yellowZip', $zipData['yellow']));
}

if ($zipData['para'])
{
  $header = sprintf("<label><a href='#'>\"Access-A-Ride\"<span> - %s</span></a></label>", $zipCode);
  $accordion->AddAccordion('accordion-paraZip', $header, GenerateDataTable(false, 'paraZip', $zipData['para']));
}

if ($zipData['commuter'])
{
  $header = sprintf("<label><a href='#'>Commuter Van<span> - %s</span></a></label>", $zipCode);
  $accordion->AddAccordion('accordion-commuterZip', $header, GenerateDataTable(false, 'commuterZip', $zipData['commuter']));
}

if ($zipData['fhv']['blackCar'] || $zipData['fhv']['community'] || $zipData['fhv']['limo'])
{
  $header =  sprintf("<label><a href='#'>For-Hire-Vehicles<span> - %s</span></a></label>", $zipCode);
  $accordionData = '';

  foreach ($zipData['fhv'] as $type => $data)
  {
    if ($data)
    {
      switch ($type)
      {
      case 'blackCar':
        $accordionData .= sprintf("Black Cars:<br>%s", GenerateDataTable(false, 'blackCarZip', $data));
        break;
      case 'community':
        $accordionData .= sprintf("Community Cars:<br>%s", GenerateDataTable(false, 'communityZip', $data));
        break;
      case 'limo':
        $accordionData .= sprintf("Luxury Limos:<br>%s", GenerateDataTable(false, 'limoZip', $data));
        break;
      }
    }
  }

  $accordion->AddAccordion('accordion-fhvZip', $header, $accordionData);
}

$accordion->Render();
?>
