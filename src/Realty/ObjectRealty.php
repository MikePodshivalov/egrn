<?php

namespace Deripipka\Egrn\Realty;

use Deripipka\Egrn\EgrnBase;

class ObjectRealty extends EgrnBase
{
    public function getCadastralNumber() : string
    {
        return $this->egrn['CadastralNumber'] ?? '';
    }

    public function getAddress() : string
    {
        return $this->egrn['Address']['Content'] ?? parent::getAddress();
    }
}
