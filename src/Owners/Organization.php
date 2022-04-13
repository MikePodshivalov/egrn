<?php

namespace Deripipka\Egrn\Owners;

class Organization
{
    public string $name = '';

    public function __construct(public array $owner)
    {
        if(isset($this->owner['Owner']['Organization']['Content'])) {
            $this->name .= $this->owner['Owner']['Organization']['Content'];
        } else {
            $this->name .= $this->owner['Owner']['Organization']['Name'] ?? '';
            $this->name .= ', ' . $this->owner['Owner']['Organization']['INN'] ?? '';
        }
    }
}