<?php
require_once(PHP_LIVE . 'classes/ParentObject.class.php');

require_once(PHP_LIVE . 'lib/ValidateData.class.php');

require_once(PHP_LIVE . 'lib/SqlQueryBuilder.class.php');

class Object extends ParentObject
{
	function Object()
	{
			parent::ParentObject('FG', 'Frontgamon');
	}
}
?>