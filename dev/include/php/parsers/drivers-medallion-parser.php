<?php
require_once (PHP_DEV . 'classes/NYC/YellowCabDriversMedallion.class.php');

$medFileName = 'authorized_drivers_medallion.csv';
$fh = fopen($medFileName, 'r') or die(sprintf("Can't open %s", $medFileName));

$medNumber = '';
$medOwner = '';

$yellowCab = new YellowCabDriversMedallion();

while (!feof($fh))
{
		$line = fgets($fh);
		$linePieces = explode(' ', $line);
		
		if (count($linePieces) >= 19 && preg_match("/\d[A-Z]\d\d/", $linePieces[0]))
		{
				/*
					If the first index of the array (0) matches the regex \d[A-Z]\d\d, then we know
					it's the Medallion # & owner name (if we count $linePieces, it should be at least 19.
					-- verify this and use as a sanity check to make sure your not nuking relevant	data --
				*/
				
				$medNumber = trim($linePieces[0]);
				$medOwner = ''; // Clear out from previous owner
				
				for ($i = 1; $linePieces[$i] != 'TLC'; $i++)
						$medOwner = sprintf("%s%s", $medOwner, trim($linePieces[$i]));

				$yellowCab->MedNumber = $medNumber;
				$yellowCab->MedOwnerName = $medOwner;

				printf("Inputing drivers for medallion # %s...\n", $medNumber);
		}
		else if (count($linePieces) > 1 && $linePieces[0] != 'Page')
		{
				/*
					Otherwise, its a driver, and it should count out to at most 5, at least 3 (some don't have 
					LeaseStart/EndDate(s) - they are the medallion owners. Not every owner is a driver as well.
					*/
				
				$driverLicenseNum = trim($linePieces[0]);
				$driverName = trim($linePieces[1]);
				$leaseStartDate = '';
				$leaseEndDate = '';
				$driverLicenseExpirationDate = '';
				
				$i = 2;
				while (intval($linePieces[$i][0]) == 0)
						$driverName = sprintf("%s%s", $driverName, trim($linePieces[$i++]));
				
				$i = count($linePieces) - 1;
				$driverLicenseExpirationDate = trim($linePieces[$i]);
				$driverLicenseExpirationDatePieces = explode('/', $driverLicenseExpirationDate);
				$driverLicenseExpirationDate = sprintf('%s-%s-%s', $driverLicenseExpirationDatePieces[2], $driverLicenseExpirationDatePieces[0], $driverLicenseExpirationDatePieces[1]);
				
				if (intval($linePieces[$i - 1]) != 0)
				{
						$leaseEndDate = trim($linePieces[$i - 1]);
						$leaseEndDatePieces = explode('/', $leaseEndDate);
						$leaseEndDate = sprintf('%s-%s-%s', $leaseEndDatePieces[2], $leaseEndDatePieces[0], $leaseEndDatePieces[1]);
						
						$leaseStartDate = trim($linePieces[$i - 2]);
						$leaseStartDatePieces = explode('/', $leaseStartDate);
						$leaseStartDate = sprintf('%s-%s-%s', $leaseStartDatePieces[2], $leaseStartDatePieces[0], $leaseStartDatePieces[1]);
				}
				
				$yellowCab->TLCDriverLicenseNumber = $driverLicenseNum;
				$yellowCab->DriverName = $driverName;
				$yellowCab->LeaseStartDate = $leaseStartDate;
				$yellowCab->LeaseEndDate = $leaseEndDate;
				$yellowCab->TLCDriverLicenseExpirationDate = $driverLicenseExpirationDate;

				// There's a SQL syntax error and ALL dates are comming in as 0000-00-00
				$vd = new ValidateData();
				$yellowCab->Save($vd);
		}
}

fclose($fh);
?>