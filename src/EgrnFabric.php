<?php

namespace Deripipka\Egrn;

use Deripipka\Egrn\Realty\Building;
use Deripipka\Egrn\Realty\Construction;
use Deripipka\Egrn\Realty\Flat;
use Deripipka\Egrn\Realty\ObjectRealty;
use Deripipka\Egrn\Realty\Uncompleted;
use Mtownsend\XmlToArray\XmlToArray;
use Deripipka\Egrn\Parcel\Parcel;
use Deripipka\Egrn\Helpers;

class EgrnFabric
{
    public static function create(string $filePath)
    {
        $xmlString = file_get_contents($filePath);
        $egrnArray = XmlToArray::convert($xmlString);
        if(isset($egrnArray['Realty']['Building'])) {
            return new Building(Helpers::addOwnerToArray('Realty', 'Building', $egrnArray));
        } elseif (isset($egrnArray['Realty']['Construction'])) {
            return new Construction(Helpers::addOwnerToArray('Realty', 'Construction', $egrnArray));
        } elseif (isset($egrnArray['Realty']['Flat'])) {
            return new Flat(Helpers::addOwnerToArray('Realty', 'Flat', $egrnArray));
        } elseif (isset($egrnArray['Realty']['Uncompleted'])) {
            return new Uncompleted(Helpers::addOwnerToArray('Realty', 'Uncompleted', $egrnArray));
        } elseif (isset($egrnArray['Parcels']['Parcel'])) {
            $egrnArray['Parcels']['Parcel']['Address'] = $egrnArray['Parcels']['Parcel']['Location']['Address'];
            return new Parcel(Helpers::addOwnerToArray('Parcels', 'Parcel', $egrnArray));
        } elseif (isset($egrnArray['Object'])) {
            return new ObjectRealty(Helpers::addOwnerToArray('Object', null, $egrnArray));
        } elseif (isset($egrnArray['ReestrExtract']['ExtractObjectRight']['ExtractObject']['ObjectDesc'])) {
            $egrnArray['ReestrExtract']['ExtractObjectRight']['ExtractObject']['ObjectDesc']['Owner'] =
                $egrnArray['ReestrExtract']['ExtractObjectRight']['ExtractObject']['Owner'];
            return new ObjectRealty($egrnArray['ReestrExtract']['ExtractObjectRight']['ExtractObject']['ObjectDesc']);
        }
        return false;
    }


}
