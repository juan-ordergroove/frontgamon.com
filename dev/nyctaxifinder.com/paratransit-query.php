<?php
require_once(PHP_DEV . 'HtmlControl/HtmlTable.inc.php');
require_once(PHP_DEV . 'classes/NYC/ParatransitVehicle.class.php');
require_once(PHP_DEV . 'classes/NYC/ParatransitFactory.class.php');

$licensePlate = isset($_REQUEST['licensePlate']) ? trim($_REQUEST['licensePlate']) : '';
$driverName = isset($_REQUEST['driverName']) ? trim($_REQUEST['driverName']) : '';

if (!preg_match('/^(T\d+C)|(\d+LA)|(AMBU\d+)$/', $licensePlate))
  $licensePlate = '';

$vehicle = new ParatransitVehicle();

$factory = new ParatransitFactory($vehicle, $licensePlate);
$factory->BuildParatransitFactory();
 
$defaultText = 'No data is currently available.';
$tableData = array(PARA_BASE => $defaultText, PARA_VEHICLE => $defaultText);

if ($factory->Results[$licensePlate][PARA_BASE])
{
  $table = new HtmlTable('para-base');
  $table->SetTableAttribute('cellspacing', 0);
  $table->SetTableAttribute('cellpadding', '4');
  $table->SetTableAttribute('border', 1);
  $table->SetTableAttribute('align', 'center');

  $i = $table->AddRow();
  $table->SetCellContent($i, 1, '<b>Licensee Name</b>');
  $table->SetCellAttribute($i, 1, 'align', 'center');
  $table->SetCellContent($i, 2, '<b>Address</b>');
  $table->SetCellAttribute($i, 2, 'align', 'center');
  $table->SetCellContent($i, 3, '<b>Telephone</b>');
  $table->SetCellAttribute($i, 3, 'align', 'center');

  foreach ($factory->Results[$licensePlate][PARA_BASE] as $base)
  {
    $i = $table->AddRow();
    $table->SetCellContent($i, 1, $base['LicenseeName']);
    $table->SetCellAttribute($i, 1, 'align', 'center');
    $table->SetCellContent($i, 2, sprintf('%s %s %s', $base['StreetAddress'], $base['City'], $base['ZipCode']));
    $table->SetCellAttribute($i, 2, 'align', 'center');
    $table->SetCellContent($i, 3, $base['Telephone']);
    $table->SetCellAttribute($i, 3, 'align', 'center');
  }

  $tableData[PARA_BASE] = $table->Render(false);
}

if ($factory->Results[$licensePlate][PARA_VEHICLE])
{
	$table = new HtmlTable('para-vehicle');
	$table->SetTableAttribute('cellspacing', 0);
	$table->SetTableAttribute('cellpadding', '4');
	$table->SetTableAttribute('border', 1);
	$table->SetTableAttribute('align', 'center');
	
	$i = $table->AddRow();
	$table->SetCellContent($i, 1, '<b>Licensee Name</b>');
	$table->SetCellAttribute($i, 1, 'align', 'center');
	$table->SetCellContent($i, 2, '<b>VIN</b>');
	$table->SetCellAttribute($i, 2, 'align', 'center');
	$table->SetCellContent($i, 3, '<b>Model Year</b>');
	$table->SetCellAttribute($i, 3, 'align', 'center');
	
	foreach ($factory->Results[$licensePlate][PARA_VEHICLE] as $vehicle)
	{
 		$i = $table->AddRow();
		$table->SetCellContent($i, 1, $vehicle['LicenseeName']);
		$table->SetCellAttribute($i, 1, 'align', 'center');
		$table->SetCellContent($i, 2, $vehicle['VIN']);
		$table->SetCellAttribute($i, 2, 'align', 'center');
		$table->SetCellContent($i, 3, $vehicle['ModelYear']);
		$table->SetCellAttribute($i, 3, 'align', 'center');
	}
			
	$tableData[PARA_VEHICLE] = $table->Render(false);
}

foreach ($tableData as $type => $table)
{
  $table = str_replace(array("\n", "\t"), '', $table);
  $tableData[$type] = str_replace('"', '\"', $table);
}

printf("{\"base\": \"%s\",\n \"vehicle\": \"%s\"\n}", $tableData[PARA_BASE], $tableData[PARA_VEHICLE]);
?>
