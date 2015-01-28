<?php
/**
 * Created by PhpStorm.
 * Author: ershov-ilya
 * Website: http://ershov.pw/
 * Date: 28.01.2015
 * Time: 19:26
 */

header('Content-Type: text/plain; charset=utf-8');
error_reporting(E_ALL);
ini_set("display_errors", 1);
define('DEBUG', false);


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// TODO: Метод POST - создать новый аккаунт (область видимости)
// TODO: Метод PUT - внести изменения в существующий аккаунт
// TODO: Метод DELETE - удалить существующий аккаунт

// API includes
require('../../core/config/api.config.php');
require(API_CORE_PATH.'/class/method/method.class.php');


// Method
$method=new Method();

//print_r($_SERVER);

// Gen UTM

$answer= $method->scope;
$utm=generateRandomString(12);
$answer['utm'] = $utm;

$json_answer=json_encode($answer);
print $json_answer;
exit(0);