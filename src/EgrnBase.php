<?php

namespace Deripipka\Egrn;

use Deripipka\Egrn\Owners\Encumbrance;
use Deripipka\Egrn\Owners\OwnerFabric;
use Deripipka\Egrn\Owners\Registration;

abstract class EgrnBase
{
    public array $egrn;

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

    public function getKeyParameter()
    {
        return 'Площадь';
    }

    public function getCadastralCost() : string
    {
        return $this->egrn['CadastralCost']['@attributes']['Value'] ?? '';
    }

    public function getAddress() : string | array
    {
        return Helpers::parseAddress($this->egrn);
    }

    public function getInnerCadastralNumbers() : array | string
    {
        return $this->egrn['InnerCadastralNumbers'] ?? '';
    }

    public function getCategory() : string
    {
        if(isset($this->egrn['Category'])) {
            $types = include 'resources/categoryTypes.php';
            return $types[$this->egrn['Category']] ?? '';
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
            $types = include 'resources/utilizationTypes.php';
            return $types[$this->egrn['Utilization']['@attributes']['Utilization']] ?? '';
        } else {
            return '';
        }
    }

    public function getParentCadastralNumbers() : string | array
    {
        return Helpers::arrayToString($this->egrn['ParentCadastralNumbers']['CadastralNumber'] ?? '');
    }

    public function getNotes() : string
    {
        return $this->egrn['Notes'] ?? '';
    }

    public function getAssignationName()
    {
        return $this->egrn['AssignationName'] ?? '';
    }

    public function getOwnerName()
    {
        if (isset($this->egrn['Owner']['Right'][0])) {
            $owners = [];
            foreach ($this->egrn['Owner']['Right'] as $item) {
                $owner = OwnerFabric::create($item);
                $owners[] = $owner->name;
            }
            return Helpers::arrayToString($owners);
        }
        if (isset($this->egrn['Owner']['Right']['Owner'])) {
            $owner = OwnerFabric::create($this->egrn['Owner']['Right']);
            return $owner->name;
        }
        return false;
    }

    public function getOwnerRegistration()
    {
        if (isset($this->egrn['Owner']['Right'][0])) {
            $owners = [];
            foreach ($this->egrn['Owner']['Right'] as $item) {
                $owner = new Registration($item);
                $owners[] = $owner->registration;
            }
            return Helpers::arrayToString($owners);
        }
        if (isset($this->egrn['Owner']['Right']['Owner'])) {
            $owner = new Registration($this->egrn['Owner']['Right']);
            return $owner->registration;
        }
        return false;
    }

    public function getOwnerEncumbrance()
    {
        if (isset($this->egrn['Owner']['Right']['Encumbrance'][0])) {
            $owners = [];
            foreach ($this->egrn['Owner']['Right']['Encumbrance'] as $item) {
                $owner = new Encumbrance($item);
                $owners[] = $owner->encumbrance;
            }
            return Helpers::arrayToString($owners);
        }
        if (isset($this->egrn['Owner']['Right']['Encumbrance'])) {
            $owner = new Encumbrance($this->egrn['Owner']['Right']['Encumbrance']);
            return $owner->encumbrance;
        }
        return false;
    }


}