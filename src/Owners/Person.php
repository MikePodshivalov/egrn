<?php

namespace Deripipka\Egrn\Owners;

class Person
{
    public string $name = '';
    public string $registration = '';

    public function __construct(public array $owner)
    {
        if($this->owner['Owner']['Person']['Content']) {
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

        if($this->owner['Registration']['Name']) {
            $this->registration .= $this->owner['Registration']['Name'];
        } else {
            $ownerTypes = include 'resources/ownerTypes.php';
            $this->registration .= $ownerTypes[$this->owner['Registration']['Type']] ?? '';
            $this->registration .= ', №' . $this->owner['Registration']['RegNumber'] ?? '';
            $this->registration .= ' от ' . $this->owner['Registration']['RegDate'] ?? '';
        }
    }
}