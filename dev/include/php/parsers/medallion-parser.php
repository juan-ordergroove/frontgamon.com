<?php
require_once(PHP_DEV . 'classes/NYC/YellowCabMedallion.class.php');

if ($fh = fopen('current_medallions.csv', 'r'))
{
		$bFirstPass = true;
		
		while (!feof($fh))
		{
				$line = fgets($fh);
				$linePieces = explode(';', $line);
				
				// Skip column headers
				if ($bFirstPass)
				{
						$bFirstPass = false;
						continue;
				}
				
				var_dump($linePieces);
				$medallion = new YellowCabMedallion();
				$medallion->LicenseNumber = trim($linePieces[0]);
				$medallion->NameOfLicensee = trim($linePieces[1]);
				$medallion->LicenseType = trim($linePieces[2]);
				$medallion->DriverRecordStatus = trim($linePieces[3]);
				$medallion->DMVLicensePlate = trim($linePieces[4]);
				$medallion->VIN = trim($linePieces[5]);
				$medallion->VehicleType = trim($linePieces[6]);
				$medallion->ModelYear = intval(trim($linePieces[7]));
				$medallion->TypeOfMedallion = trim($linePieces[8]);
				$medallion->MedallionAgentNumber = trim($linePieces[9]);
				
				$vd = new ValidateData();
				$medallion->Save($vd);
		}
}
else
		printf("Could not open current_medaillion_agents.csv");

?>
