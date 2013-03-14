<?php
require_once('Object.class.php');

class CommuterVanVehicle extends Object
{
  var $ID;
  var $AffiliatedBaseLicenseNumber;
		var $AffiliatedBaseName;
  var $LicenseNumber;
  var $LicenseeName;
  var $LicenseType;
  var $DMVLicensePlate;
  var $VIN;
  var $ModelYear;

  function CommuterVanVehicle()
  {
   	$this->ID = 0;
    $this->AffiliatedBaseLicenseNumber = '';
				$this->AffiliatedBaseName = '';
    $this->LicenseNumber = '';
    $this->LicenseeName = '';
    $this->LicenseType = '';
    $this->DMVLicensePlate = '';
    $this->VIN = '';
    $this->ModelYear = '';

		parent::Object();
  }
		
  function Init($rs = false)
  {
  	parent::Init($rs);
  }

  function Save($vd)
  {
    $bNewVehicle = false;

    if ($this->ID == 0)
      $bNewVehicle = true;

    if ($this->Validate($vd))
    {
      $sql = new SQLQueryBuilder(($bNewVehicle) ? 'insert' : 'update');
      $sql->SetTable("CommuterVanVehicle");

      $sql->AddColumn('AffiliatedBaseLicenseNumber');
      $sql->AddColumn('AffiliatedBaseName');
						$sql->AddColumn('LicenseNumber');
      $sql->AddColumn('LicenseeName');
      $sql->AddColumn('LicenseType');
      $sql->AddColumn('DMVLicensePlate');
      $sql->AddColumn('VIN');
      $sql->AddColumn('ModelYear');

      $sql->setValue($this->AffiliatedBaseLicenseNumber);
						$sql->setValue($this->AffiliatedBaseName);
      $sql->setValue($this->LicenseNumber);
      $sql->setValue($this->LicenseeName);
      $sql->setValue($this->LicenseType);
      $sql->setValue($this->DMVLicensePlate);
      $sql->setValue($this->VIN);
      $sql->setValue($this->ModelYear);

      if ($bNewDriver)
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
