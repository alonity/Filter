<?php

use alonity\filter\Filters;

ini_set('display_errors', true);
error_reporting(E_ALL);

require_once('../vendor/autoload.php');

$filterHost = Filters::server('HTTP_HOST', '[^a-z0-9\.\-]')->get();

$filterArray = Filters::getArray([
    'example' => [
        'regexp' => '[^\d]'
    ],
    'test' => [
        'regexp' => '[^\w]',
        'maxLength' => 10
    ]
]);

$results = $filterArray->get();

?>