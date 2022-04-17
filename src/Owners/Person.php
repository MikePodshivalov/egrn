<?php

namespace Deripipka\Egrn\Owners;

class Person
{
    public string $name = '';

    public function __construct(private array $owner)
    {
        if(isset($this->owner['Owner']['Person']['Content'])) {
                $this->name .= $this->owner['Owner']['Person']['Content'];
        } else {
            if (isset($this->owner['Owner']['Person']['FIO']['FamilyName'])) {
                $this->name .= $this->owner['Owner']['Person']['FIO']['FamilyName'] ?? '';
                $this->name .= ' ' . $this->owner['Owner']['Person']['FIO']['FirstName'] ?? '';
            }
            $this->name .= $this->owner['Owner']['Person']['FIO']['Surname'] ?? '';
            $this->name .= ' ' . $this->owner['Owner']['Person']['FIO']['First'] ?? '';
            $this->name .= ' ' . $this->owner['Owner']['Person']['FIO']['Patronymic'] ?? '';
        }
    }
}