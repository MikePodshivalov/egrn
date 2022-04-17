<?php

namespace Deripipka\Egrn\Owners;

use Deripipka\Egrn\EgrnBase;

class OwnerFabric
{
    /**
     * Статический метод - фабрика, создает нужный объект в зависимости от типа собственника: юридическое или
     * физическое лицо
     * @param array $owner
     * @return Organization|Person|void
     */
    public static function create(array $owner)
    {
        if (isset($owner['Owner']['Person'])) {
            return new Person($owner);
        } elseif (isset($owner['Owner']['Organization'])) {
            return new Organization($owner);
        }
    }
}