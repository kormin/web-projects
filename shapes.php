<?php
/* set out document type to text/javascript instead of text/html */
header("Content-type: text/javascript");

$ini = parse_ini_file("config.ini", true, INI_SCANNER_RAW);
// $iniOpt = 'options';
// var_dump($ini);

echo json_encode($ini);
