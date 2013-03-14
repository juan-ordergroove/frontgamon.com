<?php
require_once(PHP_LIVE . 'HtmlControl/HtmlTable.inc.php');
require_once(PHP_LIVE . 'classes/NYC/FHVDriver.class.php');
require_once(PHP_LIVE . 'classes/NYC/FHVFactory.class.php');

$fhvType = isset($_REQUEST['type']) ? trim($_REQUEST['type']) : '';
$licensePlate = isset($_REQUEST['licensePlate']) ? trim($_REQUEST['licensePlate']) : '';

/*
if (!preg_match('/^(T\d+C)|(\d+LA)|(AMBU\d+)$/', $licensePlate))
  $licensePlate = '';
*/

$driver = new FHVDriver();
$factory = new FHVFactory($driver, $licensePlate, $fhvType);
$factory->BuildFHVFactory();

$defaultText = 'No data is currently available.';
$tableData = array(
    FHV_BASE => $defaultText,
    FHV_DRIVER => $defaultText,
    FHV_VEHICLE => $defaultText,
);

if ($factory->Results[$licensePlate][FHV_BASE])
{
  $table = new HtmlTable('fhv-base');
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

  foreach ($factory->Results[$licensePlate][FHV_BASE] as $base)
  {
    $i = $table->AddRow();
    $table->SetCellContent($i, 1, $base['LicenseeName']);
    $table->SetCellAttribute($i, 1, 'align', 'center');
    $table->SetCellContent($i, 2, sprintf('%s %s %s', $base['StreetAddress'], $base['City'], $base['ZipCode']));
    $table->SetCellAttribute($i, 2, 'align', 'center');
    $table->SetCellContent($i, 3, $base['Telephone']);
    $table->SetCellAttribute($i, 3, 'align', 'center');
  }

  $tableData[FHV_BASE] = $table->Render(false);
}

if ($factory->Results[$licensePlate][FHV_VEHICLE])
{
  $table = new HtmlTable('fhv-vehicle');
  $table->SetTableAttribute('cellspacing', 0);
  $table->SetTableAttribute('cellpadding', '4');
  $table->SetTableAttribute('border', 1);
  $table->SetTableAttribute('align', 'center');

  $i = $table->AddRow();
  $table->SetCellContent($i, 1, '<b>License Number</b>');
  $table->SetCellAttribute($i, 1, 'align', 'center');
  $table->SetCellContent($i, 2, '<b>Licensee Name</b>');
  $table->SetCellAttribute($i, 2, 'align', 'center');
  $table->SetCellContent($i, 3, '<b>VIN</b>');
  $table->SetCellAttribute($i, 3, 'align', 'center');
  $table->SetCellContent($i, 4, '<b>Model Year</b>');
  $table->SetCellAttribute($i, 4, 'align', 'center');

  foreach ($factory->Results[$licensePlate][FHV_VEHICLE] as $vehicle)
  {
    $i = $table->AddRow();
    $table->SetCellContent($i, 1, $vehicle['LicenseNumber']);
    $table->SetCellAttribute($i, 1, 'align', 'center');
    $table->SetCellContent($i, 2, $vehicle['LicenseeName']);
    $table->SetCellAttribute($i, 2, 'align', 'center');
    $table->SetCellContent($i, 3, $vehicle['VIN']);
    $table->SetCellAttribute($i, 3, 'align', 'center');
    $table->SetCellContent($i, 4, $vehicle['ModelYear']);
    $table->SetCellAttribute($i, 4, 'align', 'center');
  }

  $tableData[FHV_VEHICLE] = $table->Render(false);
}

if ($factory->Results[$licensePlate][FHV_DRIVER])
{
  $table = new HtmlTable('fhv-driver');
  $table->SetTableAttribute('cellpadding', '4');
  $table->SetTableAttribute('border', 1);
  $table->SetTableAttribute('align', 'center');

  $i = $table->AddRow();
  $table->SetCellContent($i, 1, '<b>Driver Name</b>');
  $table->SetCellAttribute($i, 1, 'align', 'center');
  $table->SetCellContent($i, 2, '<b>License Expiration Date');
  $table->SetCellAttribute($i, 2, 'align', 'center');

  foreach ($factory->Results[$licensePlate][FHV_DRIVER] as $driver)
  {
    $i = $table->AddRow();
    $table->SetCellContent($i, 1, $driver['LicenseeName']);
    $table->SetCellAttribute($i, 1, 'align', 'center');
    $table->SetCellContent($i, 2, $driver['LicenseExpirationDate']);
    $table->SetCellAttribute($i, 2, 'align', 'center');
  }

  $tableData[FHV_DRIVER] = $table->Render(false);
}

foreach ($tableData as $type => $table)
{
  $table = str_replace(array("\n", "\t"), '', $table);
  $tableData[$type] = str_replace('"', '\"', $table);
}

printf(
"{\"type\": \"%s\",\n
\"base\": \"%s\",\n
\"drivers\": \"%s\",\n
\"vehicle\": \"%s\",\n
}", $factory->FHVType, $tableData[FHV_BASE], $tableData[FHV_DRIVER], $tableData[FHV_VEHICLE]);
?>
