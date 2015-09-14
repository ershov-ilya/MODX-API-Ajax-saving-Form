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
    'code'  => 204
);
$format='json';
if(DEBUG) $format='php';

define('MODX_API_MODE', true);
require('../../../../../index.php');
/** @var modX $modx */
/** @var modObject $obj */

try {
// Include classes
    require_once('../../../core/config/api.private.config.php');
    require_once(API_CORE_PATH . '/class/restful/restful.class.php');
    $rest = new RESTful('update', 'verify,created,updated,name,secondname,patronymic,birth_year,birth_month,birth_day,gender,studgroup,affiliate,phone,email,contact1_name,contact1_phone,contact2_name,contact2_phone,contact3_name,contact3_phone,vk_id,interests,prof_experience,prof_plan,prof_orientation,prof_status,prof_income,referer,source,sourceId,http_referer');

    $hours3 = 60 * 60 * 3;
    $time = time() + $hours3;

    $prop = array(
        'updated' => $time,
    );

    // Преобразование даты рождения
    if(isset($rest->data['birth_year']) || isset($rest->data['birth_month']) || isset($rest->data['birth_day'])) {
        $bd=array(
            'birth_day' => ($rest->data['birth_day'])?($rest->data['birth_day']):'1',
            'birth_month' => ($rest->data['birth_month'])?($rest->data['birth_month']):'1',
            'birth_year' => ($rest->data['birth_year'])?$rest->data['birth_year']:'1970'
        );
        $prop=array_merge($prop, $bd);
        $prop['dob'] = date_timestamp_get(date_create($bd['birth_year'] . "-" . $bd['birth_month'] . "-" . $bd['birth_day']));
    }

    $prop = array_merge($rest->data,$prop);
    unset($prop['birth_year']);
    unset($prop['birth_month']);
    unset($prop['birth_day']);

    //$modx->log(MODX_LOG_LEVEL_WARN,'DOB: '.$prop['dob']);

    $filter = array();
    if (isset($_REQUEST['id'])) {
        $filter['id'] = $_REQUEST['id'];
        $response['status'] = 'OK';
    } else {
        $response['status'] = 'failed';
        throw new Exception('ID is not set',403);
    }

    $object = $modx->getObject('StudentCensus', $filter);
    if (!empty($object)) $data = $object->toArray();
    else {
        $response['status'] = 'failed';
        throw new Exception('No such object',404);
    }

    // Проверка хэша
    // id=18&verify=66e7cb9c266a7e495b89eb36363d44bd8c11c2d51b5fddfc0de780a1358d6685
    if (($data['sign'] == $rest->data['verify'])) {
        $response['status'] = 'OK';
        $response['data'] = $data;
    } else {
        unset($response);
        $response['status'] = 'failed';
        throw new Exception('Wrong verify',403);
   }
    unset($prop['id']);
    unset($prop['verify']);

//    if (DEBUG) {
//        print_r($rest->data);
//        print_r($prop);
//        print_r($data);
//        //throw new Exception('DEBUG stop',200);
//    }

    foreach($prop as $k=>$v){
        switch($k){
            case 'source':
                if(empty($data['source'])){
                    $object->set('source', $prop['source']);
                }else{
                    unset($prop['source']);
                }
                break;
            case 'sourceId':
                if(empty($data['sourceId'])){
                    $object->set('sourceId', $prop['sourceId']);
                }else{
                    unset($prop['sourceId']);
                }
                break;
            case 'interests':
                $object->set('interests', serialize($prop['interests']));
                break;
            case 'updated':
                $object->set('created', $prop['updated']);
                $object->set('updated', $prop['updated']);
                break;
            default:
                $object->set($k, $v);
        }
    }

    if ($object->save()) $response['status'] = 'OK';
    else  {
        $response['status'] = 'failed';
        throw new Exception('Failed to save',500);
    }

    $response = array(
        'status' => 'OK',
        'data' => $prop,
        'message' => 'Saved successfully'
    );

    $response['data']['id'] = $object->get('id');
    $response['data']['source'] = $object->get('source');
}
catch(Exception $e){
    $response['message']=$e->getMessage();
    $response['code']=$e->getCode();
}

require_once(API_CORE_PATH.'/class/format/format.class.php');
print Format::parse($response, $format);
