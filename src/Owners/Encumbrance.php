<?php

namespace Deripipka\Egrn\Owners;

class Encumbrance
{
    public string $encumbrance = '';

    public function __construct(public array $owner)
    {
        if(isset($this->owner['Type'])) {
            $encumType = include 'resources/encumbranceTypes.php';
            $this->encumbrance .= $encumType[$this->owner['Type']] . ',' . PHP_EOL;
            $this->encumbrance .= 'c ' . $this->owner['Duration']['Started'] ?? '';
            $this->encumbrance .= 'по ' . $this->owner['Duration']['Stopped'] ?? '';
        }
//        elseif (isset($this->owner['Registration']['Type'])) {
//            $ownerTypes = include 'resources/ownerTypes.php';
//            $this->registration .= $ownerTypes[$this->owner['Registration']['Type']] ?? '';
//            $this->registration .= ', №' . $this->owner['Registration']['RegNumber'] ?? '';
//            $this->registration .= ' от ' . $this->owner['Registration']['RegDate'] ?? '';
//        }
    }
}

//[Encumbrance] => Array
//              (
//              [ID_Record] => 429023794754
//             [RegNumber] => 54:35:101445:22-54/001/2017-4
//             [Type] => 022007000000
//             [Name] => в силу договора
//              [ShareText] => Доля 15120/100000 в праве общей долевой собственности на Кадастровый(условный) номер: 54:35:101445:22.
//                  Земельный участок. . Категория земель: земли населенных пунктов - общественные здания административного назначения. Площадь: 1000 кв.м. Адрес(местоположение): Новосибирская обл., г. Новосибирск, ул. Серебренниковская, на земельном участке расположено административное здание, адрес: Новосибирская область, г. Новосибирск, ул. Серебренниковская, 31
//              [RegDate] => 01.09.2017
//              [Duration] => Array
//                  (
//                      [Started] => 29.08.2017
//                      [Stopped] => 26.08.2022
//                                                )
//
//              [Owner] => Array
//                  (
//                    [ID_Subject] => 39221217654
//                    [Organization] => Array
//                          (
//                                  [Code_SP] => 007002000000
//                                  [Content] => Акционерное общество "Банк Финсервис", ИНН: 7750004270
//                                  [Name] => Акционерное общество "Банк Финсервис"
//                                  [INN] => 7750004270
//                                                        )
//
//                                                )
//
//               [DocFound] => Array
//              (
//                      [0] => Array
//                      (
//                              [ID_Document] => 424600598154
//                              [Content] => Дополнительное соглашение к Договору об ипотеке № 06/476/17 от 29.08.2017 №1 от 29.08.2017 г. Номер в реестре нотариуса: 1-2179. Дата в реестре нотариуса: 29.08.2017 г.
//                              [Type_Document] => 010003000000
//                              [Name] => Дополнительное соглашение к Договору об ипотеке № 06/476/17 от 29.08.2017
//                              [Number] => 1
//                              [Date] => 29.08.2017
//                       )
//
//                       [1] => Array
//                       (
//                              [ID_Document] => 424600598354
//                              [Content] => Договор об ипотеке №06/476/17 от 29.08.2017 г. Номер в реестре нотариуса: 1-2178. Дата в реестре нотариуса: 29.08.2017 г.
//                              [Type_Document] => 010003006000
//                              [Name] => Договор об ипотеке
//                              [Number] => 06/476/17
//                              [Date] => 29.08.2017
//                        )
//
//                                                )
//
//                                        )