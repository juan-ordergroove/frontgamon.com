<?php
require_once('Object.class.php');

class CurrentParatransitBase extends Object
{
  var $ID;
  var $LicenseNumber;
  var $LicenseeName;
		var $AltLicenseeName;
		var $StreetAddress;
		var $City;
		var $State;
		var $Zipcode;
		var $Telephone;
		var $LicenseType;

  function CurrentParatransitBase()
  {
				$this->ID = 0;
				$this->LicenseNumber = '';
				$this->LicenseeName = '';
				$this->AltLicenseeName = '';
				$this->StreetAddress = '';
				$this->City = '';
				$this->State = '';
				$this->Zipcode = 0;
				$this->Telephone = '';
				$this->LicenseType = '';

				parent::Object();
  }
		
  function Init($rs = false)
  {
				parent::Init($rs);
  }
		
		function SearchByLicensePlate($licensePlate)
		{
				$sql = new SQLQueryBuilder('select');
				$sql->table = 'CurrentParatransitBase';
				$sql->columns[] = '*';
				$sql->where = "LicenseNumber LIKE '%$licensePlate%'";
				$sql->limit = 10;
				
				return $this->Execute($sql->buildQuery());
		}
}
?>