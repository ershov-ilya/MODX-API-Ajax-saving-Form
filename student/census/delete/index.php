<?php
/**
 * Created by PhpStorm.
 * Author:   ershov-ilya
 * GitHub:   https://github.com/ershov-ilya/
 * About me: http://about.me/ershov.ilya (EN)
 * Website:  http://ershov.pw/ (RU)
 * Date: 24.02.2015
 * Time: 16:36
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

define('MODX_API_MODE', true);
require('../../../../../index.php');

if(empty($modx->user->id)) die('Доступ запрещён: Авторизуйтесь в админке');

$response=array();

/** @var modX $modx */
/** @var modObject $obj */

//$modx->log(MODX_LOG_LEVEL_WARN,'DOB: '.$prop['dob']);

$filter=array();
if(isset($_REQUEST['id']))
{
    $filter['id']=$_REQUEST['id'];
    $response['status']='OK';
}
else {
    $response['status']='failed';
    $response['message']='ID is not set';
}

if($response['status']=='OK') {
    $object = $modx->getObject('StudentCensus', $filter);
    if (!empty($object)) $data = $object->toArray();
    else {
        $response['status'] = 'failed';
        $response['message'] = 'No such object';
    }

    if ($object->remove() == false) {
        $response['status'] = 'failed';
        $response['message'] = 'The Item failed to remove.';
    } else {
        $response['message'] = 'The Item was removed.';
    }
}

$json=json_encode($response);
print $json;

