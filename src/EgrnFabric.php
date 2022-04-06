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
            return new Building($egrnArray['Realty']['Building']);
        } elseif (isset($egrnArray['Realty']['Construction'])) {
            return new Construction($egrnArray['Realty']['Construction']);
        } elseif (isset($egrnArray['Realty']['Flat'])) {
            return new Flat($egrnArray['Realty']['Flat']);
        } elseif (isset($egrnArray['Realty']['Uncompleted'])) {
            return new Uncompleted($egrnArray['Realty']['Uncompleted']);
        } elseif (isset($egrnArray['Parcels']['Parcel'])) {
            $egrnArray['Parcels']['Parcel']['Address'] = $egrnArray['Parcels']['Parcel']['Location']['Address'];
            return new Parcel($egrnArray['Parcels']['Parcel']);
        } elseif (isset($egrnArray['Object'])) {
            return new ObjectRealty($egrnArray['Object']);
        }
        return false;
    }
}
