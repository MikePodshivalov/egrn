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

foreach ($content as $file => $item) {
    echo '<pre>';
    echo $file . '<br>';
    echo $item->getOwnerEncumbrance();
    echo '</pre>';
    echo '-------------------------------------------<br>';
    $n++;
}
echo $n;
