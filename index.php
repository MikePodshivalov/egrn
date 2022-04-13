<?php

use Deripipka\Egrn\EgrnFabric;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__ . '/vendor/autoload.php';

$content = [];
$path = __DIR__ . '/files/';
$files = scandir($path);
foreach($files as $file) {
    if (!is_dir('./files/' . $file)) {
        $egrn[] = $file;
    }
}

foreach ($egrn as $file) {
    $content[$file] = EgrnFabric::create($path . $file);
}
$n = 0;

//echo '<pre>';
//print_r($content['obj_f7d481f9-fab8-4422-b7d0-ecbd415d5105.xml']->egrn);
//echo '</pre>';



foreach ($content as $file => $item) {
//    echo $item->getType() . '*******' . $item->getAssignationName() . '*******' . $file . '<br>';
    echo '<pre>';
    echo $file . '<br>';
//    if (get_class($item) == 'Deripipka\Egrn\Realty\ObjectRealty') {
//        echo '<pre>';
//        print_r($item);
//        echo '</pre>';
//    }
    echo $item->getOwnerRegistration();
    echo '</pre>';
    echo '-------------------------------------------<br>';
    $n++;
}
echo $n;
