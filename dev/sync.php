<?php
		/*****************************************************************
			* Make sure directory exists before executing script.
			*
			* It can create files, not directories, for now...
			*
			*****************************************************************/

function writeFile($syncPath, $contents)
{
		$handle = (file_exists($syncPath) ? fopen($syncPath, 'w+') : fopen($syncPath, 'x+'));
		if ($handle)
		{
				fwrite($handle, $contents);
				fclose($handle);
		}
		else
				echo "$syncPath failed to be created...\n";
}

function scanFile($filePath)
{
		$contents = file_get_contents($filePath);
		
		// If it's a php file, replace PHP_DEV with PHP_LIVE... (or ADODB)
		if (strpos($filePath, ".php"))
		{
				if (strpos($contents, 'PHP_DEV'))
						$contents = str_replace('PHP_DEV', 'PHP_LIVE', $contents);

				if (strpos($contents, 'ADODB_DEV'))
						$contents = str_replace('ADODB_DEV', 'ADODB_LIVE', $contents);
		}

		// Copy from /var/www/dev<filePath> to /var/www<filePath> by:
		//   1. Open a new file handler to /var/www<filePath>
		//   2. Dump $contents into handler
		//   3. Close handler
	 $syncPath = str_replace("dev/", '', $filePath);
		$newDir = explode("/", trim($syncPath));
		$file = array_pop($newDir);
		
		if (file_exists($syncPath) || is_dir(implode("/", $newDir)))
		{
				writeFile($syncPath, $contents);
		}
		else
		{
				mkdir(implode("/", $newDir), 0755, true);
				
				writeFile($syncPath, $contents);
		}
}

function traverseDir($dirName)
{
		global $denied;
		
		$handler = opendir($dirName);
		
		while ($file = readdir($handler))
		{
				if (in_array($file, $denied))
						continue;
				
				$path = $dirName . '/' . $file;
				
				if (is_dir($path))
						traverseDir($path);
				else
						scanFile($path);
		}

		closedir($handler);
}

// TODO: Decide - do js/ manually or here...
$denied = array('.', '..', '.hg', 'sync.php', 'wiki', 'cacti', 'phpmyadmin');

if (isset($argv[1]))
{		
		if ($argv[1][strlen($argv[1]) - 1] == '/')
		{
				echo "/////////////////////////////////////////////////////////////////////////\n";
				echo "Please remember to leave your path free of the trailing '/'.\n";
				echo "/////////////////////////////////////////////////////////////////////////\n";
				exit;
		}
		else if($argv[1][0] == '.')
		{
				echo "/////////////////////////////////////////////////////////////////////////\n";
				echo "Don't use relative paths.\n";
				echo "/////////////////////////////////////////////////////////////////////////\n";
				exit;
		}
		else if($argv[1][0] != '/')
		{
				echo "/////////////////////////////////////////////////////////////////////////\n";
				echo "Make sure to use the full dev path you want to sync into production.\n";
				echo "/////////////////////////////////////////////////////////////////////////\n";
				exit;
		}

		traverseDir($argv[1]);
}

echo "DONE!!\n";
?>