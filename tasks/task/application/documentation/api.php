<?php
require("D:/innowise/tasks/julia.borodich/vendor/autoload.php");

$openapi = \OpenApi\Generator::scan(['D:/innowise/tasks/julia.borodich/tasks/task/application/controllers']);

header('Content-Type: application/json');
echo $openapi->toJson();
