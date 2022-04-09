<?php

namespace Deripipka\Egrn\Realty;

class Uncompleted extends EgrnRealty
{
    public function getArea() : string
    {
        return $this->egrn['KeyParameters']['param:KeyParameter']['@attributes']['Value'] ?? '';
    }

    public function getKeyParameter() : string
    {
        if(isset($this->egrn['KeyParameters']['param:KeyParameter']['@attributes'])) {
            $keyParams = include 'resources/keyParameters.php';
            $type = $keyParams[$this->egrn['KeyParameters']['param:KeyParameter']['@attributes']['Type']] ?? '';
            return $type;
        } else {
            return '';
        }
    }
}