<?php

namespace Deripipka\Egrn\Owners;

class Registration
{
    public string $registration = '';

    public function __construct(public array $owner)
    {
        if(isset($this->owner['Registration']['Name'])) {
            $this->registration .= $this->owner['Registration']['Name'];
        } elseif (isset($this->owner['Registration']['Type'])) {
            $ownerTypes = include 'resources/ownerTypes.php';
            $this->registration .= $ownerTypes[$this->owner['Registration']['Type']] ?? '';
            $this->registration .= ', №' . $this->owner['Registration']['RegNumber'] ?? '';
            $this->registration .= ' от ' . $this->owner['Registration']['RegDate'] ?? '';
        }
    }
}