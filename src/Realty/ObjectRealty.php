<?php

namespace Deripipka\Egrn\Realty;

use Deripipka\Egrn\Owners\OwnerFabric;

class ObjectRealty extends EgrnRealty
{
    public function getCadastralNumber() : string
    {
        return $this->egrn['CadastralNumber'] ?? '';
    }

    public function getAddress() : string
    {
        return $this->egrn['Address']['Content'] ?? parent::getAddress();
    }

    public function getType() : string
    {
        if(isset($this->egrn['ObjectType'])) {
            $types = include 'resources/realtyTypes.php';
            return $types[$this->egrn['ObjectType']] ?? '';
        } else {
            return '';
        }
    }

    public function getOwner()
    {
        if (isset($this->egrn['Owner'][0])) {
            $owners = [];
            foreach ($this->egrn['Owner'] as $item) {
                $owner = OwnerFabric::create($item);
                $owners[] = $this->assembleString($owner);
            }
            return $this->arrayToString($owners);
        }
        if (isset($this->egrn['Owner'])) {
            $owner = OwnerFabric::create($this->egrn);
            return $this->assembleString($owner);
        }
        return false;
    }
}
