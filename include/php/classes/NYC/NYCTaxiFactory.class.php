<?php
require_once(PHP_LIVE . 'lib/SqlQueryBuilder.class.php');

define('NYC_MEDALLION', 'medallion');
define('NYC_DRIVERS', 'drivers');
define('NYC_DETAILS', 'details');
define('NYC_INSURANCE', 'insurance');
define('NYC_LICENSE_TYPE', 'licenseType');
define('NYC_INSPECTION', 'inspection');

class NYCTaxiFactory
{
  var $YellowCabMedallion;
  var $FactoryResults;
  var $LicenseNumber;

  function NYCTaxiFactory($yellowCabMedallion, $licenseNumber = '')
  {
    $this->YellowCabMedallion = $yellowCabMedallion;
    $this->LicenseNumber = $licenseNumber;
    $this->FactoryResults = array(
        NYC_MEDALLION => array(),
        NYC_DRIVERS => array(),
        NYC_DETAILS => array(),
        NYC_INSURANCE => array(),
        NYC_LICENSE_TYPE => array(),
        NYC_INSPECTION => array(),
        );
  }
 
  function QueryCabTable($columnName, $columnValue, $factoryIndex, $table)
  {
    $sql = new SQLQueryBuilder('SELECT');
    $sql->SetTable($table);
    $sql->addColumn('*');
    $sql->setWhere(sprintf('%s = "%s"', $columnName, $columnValue));

    $rs = $this->YellowCabMedallion->Execute($sql->buildQuery());
    if (!$rs->fields)
    {
      $this->FactoryResults[$this->LicenseNumber][$factoryIndex] = false;
    }
    else
    {
      for (; !$rs->EOF; $rs->MoveNext())
        $this->FactoryResults[$this->LicenseNumber][$factoryIndex][] = $rs->fields;
      $rs->Close();
    }
  }

  function BuildLicenseNumberData()
  {
    $licenseNumber = $this->LicenseNumber;

    $this->QueryCabTable('LicenseNumber', $licenseNumber, NYC_MEDALLION, 'YellowCabMedallion');

    if ($this->FactoryResults[$licenseNumber][NYC_MEDALLION])
    {
      $medallion = $this->FactoryResults[$licenseNumber][NYC_MEDALLION][0];
      
      $this->QueryCabTable('MedallionAgentNumber', $medallion['MedallionAgentNumber'], NYC_LICENSE_TYPE, 'YellowCabMedallionLicenseType');
      $this->QueryCabTable('MedNumber', $licenseNumber, NYC_DRIVERS, 'YellowCabDriversMedallion');
      $this->QueryCabTable('TLCLicenseNumber', $licenseNumber, NYC_INSURANCE, 'CabInsurance');
      $this->QueryCabTable('MedNumber', $licenseNumber, NYC_INSPECTION, 'YellowCabInspection');
    }
  }
}  
?>
