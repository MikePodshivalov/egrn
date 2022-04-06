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
    $content[] = EgrnFabric::create($path . $file);
}

foreach ($content as $item) {
    var_dump($item->getRealtyType());
}

