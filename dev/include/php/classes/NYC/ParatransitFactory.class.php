<?php
require_once(PHP_DEV . 'lib/SqlQueryBuilder.class.php');

define('PARA_BASE', 'base');
define('PARA_DRIVER', 'driver');
define('PARA_VEHICLE', 'vehicle');

class ParatransitFactory
{
  var $ParatransitVehicle;
  var $Results;
  var $LicensePlateNumber;

  function ParatransitFactory($paraVehicle, $licensePlateNumber)
  {
    $this->ParatransitVehicle = $paraVehicle;
    $this->LicensePlateNumber = $licensePlateNumber;
    $this->Results[$licensePlateNumber] = array(
        PARA_BASE => array(),
        PARA_DRIVER => array(),
        PARA_VEHICLE => array(),
        );
  }

  function QueryCabTable($columnName, $columnValue, $factoryIndex, $table)
  {
    $sql = new SQLQueryBuilder('SELECT');
    $sql->SetTable($table);
    $sql->addColumn('*');
    $sql->setWhere(sprintf('%s = "%s"', $columnName, $columnValue));

    $rs = $this->ParatransitVehicle->Execute($sql->buildQuery());
    if (!$rs->fields)
    {
      $this->Results[$this->LicensePlateNumber][$factoryIndex] = false;
    }
    else
    {
      for (; !$rs->EOF; $rs->MoveNext())
        $this->Results[$this->LicensePlateNumber][$factoryIndex][] = $rs->fields;
      $rs->Close();
    }
  }

  function BuildParatransitFactory()
  {
    $DMVLicensePlate = $this->LicensePlateNumber;

    $this->QueryCabTable('DMVLicensePlate', $DMVLicensePlate, PARA_VEHICLE, 'ParatransitVehicle');
    
    if ($this->Results[$DMVLicensePlate][PARA_VEHICLE])
    {
      $vehicle = $this->Results[$DMVLicensePlate][PARA_VEHICLE][0];

      $this->QueryCabTable('LicenseNumber', $vehicle['AffiliatedBaseLicenseNumber'], PARA_BASE, 'ParatransitBase');
    }
  }
}
?>
