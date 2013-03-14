<?php
require_once(PHP_LIVE . 'classes/Object.class.php');

require_once(PHP_LIVE . 'lib/ValidateData.class.php');

require_once(PHP_LIVE . 'lib/SqlQueryBuilder.class.php');

class SHT_Object extends Object
{
	function SHT_Object()
	{
			parent::Object('SHT', 'StupidHumanTricks');
	}
}
?>