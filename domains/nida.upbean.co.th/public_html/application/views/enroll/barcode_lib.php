<?php
$path = 'application/libraries/barcode/src/';

$ignore_arr = array(
    $path.'Types/TypeInterface.php',
    $path.'Types/TypeEanUpcBase.php',
    $path.'Types/TypeInterleaved25Checksum.php',
    $path.'Types/TypeRms4cc.php',
    $path.'Types/TypeMsiChecksum.php',
    $path.'Types/TypePostnet.php',
    $path.'BarcodeGeneratorPNG.php',
    $path.'BarcodeGenerator.php'

);
include($path.'Types/TypeInterface.php');
include($path.'Types/TypeEanUpcBase.php');
include($path.'Types/TypeInterleaved25Checksum.php');
include($path.'Types/TypeRms4cc.php');
include($path.'Types/TypeMsiChecksum.php');
include($path.'Types/TypePostnet.php');
include($path.'BarcodeGenerator.php');
include($path.'BarcodeGeneratorPNG.php');





foreach (glob($path."Types/*.php") as $filename)
{
    if (!in_array($filename,$ignore_arr)){
        include $filename;
    }
}

foreach (glob($path."*.php") as $filename)
{
    if (!in_array($filename,$ignore_arr)){
        include $filename;
    }
}
?>