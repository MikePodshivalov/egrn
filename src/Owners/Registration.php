<?php

namespace Deripipka\Egrn\Owners;

class Registration
{
    public string $registration = '';
    private string $type = '';
    private string $regNumber = '';
    private string $regDate = '';

    public function __construct(private array $owner)
    {
        if (isset($this->owner['Registration']['Type'])) {
            $ownerTypes = include 'resources/ownerTypes.php';
            $this->type = $ownerTypes[$this->owner['Registration']['Type']] ?? '';
        }

        if (isset($this->owner['Registration']['RegNumber'])) {
            $this->regNumber = $this->owner['Registration']['RegNumber'];
        }

        if (isset($this->owner['Registration']['RegDate'])) {
            $this->regDate = $this->owner['Registration']['RegDate'];
        }

        if(isset($this->owner['Registration']['Name'])) {
            $this->registration = $this->owner['Registration']['Name'];
        } else {
            $this->registration = $this->type . ', №' . $this->regNumber . ' от ' . $this->regDate;
        }
    }
}