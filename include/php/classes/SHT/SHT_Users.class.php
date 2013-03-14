<?php
require_once('SHT_Object.class.php');

class SHT_Users extends SHT_Object
{
  var $UserID;
  var $UserName;
  var $UserPassword;

  function SHT_Users()
  {
    $this->UserID = 0;
    $this->UserName = '';
    $this->UserPassword = '';
    
    parent::SHT_Object();
  }
  
  function Init($rs = false)
  {
				parent::Init($rs);
  }
  
  function FetchAllUsers()
  {
				$query = 'select * from Users';
		
    return $this->Execute($query);
  }

		function FetchById($userId)
		{
    if ($this->Connect() && $userId > 0)
				{
						$query = "SELECT * FROM Users WHERE UserID = '{$userId}';";
						
						if ($this->Init($this->Execute($query)))
								return true;
				}
				
    return false;
		}
		
  function Fetch($username)
  {
				if ($this->Connect() && strlen($username) > 0)
				{
						$query = "SELECT * FROM Users WHERE UserName = '{$username}';";
						
						if ($this->Init($this->Execute($query)))
								return true;
				}
				
				return false;
  }

  function Save($vd)
  {
		
  }

  function Validate($vd)
  {
		if (!strlen($this->UserName))
			$vd->errors['UserName'] = sprintf("You must choose a username.");

		if (!strlen($this->UserPassword))
			$vd->errors['UserPassword'] = sprintf("You must choose a password.");

		$passStrength = $this->pwd_valid($this->UserPassword);
		switch($passStrength)
		{
			case "1":
				break;
			case "-1":
				$vd->errors['UserPassword'] = "Password contains invalid characters";
				break;
			case "-2":
				$vd->errors['UserPassword'] = "Password does not have enough variety";
				break;
			case "-3":
				$vd->errors['UserPassword'] = "Password is too short";
				break;
			default:
				$vd->errors['VDError'] = "Password validation failed";
		}

		return $vd->HasErrors();
	}

	#############################################################################
	# int pwd_valid(str pwd [, int minLen [,int minStr [,str $specials = "_-"]]])
	#
	# inputs:  pwd:      the password to be checked
	#          minLen:   minimum length allowed for the password
	#          minStr:   minimum number of different character types required
	#          specials: special characters allowed in password (non alphanumerics)
	#
	# returns:  1: password is OK
	#          -1: password contains an invalid character
	#          -2: not enough variety of character types
	#          -3: contains an invalid character
	#############################################################################
	function pwd_valid($pwd, $minLen = 8, $minStr = 1, $specials = '_-')
	{
		$result = 1;   # initialize to OK

		if (strlen($pwd) >= $minLen)
		{
			$specials = preg_replace('/(\W|-)/', "\\\\$1", $specials);
			$invalid = "/[^a-zA-Z0-9$specials]/";

			if (preg_match($invalid, $pwd))
			{
				$result = -1;  # password contains an invalid character
		  }
	    else
	    {
	      $strength = 0;
 	      foreach (array("a-z", "A-Z", "0-9", "$specials") as $chars)
					if (preg_match("/[$chars]/", $pwd))
          	$strength++;
      }

      if ($strength < $minStr)
        $result = -2;   # not enough variety of character types
		}
  	else
    	$result = -3;   # password not long enough

		return($result);
	}
}
?>