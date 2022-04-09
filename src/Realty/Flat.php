<?php

namespace Deripipka\Egrn\Realty;

class Flat extends EgrnRealty
{
    public function getArea() : string
    {
        return $this->egrn['Area'] ?? '';
    }
}
