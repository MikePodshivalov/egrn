<?php

namespace Deripipka\Egrn;

use Deripipka\Egrn\Owners\Encumbrance;
use Deripipka\Egrn\Owners\OwnerFabric;
use Deripipka\Egrn\Owners\Registration;

abstract class EgrnBase
{
    public array $egrn;

    /**
     * @param array $egrn
     */
    public function __construct(array $egrn)
    {
        $this->egrn = $egrn;
    }

    /**
     * Возвращает тип объекта недвижимости
     * @return string
     */
    public function getType()
    {
        return 'Земельный участок';
    }

    /**
     * @return string
     */
    public function getCadastralNumber() : string
    {
        return $this->egrn['@attributes']['CadastralNumber'] ?? '';
    }

    /**
     * Возвращает дату создания кадастрового номера
     * @return string
     */
    public function getDateCreated() : string
    {
        return $this->egrn['@attributes']['DateCreated'] ?? '';
    }

    /**
     * Возвращает площадь/глубину/высоту/протяженность в количественном выражении
     * @return string
     */
    public function getArea() : string
    {
        if(isset($this->egrn['Area']['Inaccuracy'])) {
            return $this->egrn['Area']['Area'] . '+/-' . $this->egrn['Area']['Inaccuracy'];
        } else {
            return $this->egrn['Area']['Area'] ?? '';
        }
    }

    /**
     * Возвращает наименование: площадь/глубина/высота/протяженность
     * @return string
     */
    public function getKeyParameter()
    {
        return 'Площадь';
    }

    /**
     * @return string
     */
    public function getCadastralCost() : string
    {
        return $this->egrn['CadastralCost']['@attributes']['Value'] ?? '';
    }

    /**
     * @return string|array
     */
    public function getAddress() : string | array
    {
        return Helpers::parseAddress($this->egrn);
    }

    /**
     * Метод возвращает кадастровые номера объектов, расположенных в пределах ЗУ
     * @return string
     */
    public function getInnerCadastralNumbers() : string
    {
        return Helpers::arrayToString($this->egrn['InnerCadastralNumbers']['CadastralNumber'] ?? '');
    }

    /**
     * Метод возвращает категорию земельного участка
     * @return string
     */
    public function getCategory() : string
    {
        if(isset($this->egrn['Category'])) {
            $types = include 'resources/categoryTypes.php';
            return $types[$this->egrn['Category']] ?? '';
        } else {
            return '';
        }
    }

    /**
     * Метод возвращает уникальное наименование объекта недвижимости
     * @return mixed|string
     */
    public function getName()
    {
        if (isset($this->egrn['Name']) && $this->egrn['Name'] === '01') {
            return '';
        }
        return $this->egrn['Name'] ?? '';
    }

    /**
     * Метод возвращает вид разрешенного использования земельного участка
     * @return string
     */
    public function getUtilization() : string
    {
        if(isset($this->egrn['Utilization']['@attributes']['Utilization'])) {
            $types = include 'resources/utilizationTypes.php';
            return $types[$this->egrn['Utilization']['@attributes']['Utilization']] ?? '';
        } else {
            return '';
        }
    }

    /**
     * @return string
     */
    public function getParentCadastralNumbers() : string
    {
        return Helpers::arrayToString($this->egrn['ParentCadastralNumbers']['CadastralNumber'] ?? '');
    }

    /**
     * @return string
     */
    public function getNotes() : string
    {
        return $this->egrn['Notes'] ?? '';
    }

    /**
     * @return string
     */
    public function getAssignationName() : string
    {
        return $this->egrn['AssignationName'] ?? '';
    }

    /**
     * Метод возвращает данные о правообладателе объекта недвижимости
     * @return false|string
     */
    public function getOwnerName()
    {
        if (isset($this->egrn['Owner']['Right'][0])) {
            $owners = [];
            foreach ($this->egrn['Owner']['Right'] as $item) {
                $owner = OwnerFabric::create($item);
                $owners[] = $owner->name ?? '';
            }
            return Helpers::arrayToString($owners);
        }
        if (isset($this->egrn['Owner']['Right']['Owner'])) {
            $owner = OwnerFabric::create($this->egrn['Owner']['Right']);
            return $owner->name;
        }
        return false;
    }

    /**
     * Метод возвращает номер и дату регистрации прав на тобъект недвижимости
     * @return false|mixed|string
     */
    public function getOwnerRegistration()
    {
        if (isset($this->egrn['Owner']['Right'][0])) {
            $owners = [];
            foreach ($this->egrn['Owner']['Right'] as $item) {
                $owner = new Registration($item);
                $owners[] = $owner->registration;
            }
            return Helpers::arrayToString($owners);
        }
        if (isset($this->egrn['Owner']['Right']['Owner'])) {
            $owner = new Registration($this->egrn['Owner']['Right']);
            return $owner->registration;
        }
        return false;
    }

    /**
     * Метод возвращает все обременения в виде строки
     * @return false|string
     */
    public function getOwnerEncumbrance()
    {
        if (isset($this->egrn['Owner']['Right']['Encumbrance'][0])) {
            $owners = [];
            foreach ($this->egrn['Owner']['Right']['Encumbrance'] as $item) {
                $owner = new Encumbrance($item);
                $owners[] = $owner->encumbrance;
            }
            return Helpers::arrayToString($owners);
        }
        if (isset($this->egrn['Owner']['Right']['Encumbrance'])) {
            $owner = new Encumbrance($this->egrn['Owner']['Right']['Encumbrance']);
            return $owner->encumbrance;
        }
        return false;
    }

    /**
     * Метод возвращает все спарсенные свойства объекта недвижимости
     * @return array
     */
    public function getAll() : array
    {
        return [
            'Тип' => $this->getType(),
            'Наименование' => $this->getName(),
            'Кадастровый номер' => $this->getCadastralNumber(),
            'Дата присвоения кадастрового номера' => $this->getDateCreated(),
            'Площадь/протяженность' => $this->getKeyParameter() . ' ' . $this->getArea(),
            'Адрес' => $this->getAddress(),
            'Категория земель' => $this->getCategory(),
            'Вид разрешенного использования' => $this->getUtilization(),
            'Кадастровые номера расположенных в пределах ЗУ' => $this->getInnerCadastralNumbers(),
            'ParentCadastralNumbers' => $this->getParentCadastralNumbers(),
            'Notes' => $this->getNotes(),
            'Кадастровая стоимость' => $this->getCadastralCost(),
            'Назначение' => $this->getAssignationName(),
            'Правообладатель' => $this->getOwnerName(),
            'Вид, номер и дата государственной регистрации права' => $this->getOwnerRegistration(),
            'Ограничение прав и обременение объекта недвижимости' => $this->getOwnerEncumbrance(),
        ];
    }
}