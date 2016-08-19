<?php
/**
 * @Description: Создано в России 
 * @User: aleksey.nikulin
 * @Date: 27.06.2016
 * @Time: 19:16
 * @Email: masterweb@e1.ru
 */

include_once(dirname(__FILE__)."/configure.php");
include_once(BOXBERRY_DIR."/boxberry.php");

$boxberry = new \boxberryApi\boxberry();
$boxberry->type = "json";
$boxberry->args = [
    'methodQuery' => 'post',
    'token'=>'*******',
    'method'=>'ListPoints',
];
print_r($boxberry->getData());
