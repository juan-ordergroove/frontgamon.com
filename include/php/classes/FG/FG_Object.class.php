<?php
require_once(PHP_LIVE . 'classes/Object.class.php');

require_once(PHP_LIVE . 'lib/ValidateData.class.php');

require_once(PHP_LIVE . 'lib/SqlQueryBuilder.class.php');

class FG_Object extends Object
{
	function FG_Object()
	{
			parent::Object('FG', 'Frontgamon');
	}
}
?>