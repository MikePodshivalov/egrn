<?php

namespace Deripipka\Egrn;

use Deripipka\Egrn\Realty\Building;
use Deripipka\Egrn\Realty\Construction;
use Deripipka\Egrn\Realty\Flat;
use Deripipka\Egrn\Realty\ObjectRealty;
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
        } elseif (isset($egrnArray['Parcels']['Parcel'])) {
            $egrnArray['Parcels']['Parcel']['Address'] = $egrnArray['Parcels']['Parcel']['Location']['Address'];
            return new Parcel($egrnArray['Parcels']['Parcel']);
        } elseif (isset($egrnArray['Object'])) {
            return new ObjectRealty($egrnArray['Object']);
        }
        return false;
    }

//    private static function addAddress(\SimpleXMLElement $simpleXMLElement)
//    {
//        foreach($simpleXMLElement->getDocNamespaces() as $strPrefix => $strNamespace) {
//            if(strlen($strPrefix)==0) {
//                $strPrefix="a";
//            }
//            $simpleXMLElement->registerXPathNamespace($strPrefix,$strNamespace);
//        }
//        $addressXML = $simpleXMLElement->xpath('//a:Address')[0]->asXML();
//        $addressXML = str_replace('adrs:', '', $addressXML);
//        $address = simplexml_load_string($addressXML);
//        return $address;
//    }

//    private static function xml2array(\SimpleXMLElement $simpleXMLElement) : array
//    {
//        $json = json_encode($simpleXMLElement, JSON_THROW_ON_ERROR);
//        $egrnArray = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
//        return $egrnArray;
//    }
}
