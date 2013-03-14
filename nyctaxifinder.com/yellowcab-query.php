<?php
require_once(PHP_LIVE . 'HtmlControl/HtmlTable.inc.php');
require_once(PHP_LIVE . 'classes/NYC/NYCTaxiFactory.class.php');
require_once(PHP_LIVE . 'classes/NYC/YellowCabMedallion.class.php');

$licenseNumber = isset($_REQUEST['licenseNumber']) ? trim($_REQUEST['licenseNumber']) : '';
if (!preg_match('/^\d[A-Za-z]\d\d$/', $licenseNumber))
  $licenseNumber = '';

$yellowCabMedallion = new YellowCabMedallion();
$taxiFactory = new NYCTaxiFactory($yellowCabMedallion, $licenseNumber);
$taxiFactory->BuildLicenseNumberData();

$defaultText = 'No data is currently available.';
$tableData = array(
    NYC_LICENSE_TYPE => $defaultText, 
    NYC_DRIVERS => $defaultText,
    NYC_INSURANCE => $defaultText,
    NYC_INSPECTION => $defaultText
);

$medallion = $taxiFactory->FactoryResults[$licenseNumber][NYC_MEDALLION];

if ($taxiFactory->FactoryResults[$licenseNumber][NYC_LICENSE_TYPE]) {
		$table = new HtmlTable('yellow-base');
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
		$table->SetCellContent($i, 4, '<b>License Type</b>');
		$table->SetCellAttribute($i, 4, 'align', 'center');
    $table->SetCellContent($i, 5, '<b>License Number</b>');
    $table->SetCellAttribute($i, 5, 'align', 'center');

		$taxiDetails = $taxiFactory->FactoryResults[$licenseNumber][NYC_LICENSE_TYPE];
		foreach ($taxiDetails as $details)
		{
				$address = sprintf('%s %s, %s, %s', $details['StreetAddress'], $details['City'], $details['State'], $details['ZipCode']);

				$i = $table->AddRow();
				$table->SetCellContent($i, 1, $details['NameOfLicensee']);
				$table->SetCellAttribute($i, 1, 'align', 'center');
				$table->SetCellContent($i, 2, $address);
				$table->SetCellAttribute($i, 2, 'align', 'center');
				$table->SetCellContent($i, 3, $details['Telephone']);
				$table->SetCellAttribute($i, 3, 'align', 'center');
				$table->SetCellContent($i, 4, $details['LicenseType']);
				$table->SetCellAttribute($i, 4, 'align', 'center');
        $table->SetCellContent($i, 5, $details['LicenseNumber']);
        $table->SetCellAttribute($i, 5, 'align', 'center');
		}

		$tableData[NYC_LICENSE_TYPE] = $table->Render(false);
}

if ($taxiFactory->FactoryResults[$licenseNumber][NYC_DRIVERS])
{
		$table = new HtmlTable('yellow-driver');
		$table->SetTableAttribute('cellspacing', 0);
		$table->SetTableAttribute('cellpadding', '4');
		$table->SetTableAttribute('border', 1);
		$table->SetTableAttribute('width', '50%');
		$table->SetTableAttribute('align', 'center');

		$i = $table->AddRow();
		$table->SetCellContent($i, 1, '<b>Driver Name</b>');
		$table->SetCellAttribute($i, 1, 'align', 'center');
    $table->SetCellContent($i, 2, '<b>License Expiration</b>');
    $table->SetCellAttribute($i, 2, 'align', 'center');
		$taxiDrivers = $taxiFactory->FactoryResults[$licenseNumber][NYC_DRIVERS];
		foreach ($taxiDrivers as $driver)
		{
				$driverNamePieces = explode(',', $driver['DriverName']);

				$i = $table->AddRow();
				$table->SetCellContent($i, 1, $driverNamePieces[1] . ' ' . $driverNamePieces[0]);
				$table->SetCellAttribute($i, 1, 'align', 'center');
        $table->SetCellContent($i, 2, $driver['TLCDriverLicenseExpirationDate']);
        $table->SetCellAttribute($i, 2, 'align', 'center');
	 }

		$tableData[NYC_DRIVERS] = $table->Render(false);
}

if ($taxiFactory->FactoryResults[$licenseNumber][NYC_INSURANCE])
{
		// Insurance info is all the same for a car, so only grab it for the first driver
		$firstDriver = $taxiFactory->FactoryResults[$licenseNumber][NYC_INSURANCE][0];

		$table = new HtmlTable('yellow-vehicle');
		$table->SetTableAttribute('cellspacing', 0);
		$table->SetTableAttribute('cellpadding', '4');
		$table->SetTableAttribute('border', 1);
		$table->SetTableAttribute('align', 'center');

		$i = $table->AddRow();
		$table->SetCellContent($i, 1, '<b>Vehicle Owner</b>');
		$table->SetCellAttribute($i, 1, 'align', 'center');
		$table->SetCellContent($i, 2, '<b>Insurance Code</b>');
		$table->SetCellAttribute($i, 2, 'align', 'center');
		$table->SetCellContent($i, 3, '<b>Insurance Policy Number</b>');
		$table->SetCellAttribute($i, 3, 'align', 'center');
    $table->SetCellContent($i, 4, '<b>VIN</b>');
    $table->SetCellAttribute($i, 4, 'align', 'center');
    $table->SetCellContent($i, 5, '<b>Type</b>');
    $table->SetCellAttribute($i, 5, 'align', 'center');
    $table->SetCellContent($i, 6, '<b>Model Year</b>');
    $table->SetCellAttribute($i, 6, 'align', 'center');

    $vehicleType = $medallion[0]['Vehicle']['Type'];
    $vehicleType = ($vehicleType == 'HYB' ? 'Hybrid' : ($vehicleType == 'DSEL' ? 'Diesel' : 'Standard'));

		$i = $table->AddRow();
		$table->SetCellContent($i, 1, $firstDriver['VehicleOwnerName']);
		$table->SetCellAttribute($i, 1, 'align', 'center');
		$table->SetCellContent($i, 2, $firstDriver['InsuranceCode']);
		$table->SetCellAttribute($i, 2, 'align', 'center');
		$table->SetCellContent($i, 3, $firstDriver['InsurancePolicyNumber']);
		$table->SetCellAttribute($i, 3, 'align', 'center');
    $table->SetCellContent($i, 4, $medallion[0]['VIN']);
    $table->SetCellAttribute($i, 4, 'align', 'center');
    $table->SetCellContent($i, 5, $vehicleType);
    $table->SetCellAttribute($i, 5, 'aling', 'center');
    $table->SetCellContent($i, 6, $medallion[0]['ModelYear']);
    $table->SetCellAttribute($i, 6, 'align', 'center');

		$tableData[NYC_INSURANCE] = $table->Render(false);
}

if ($taxiFactory->FactoryResults[$licenseNumber][NYC_INSPECTION])
{
		$table = new HtmlTable('inspection');
		$table->SetTableAttribute('cellspacing', 0);
		$table->SetTableAttribute('cellpadding', '4');
		$table->SetTableAttribute('border', 1);
		$table->SetTableAttribute('align', 'center');

		$i = $table->AddRow();
		$table->SetCellContent($i, 1, '<b>Scheduled Date</b>');
		$table->SetCellAttribute($i, 1, 'align', 'center');
		$table->SetCellContent($i, 2, '<b>Scheduled Time</b>');
		$table->SetCellAttribute($i, 2, 'align', 'center');

		foreach ($taxiFactory->FactoryResults[$licenseNumber][NYC_INSPECTION] as $inspectionDate)
		{
				$i = $table->AddRow();
				$table->SetCellContent($i, 1, $inspectionDate['ScheduleDate']);
				$table->SetCellAttribute($i, 1, 'align', 'center');
				$table->SetCellContent($i, 2, $inspectionDate['ScheduleTime']);
				$table->SetCellAttribute($i, 2, 'align', 'center');
		}
    
		$tableData[NYC_INSPECTION] = $table->Render(false);
}

foreach ($tableData as $type => $table)
{
  $table = str_replace(array("\n", "\t"), '', $table);
  $tableData[$type] = str_replace('"', '\"', $table);
}

printf(
"{\"licenseType\": \"%s\",\n 
\"drivers\": \"%s\",\n
\"insurance\": \"%s\",\n 
\"inspection\": \"%s\"\n}", $tableData[NYC_LICENSE_TYPE], $tableData[NYC_DRIVERS], $tableData[NYC_INSURANCE], $tableData[NYC_INSPECTION]);
?>
