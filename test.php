<?php

use wanghanwanghan\someUtils\control;

include './vendor/autoload.php';


$arr = [
    ['id'=>1],
    ['id'=>2],
];

$arr = control::array_flatten($arr);


dd($arr);




