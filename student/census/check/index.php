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
if(isset($_GET['t'])){define('DEBUG',true);}
defined('DEBUG') or define('DEBUG',false);

$response=array(
    'status'    => 'OK'
);
$filter=array();
$format='json';
if(isset($_REQUEST['format'])) $format=$_REQUEST['format'];

// Include MODX
/** @var modX $modx */
define('MODX_API_MODE', true);
require_once('../../../../../index.php');

// Include classes
require_once('../../../core/config/api.private.config.php');
require_once(API_CORE_PATH.'/class/restful/restful.class.php');
try {
    $rest = new RESTful('create', 'id,sign,created,updated,name,secondname,patronymic,dob,gender,studgroup,affiliate,phone,email,contact1_name,contact1_phone,contact2_name,contact2_phone,contact3_name,contact3_phone,vk_id,interests,prof_experience,prof_plan,prof_orientation,prof_status,prof_income,referer,source,sourceId');

    // Filter array combining
    if (isset($rest->data['id'])) {
        $filter['id'] = $rest->data['id'];
    }
    if (isset($rest->data['source'])) {
        $filter['source'] = $rest->data['source'];
    }
    if (isset($rest->data['sourceId'])) {
        $filter['sourceId'] = $rest->data['sourceId'];
    }

    if (empty($filter)) {
        throw new Exception('Filter array empty', 403);
    }

    if ($response['status'] != 'failed') {
        $object = $modx->getObject('StudentCensus', $filter);
        $data = $object->toArray();
    }

    if (DEBUG) {
        print_r($data);
    }

    /* Обход проверки
    $response['status']='OK';
    if($data) $response['data']=$data;
    /**/
// Проверка хэша
// id=18&verify=66e7cb9c266a7e495b89eb36363d44bd8c11c2d51b5fddfc0de780a1358d6685
    if ($data['sign'] == $_REQUEST['verify']) {
        $response['status'] = 'OK';
        $response['data'] = $data;
    } else {
        unset($response);
        $response['status'] = 'failed';
        $response['message'] = 'Wrong verify';
    }
}
catch(Exception $e){
    $response['status'] = 'failed';
    $response['message']=$e->getMessage();
    $response['code']=$e->getCode();
}

require_once(API_CORE_PATH.'/class/format/format.class.php');
if(DEBUG) print Format::parse($response, 'php');
else  print Format::parse($response, 'json');