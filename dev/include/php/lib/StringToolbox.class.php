<?php
class StringToolbox
{
		function StringToolbox()
		{
				
		}

		function Truncate($str, $length = 0)
		{
				if ($length > 0 && strlen($str) > $length)
						return (substr($str, 0, $length) . '...');
				else
						return $str;
		}
}
?>