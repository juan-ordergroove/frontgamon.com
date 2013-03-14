<?php
require_once('Object.class.php');

class CabInsurance extends Object
{
  var $ID;
  var $TLCLicenseNumber;
  var $TLCLicenseType;
  var $DMVPlate;
  var $VIN;
  var $InsuranceCode;
  var $InsurancePolicyNumber;
  var $VehicleOwnerName;
  var $AffiliatedBaseTaxiAgentFleetNumber;

  function CabInsurance()
  {
    $this->ID = 0;
    $this->TLCLicenseNumber = '';
    $this->TLCLicenseType = '';
    $this->DMVPlate = '';
    $this->VIN = '';
    $this->InsuranceCode = 0;
    $this->InsurancePolicyNumber = '';
    $this->VehicleOwnerName = '';
    $this->AffiliatedBaseTaxiAgentFleetNumber = '';

    parent::Object();
  }

  function Init($rs = false)
  {
    parent::Init($rs);
  }

  function Save($vd)
  {
    $bNewCabInsurance = false;

    if ($this->ID == 0)
      $bNewCabInsurance = true;

    if ($this->Validate($vd))
    {
      $sql = new SQLQueryBuilder(($bNewCabInsurance) ? 'insert' : 'update');
      $sql->SetTable("CabInsurance");
      
      $sql->addColumn('TLCLicenseNumber');
      $sql->addColumn('TLCLicenseType');
      $sql->addColumn('DMVPlate');
      $sql->addColumn('VIN');
      $sql->addColumn('InsuranceCode');
      $sql->addColumn('InsurancePolicyNumber');
      $sql->addColumn('VehicleOwnerName');
      $sql->addColumn('AffiliatedBaseTaxiAgentFleetNumber');

      $sql->setValue($this->TLCLicenseNumber);
      $sql->setValue($this->TLCLicenseType);
      $sql->setValue($this->DMVPlate);
      $sql->setValue($this->VIN);
      $sql->setValue($this->InsuranceCode);
      $sql->setValue($this->InsurancePolicyNumber);
      $sql->setValue($this->VehicleOwnerName);
      $sql->setValue($this->AffiliatedBaseTaxiAgentFleetNumber);

      if ($bNewCabInsurance)
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
    // TODO: Need to properly validate for future UI

    return !$vd->HasErrors();
  }
}
?>
