<?php

namespace Deripipka\Egrn\Owners;

class Organization
{
    public string $name = '';
    public string $registration = '';


    public function __construct(public array $owner)
    {
        if($this->owner['Owner']['Organization']['Content']) {
            $this->name .= $this->owner['Owner']['Organization']['Content'];
        } else {
            $this->name .= $this->owner['Owner']['Organization']['Name'] ?? '';
            $this->name .= ', ' . $this->owner['Owner']['Organization']['INN'] ?? '';
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