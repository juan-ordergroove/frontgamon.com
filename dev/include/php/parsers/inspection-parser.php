<?php
require_once(PHP_DEV . 'classes/NYC/YellowCabInspection.class.php');

if ($fh = fopen('inspection.csv', 'r'))
{
		$bFirstPass = true;

		echo "Opened file \"inspection.csv\"\n";
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

        printf("Saving license number: %s\n", $linePieces[0]);
        
        $scheduleDatePieces = explode('/', $linePieces[1]);

        if (count($scheduleDatePieces) != 3)
          printf("Scheduled date %s is not of the form 'YYYY/MM/DD'\n", $linePieces[1]);

        $cabInspection = new YellowCabInspection();
        $cabInspection->MedNumber = $linePieces[0];
        $cabInspection->ScheduleDate = sprintf('%s-%s-%s', $scheduleDatePieces[2], $scheduleDatePieces[0], $scheduleDatePieces[1]);
        $cabInspection->ScheduleTime = $linePieces[2];
        $cabInspection->FleetAgentCode = $linePieces[3];
        //var_dump($cabInspection);

        $vd = new ValidateData();
        
        if (!$cabInspection->Save($vd))
          printf("... failed to save: %s\n", $cabInspection->MedNumber);
		}
}
else {
		echo "Could not open file \"inspection.csv\"\n";
}

echo "DONE!\n";
