<?php

namespace Deripipka\Egrn\Realty;

use Deripipka\Egrn\EgrnBase;

abstract class EgrnRealty extends EgrnBase
{
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