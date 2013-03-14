<?php
require_once(PHP_LIVE . 'classes/Object.class.php');

require_once(PHP_LIVE . 'lib/ValidateData.class.php');

require_once(PHP_LIVE . 'lib/SqlQueryBuilder.class.php');

class SB_Object extends Object
{
	function SB_Object()
	{
			parent::Object('SB', 'TheShortyBus');
	}
}
?>