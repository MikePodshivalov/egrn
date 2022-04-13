<?php

namespace Deripipka\Egrn\Realty;

use Deripipka\Egrn\Helpers;
use Deripipka\Egrn\Owners\OwnerFabric;
use Deripipka\Egrn\Owners\Registration;

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

    public function getOwnerName()
    {
        if (isset($this->egrn[0])) {
            $owners = [];
            foreach ($this->egrn as $item) {
                $owner = OwnerFabric::create($item);
                $owners[] = $owner->name;
            }
            return Helpers::arrayToString($owners);
        }
            $owner = OwnerFabric::create($this->egrn);
            return $owner->name;
    }

    public function getOwnerRegistration()
    {
        if (isset($this->egrn['Owner'][0])) {
            $owners = [];
            foreach ($this->egrn['Owner'] as $item) {
                $owner = new Registration($item);
                $owners[] = $owner->registration;
            }
            return Helpers::arrayToString($owners);
        }
        if (isset($this->egrn['Owner'])) {
            $owner = new Registration($this->egrn['Owner']);
            return $owner->registration;
        }
        return false;
    }
}
