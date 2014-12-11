<?php
/**
 * Created by PhpStorm.
 * User: IErshov
 * Date: 10.12.2014
 * Time: 15:19
 */

header('Content-Type: text/plain; charset=utf-8');
// TODO: set specific Access-Control-Allow-Origin host
// Access-Control-Allow-Origin: http://api.bob.com
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');

error_reporting(E_ERROR | E_WARNING);
ini_set("display_errors", 1);

/* Init
-------------------------------------------------*/
if(isset($_GET['debug'])){define('DEBUG',true);}
else{define('DEBUG',false);}
$response=array();

define('MODX_API_MODE', true);
require('../../../../index.php');

/** @var modX $modx */

$filter=array();
if(isset($_REQUEST['id']))
{
    $filter['id'] = $_REQUEST['id'];
}
else {
    $response['status']='failed';
    $response['message']='ID is not set';
}

if($response['status']!='failed')
{
    $object = $modx->getObject('StudentProfile', $filter);
    $data = $object->toArray();
}

if(DEBUG)
{
    print_r($data);
}

// Обход проверки
$response['status']='OK';
if($data) $response['data']=$data;
/**/
/* Проверка хэша
// id=18&verify=66e7cb9c266a7e495b89eb36363d44bd8c11c2d51b5fddfc0de780a1358d6685
if($data['sign'] == $_GET['verify'])
{
    $response['status']='OK';
    $response['data']=$data;
}
else {
    unset($response);
    $response['status']='failed';
    $response['message']='Wrong verify';
}
/**/
$json=json_encode($response);
print $json;

