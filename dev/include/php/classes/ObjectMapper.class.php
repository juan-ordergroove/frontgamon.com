<?php
require_once('Database.class.php');

require_once(PHP_DEV . 'lib/Dump.class.php');

class ObjectMapper extends Database
{
		var $nameSpace;
		
		function ObjectMapper($nameSpace, $dbName = '')
		{
				$this->nameSpace = $nameSpace;
				parent::Database($dbName);
		}

	function MapToObject($rs = false)
	{
		if ($rs)
		{
			$class = get_class($this);

			if (file_exists(PHP_DEV . 'classes/' . $this->nameSpace . '/' . $class . '.class.php'))
			{
				require_once(PHP_DEV . 'classes/' . $this->nameSpace . '/' . $class . '.class.php');
				
				$classObj = new $class();
				
				$vars = get_object_vars($classObj);
				
				foreach (array_keys($vars) as $key)
			  {
					if (strpos(strtolower($key), 'db'))
						continue;
					
					if ($rs->Fields($key))
						$this->$key = $rs->Fields($key);
					else
						sprintf("Couldn't find %s.\n", $key);
				}
				
				return true;
			}
			else
			{
					echo sprintf("ObjectMapper -> Unknown file path: %s<br>", PHP_DEV . 'classes/' . $this->nameSpace . '/' . $class . '.class.php');
			}
		}

		return false;
	}
}
?>