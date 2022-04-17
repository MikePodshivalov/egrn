<?php

namespace Deripipka\Egrn\Owners;

use Deripipka\Egrn\Helpers;

class Encumbrance
{
    public string $encumbrance;
    private string $ownerName = '';
    private string $regNumber = '';
    private string $regDate = '';
    private string $encumType = '';
    private string $started = '';
    private string $stopped = '';
    private string $docs = '';

    public function __construct(private array $owner)
    {
        if(isset($this->owner['Type'])) {
            $encumTypeArray = include 'resources/encumbranceTypes.php';
            $this->encumType = $encumTypeArray[$this->owner['Type']] ?? '';
        }

        if (isset($this->owner)) {
            $owner = OwnerFabric::create($this->owner) ?? '';
            $this->ownerName = $owner->name ?? '';
        }

        $this->regNumber = $this->owner['RegNumber'] ?? '';

        $this->regDate = $this->owner['RegDate'] ?? '';

        if (isset($this->owner['Duration']['Started'])) {
            $this->started = ' с ' . $this->owner['Duration']['Started'];
        }

        if (isset($this->owner['Duration']['Stopped'])) {
            $this->stopped = ' с ' . $this->owner['Duration']['Stopped'];
        }

        if (isset($this->owner['DocFound'][0])) {
            $docs = [];
            foreach ($this->owner['DocFound'] as $item) {
                $docs[] = $item['Content'] ?? '';
            }
            $this->docs = Helpers::arrayToString($docs);
        } elseif (isset($this->owner['DocFound']['Content'])) {
            $this->docs = $this->owner['DocFound']['Content'];
        }

        $this->encumbrance = $this->encumType . ' в пользу: ' . $this->ownerName . ', ' . PHP_EOL .
            $this->started . $this->stopped . ' рег.номер: ' . $this->regNumber . ' от ' . $this->regDate . PHP_EOL .
            'документы: ' . PHP_EOL . $this->docs;
    }
}