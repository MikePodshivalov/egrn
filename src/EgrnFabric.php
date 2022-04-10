<?php

namespace Deripipka\Egrn;

use Deripipka\Egrn\Realty\Building;
use Deripipka\Egrn\Realty\Construction;
use Deripipka\Egrn\Realty\Flat;
use Deripipka\Egrn\Realty\ObjectRealty;
use Deripipka\Egrn\Realty\Uncompleted;
use Mtownsend\XmlToArray\XmlToArray;
use Deripipka\Egrn\Parcel\Parcel;

class EgrnFabric
{
    public static function create(string $filePath)
    {
        $xmlString = file_get_contents($filePath);
        $egrnArray = XmlToArray::convert($xmlString);
        if(isset($egrnArray['Realty']['Building'])) {
            return new Building(self::addOwnerToArray('Realty', 'Building', $egrnArray));
        } elseif (isset($egrnArray['Realty']['Construction'])) {
            return new Construction(self::addOwnerToArray('Realty', 'Construction', $egrnArray));
        } elseif (isset($egrnArray['Realty']['Flat'])) {
            return new Flat(self::addOwnerToArray('Realty', 'Flat', $egrnArray));
        } elseif (isset($egrnArray['Realty']['Uncompleted'])) {
            return new Uncompleted(self::addOwnerToArray('Realty', 'Uncompleted', $egrnArray));
        } elseif (isset($egrnArray['Parcels']['Parcel'])) {
            $egrnArray['Parcels']['Parcel']['Address'] = $egrnArray['Parcels']['Parcel']['Location']['Address'];
            return new Parcel(self::addOwnerToArray('Parcels', 'Parcel', $egrnArray));
        } elseif (isset($egrnArray['Object'])) {
            return new ObjectRealty(self::addOwnerToArray('Object', null, $egrnArray));
        } elseif (isset($egrnArray['ReestrExtract']['ExtractObjectRight']['ExtractObject']['ObjectDesc'])) {
            $egrnArray['ReestrExtract']['ExtractObjectRight']['ExtractObject']['ObjectDesc']['Owner'] =
                $egrnArray['ReestrExtract']['ExtractObjectRight']['ExtractObject']['Owner'];
            return new ObjectRealty($egrnArray['ReestrExtract']['ExtractObjectRight']['ExtractObject']['ObjectDesc']);
        }
        return false;
    }

    private static function addOwnerToArray(string $key1, $key2, array $arr) : array
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
