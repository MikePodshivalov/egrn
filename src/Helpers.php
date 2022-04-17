<?php

namespace Deripipka\Egrn;

abstract class Helpers
{
    /**
     * Статический метод преобразует массив однотипных данных в строку
     * @param array|string $elem
     * @return string
     */
    static public function arrayToString(array|string $elem) : string
    {
        $res = '';
        if (is_array($elem)) {
            foreach ($elem as $key => $value) {
                if ($value) {
                    $res .= ($key + 1) . '. ' . $value . PHP_EOL;
                }
            }
            return $res;
        } else {
            return $elem;
        }

    }

    /**
     * Статический метод парсит адрес объеекта недвижимости
     * @param array $arr
     * @return string
     */
    static public function parseAddress(array $arr) : string
    {
        if (isset($arr['Address']['adrs:Note'])) {
            return $arr['Address']['adrs:Note'];
        } else {
            $addressString = '';
            if (isset($arr['Address']['adrs:PostalCode'])) {
                $addressString .= $arr['Address']['adrs:PostalCode'] . ', ';
            }
            if (isset($arr['Address']['adrs:Region'])) {
                $regions = include 'resources/regions.php';
                $addressString .= $regions[$arr['Address']['adrs:Region']];
            }
            if (isset($arr['Address']['adrs:City'])) {
                $addressString .= ', ' . $arr['Address']['adrs:City']['@attributes']['Type'] . '. ' .
                    $arr['Address']['adrs:City']['@attributes']['Name'];
            }
            if (isset($arr['Address']['adrs:Street'])) {
                $addressString .= ', ' . $arr['Address']['adrs:Street']['@attributes']['Type'] . '. ' .
                    $arr['Address']['adrs:Street']['@attributes']['Name'];
            }
            if (isset($arr['Address']['adrs:Level1'])) {
                $addressString .= ', ' . $arr['Address']['adrs:Level1']['@attributes']['Type'] . '. ' .
                    $arr['Address']['adrs:Level1']['@attributes']['Value'];
            }
            if (isset($arr['Address']['adrs:Level2'])) {
                $addressString .= ', ' . $arr['Address']['adrs:Level2']['@attributes']['Type'] . '. ' .
                    $arr['Address']['adrs:Level2']['@attributes']['Value'];
            }
            if (isset($arr['Address']['adrs:Level3'])) {
                $addressString .= ', ' . $arr['Address']['adrs:Level3']['@attributes']['Type'] . '. ' .
                    $arr['Address']['adrs:Level3']['@attributes']['Value'];
            }
            if (isset($arr['Address']['adrs:Apartment'])) {
                $addressString .= ', ' . $arr['Address']['adrs:Apartment']['@attributes']['Type'] . '. ' .
                    $arr['Address']['adrs:Apartment']['@attributes']['Value'];
            }
            if (isset($arr['Address']['adrs:Other'])) {
                $addressString .= ', ' . $arr['Address']['adrs:Other'];
            }
            return $addressString;
        }
    }

    /**
     * @param string $key1
     * @param $key2
     * @param array $arr
     * @return array
     */
    static public function addOwnerToArray(string $key1, $key2, array $arr) : array
    {
        if($key2 !== null) {
            $arr[$key1][$key2]['Owner'] = $arr['ReestrExtract']['ExtractObjectRight']['ExtractObject']['ObjectRight'] ?? '';
            return $arr[$key1][$key2];
        } else {
            $arr[$key1]['Owner'] = $arr['ReestrExtract']['ExtractObjectRight']['ExtractObject']['ObjectRight'] ?? '';
            return $arr[$key1];
        }
    }
}