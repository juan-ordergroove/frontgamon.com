<?php
require_once(PHP_DEV . 'classes/NYC/CabInsurance.class.php');

if ($fh = fopen('insurance.csv', 'r'))
{
		$bFirstPass = true;

		echo "Opened file \"insurance.csv\"\n";
		while (!feof($fh))
		{
				$line = fgets($fh);
				$linePieces = explode(';', $line);
				foreach ($linePieces as $i => $piece)
						$linePieces[$i] = trim($piece);
				
				// Skip column headers
				if ($bFirstPass)
				{
						$bFirstPass = false;
						continue;
				}

        printf("Saving license number: %s\n", $linePieces[1]);

        $cabInsurance = new CabInsurance();
        $cabInsurance->TLCLicenseType = $linePieces[0];
        $cabInsurance->TLCLicenseNumber = $linePieces[1];
        $cabInsurance->DMVPlate = $linePieces[2];
        $cabInsurance->VIN = $linePieces[3];
        $cabInsurance->InsuranceCode = intval($linePieces[4]);
        $cabInsurance->InsurancePolicyNumber = $linePieces[5];
        $cabInsurance->VehicleOwnerName = $linePieces[6];
        $cabInsurance->AffiliatedBaseTaxiAgentFleetNumber = $linePieces[7];
        //var_dump($cabInsurance);

        $vd = new ValidateData();
        
        if (!$cabInsurance->Save($vd))
          printf("... failed to save: %s\n", $cabInsurance->TLCLicenseNumber);
		}
}
else {
		echo "Could not open file \"insurance.csv\"\n";
}
