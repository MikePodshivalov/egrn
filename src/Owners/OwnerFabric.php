<?php

namespace Deripipka\Egrn\Owners;

use Deripipka\Egrn\EgrnBase;

class OwnerFabric
{
    public static function create(array $owner)
    {
        if (isset($owner['Owner']['Person'])) {
            return new Person($owner);
        } elseif (isset($owner['Owner']['Organization'])) {
            return new Organization($owner);
        }
    }
}