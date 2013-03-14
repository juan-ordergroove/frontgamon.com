<?php
require_once(PHP_LIVE . 'classes/NYC/YellowCabMedallionDriver.class.php');

$files = array('current_medallion_drivers.csv', 'current_medallion_drivers_ad_complete.csv');

foreach ($files as $file)
{
		if ($fh = fopen($file, 'r'))
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
						
						$medallion = new YellowCabMedallionDriver();
						$medallion->LicenseNumber = trim($linePieces[0]);
						$medallion->NameOfLicensee = trim($linePieces[1]);
						$medallion->LicenseType = trim($linePieces[2]);
						
						$expirationDate = trim($linePieces[3]);
						$expirationDatePieces = explode('/', $expirationDate);
						$expirationDate = sprintf('%s-%s-%s', $expirationDatePieces[2], $expirationDatePieces[0], $expirationDatePieces[1]);
						$medallion->LicenseExpirationDate = $expirationDate;
						
						if (isset($linePieces[4]))
								$medallion->CompletedTraining = 'YES';
						
						$vd = new ValidateData();
						$medallion->Save($vd);
				}
		}
		else
				printf("Could not open %s\n", $file);
}
?>
