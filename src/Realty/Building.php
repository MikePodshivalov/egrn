<?php

namespace Deripipka\Egrn\Realty;

class Building extends EgrnRealty
{
    public function getArea() : string
    {
        return $this->egrn['Area'] ?? '';
    }
}
