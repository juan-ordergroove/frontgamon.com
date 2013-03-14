<?php
require_once(PHP_DEV . 'classes/NYC/YellowCabMedallionLicenseType.class.php');

$files = array('current_taxicab_brokers.csv', 'current_taxicab_metershops.csv', 'current_medallion_agents.csv');

foreach ($files as $file)
{
		if ($fh = fopen($file, 'r'))
		{
				$bFirstPass = true;
				
				while (!feof($fh))
				{
						// Skip column headers
						if ($bFirstPass)
						{
								$bFirstPass = false;
								continue;
						}
						
						$line = fgets($fh);
						$linePieces = explode(';', $line);
						
						$medallionLicenseType = new YellowCabMedallionLicenseType();
						$medallionLicenseType->LicenseNumber = trim($linePieces[0]);
						$medallionLicenseType->ConvertLicenseNumberToMedallionAgentNumber();
						$medallionLicenseType->NameOfLicensee = trim($linePieces[1]);
						$medallionLicenseType->StreetAddress = trim($linePieces[2]);
						$medallionLicenseType->City = trim($linePieces[3]);
						$medallionLicenseType->State = trim($linePieces[4]);
						$medallionLicenseType->ZipCode = trim($linePieces[5]);
						$medallionLicenseType->Telephone = trim($linePieces[6]);
						$medallionLicenseType->LicenseType = trim($linePieces[7]);
						
						$vd = new ValidateData();
						$medallionLicenseType->Save($vd);
				}
		}
		else
				printf("Could not open current_medaillion_agents.csv");
}
?>
