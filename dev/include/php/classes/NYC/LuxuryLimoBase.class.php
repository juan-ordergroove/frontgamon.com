<?php
require_once('Object.class.php');

class LuxuryLimoBase extends Object
{
  var $ID;
  var $LicenseNumber;
  var $LicenseeName;
  var $AltLicenseeName;
	var $StreetAddress;
	var $City;
	var $Zipcode;
	var $Telephone;
	var $LicenseType;

  function LuxuryLimoBase()
  {
   	$this->ID = 0;
		$this->LicenseNumber = '';
		$this->LicenseeName = '';
		$this->AltLicenseeName = '';
		$this->StreetAddress = '';
		$this->City = '';
		$this->Zipcode = '';
		$this->Telephone = '';
		$this->LicenseType = '';

		parent::Object();
  }
		
  function Init($rs = false)
  {
  	parent::Init($rs);
  }

  function Save($vd)
  {
    $bNewBase = false;

    if ($this->ID == 0)
      $bNewBase = true;

    if ($this->Validate($vd))
    {
      $sql = new SQLQueryBuilder(($bNewBase) ? 'insert' : 'update');
      $sql->SetTable("LuxuryLimoBase");

      $sql->AddColumn('LicenseNumber');
      $sql->AddColumn('LicenseeName');
      $sql->AddColumn('AltLicenseeName');
      $sql->AddColumn('StreetAddress');
      $sql->AddColumn('City');
      $sql->AddColumn('ZipCode');
      $sql->AddColumn('Telephone');
      $sql->AddColumn('LicenseType');

      $sql->setValue($this->LicenseNumber);
      $sql->setValue($this->LicenseeName);
      $sql->setValue($this->AltLicenseeName);
      $sql->setValue($this->StreetAddress);
      $sql->setValue($this->City);
      $sql->setValue($this->ZipCode);
      $sql->setValue($this->Telephone);
      $sql->setValue($this->LicenseType);

      if ($bNewBase)
      {
      }
      else
        $sql->setWhere(sprintf("ID=%d", $this->ID));

      $query = $sql->buildQuery();
      if (!$this->Execute($query))
      {
        new Dump($this->ErrorMsg());
        return false;
      }
      else
        return true;
    }

    return !$vd->HasErrors();
  }

  function Validate($vd)
  {
    return !$vd->HasErrors();
  }
}
?>
