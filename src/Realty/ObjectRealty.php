<?php

namespace Deripipka\Egrn\Realty;

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
}
