<?php
require_once(PHP_DEV . 'classes/ParentObject.class.php');

require_once(PHP_DEV . 'lib/ValidateData.class.php');

require_once(PHP_DEV . 'lib/SqlQueryBuilder.class.php');

class Object extends ParentObject
{
	function Object()
	{
			parent::ParentObject('FG', 'Frontgamon');
	}
}
?>