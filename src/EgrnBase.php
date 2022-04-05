<?php

namespace Deripipka\Egrn;

abstract class EgrnBase
{
    public function __construct(array $egrn)
    {
        $this->egrn = $egrn;
    }

    public function getCadastralNumber() : string
    {
        return $this->egrn['@attributes']['CadastralNumber'] ?? '';
    }

    public function getArea() : string
    {
        if(isset($this->egrn['Area']['Inaccuracy'])) {
            return $this->egrn['Area']['Area'] . '+/-' . $this->egrn['Area']['Inaccuracy'];
        } else {
            return $this->egrn['Area']['Area'] ?? '';
        }
    }

    public function getCadastralCost() : string
    {
        return $this->egrn['CadastralCost']['@attributes']['Value'] ?? '';
    }

    public function getAddress() : string | array
    {
        if (isset($this->egrn['Address']['adrs:Note'])) {
            return $this->egrn['Address']['adrs:Note'];
        } else {
            $addressString = '';
            if (isset($this->egrn['Address']['adrs:PostalCode'])) {
                $addressString .= $this->egrn['Address']['adrs:PostalCode'] . ', ';
            }
            if (isset($this->egrn['Address']['adrs:Region'])) {
                $regions = include 'regions.php';
                $addressString .= $regions[$this->egrn['Address']['adrs:Region']] . ', ';
            }
            if (isset($this->egrn['Address']['adrs:City'])) {
                $addressString .= $this->egrn['Address']['adrs:City']['@attributes']['Type'] . '. ' .
                    $this->egrn['Address']['adrs:City']['@attributes']['Name'] . ', ';
            }
            if (isset($this->egrn['Address']['adrs:Street'])) {
                $addressString .= $this->egrn['Address']['adrs:Street']['@attributes']['Type'] . '. ' .
                    $this->egrn['Address']['adrs:Street']['@attributes']['Name'] . ', ';
            }
            if (isset($this->egrn['Address']['adrs:Level1'])) {
                $addressString .= $this->egrn['Address']['adrs:Level1']['@attributes']['Type'] . '. ' .
                    $this->egrn['Address']['adrs:Level1']['@attributes']['Value'] . ', ';
            }
            if (isset($this->egrn['Address']['adrs:Level2'])) {
                $addressString .= $this->egrn['Address']['adrs:Level2']['@attributes']['Type'] . '. ' .
                    $this->egrn['Address']['adrs:Level2']['@attributes']['Value'] . ', ';
            }
            if (isset($this->egrn['Address']['adrs:Level3'])) {
                $addressString .= $this->egrn['Address']['adrs:Level3']['@attributes']['Type'] . '. ' .
                    $this->egrn['Address']['adrs:Level3']['@attributes']['Value'] . ', ';
            }
            if (isset($this->egrn['Address']['adrs:Apartment'])) {
                $addressString .= $this->egrn['Address']['adrs:Apartment']['@attributes']['Type'] . '. ' .
                    $this->egrn['Address']['adrs:Apartment']['@attributes']['Value'] . ', ';
            }
            if (isset($this->egrn['Address']['adrs:Other'])) {
                $addressString .= $this->egrn['Address']['adrs:Other'] . ', ';
            }
            return $addressString;
        }
    }

    public function getRealtyType() : string
    {
        if(isset($this->egrn['ObjectType'])) {
            $types = include 'realtyTypes.php';
            return $types[$this->egrn['ObjectType']];
        } else {
            return '';
        }
    }

    public function getInnerCadastralNumbers() : array | string
    {
        return $this->egrn['InnerCadastralNumbers'] ?? '';
    }

    public function getCategory() : string
    {
        if(isset($this->egrn['Category'])) {
            $types = include 'categoryTypes.php';
            return $types[$this->egrn['Category']];
        } else {
            return '';
        }
    }

    public function getName() : string
    {
        return $this->egrn['Name'] ?? '';
    }

    public function getUtilization() : string
    {
        if(isset($this->egrn['Utilization']['@attributes']['Utilization'])) {
            $types = include 'utilizationType.php';
            return $types[$this->egrn['Utilization']['@attributes']['Utilization']];
        } else {
            return '';
        }
    }

    public function getParentCadastralNumbers() : string
    {
        return $this->egrn['ParentCadastralNumbers']['CadastralNumber'] ?? '';
    }

    public function getNotes() : string
    {
        return $this->egrn['Notes'] ?? '';
    }

}