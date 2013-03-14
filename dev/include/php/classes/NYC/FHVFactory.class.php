<?php
require_once(PHP_DEV . 'lib/SqlQueryBuilder.class.php');

define ('FHV_BASE', 'base');
define ('FHV_DRIVER', 'driver');
define ('FHV_VEHICLE', 'vehicle');

$fhvTableMap = array(
    'Black Car' => 'BlackCar',
    'Community Car' => 'CommunityCar',
    'Luxury Limousine' => 'LuxuryLimo',
    'Commuter Van' => 'CommuterVan',
);

class FHVFactory
{
  var $FHVDriver;
  var $Results;
  var $LicensePlateNumber;
  var $FHVType;

  function FHVFactory($fhvDriver, $licensePlateNumber, $fhvType)
  {
    $this->FHVDriver = $fhvDriver;
    $this->LicensePlateNumber = $licensePlateNumber;
    $this->FHVType = $fhvType;
    $this->Results = array(
      FHV_BASE => array(),
      FHV_DRIVER => array(),
      FHV_VEHICLE => array(),
    );
  }

  function QueryCabTable($columnName, $columnValue, $factoryIndex, $table)
  {
    $sql = new SQLQueryBuilder('SELECT');
    $sql->SetTable($table);
    $sql->addColumn('*');
    $sql->setWhere(sprintf('%s = "%s"', $columnName, $columnValue));
				
    $rs = $this->FHVDriver->Execute($sql->buildQuery());
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

  function BuildFHVFactory()
  {
		global $fhvTableMap;

    $DMVLicensePlate = $this->LicensePlateNumber;
	
		foreach ($fhvTableMap as $fhvKey => $fhvType)
    {
			$this->QueryCabTable('DMVLicensePlate', $DMVLicensePlate, FHV_VEHICLE, sprintf('%sVehicle', $fhvType));
				
			if ($this->Results[$DMVLicensePlate][FHV_VEHICLE])
			{
				$vehicle = $this->Results[$DMVLicensePlate][FHV_VEHICLE][0];
							
				$this->QueryCabTable('LicenseNumber', $vehicle['AffiliatedBaseLicenseNumber'], FHV_BASE, sprintf('%sBase', $fhvType));
        $this->FHVType = $fhvKey;
				break;
			}
		}
  }
}
?>
