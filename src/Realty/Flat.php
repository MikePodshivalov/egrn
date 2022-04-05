<?php

namespace Deripipka\Egrn\Realty;

use Deripipka\Egrn\EgrnBase;

class Flat extends EgrnBase
{
    public function getArea() : string
    {
        return $this->egrn['Area'] ?? '';
    }
}
