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

// Include MODX
define('MODX_API_MODE', true);
require_once('../../../../../index.php');
/** @var modX $modx */
/** @var modObject $obj */

try {
// Include classes
    require_once('../../../core/config/api.private.config.php');
    require_once(API_CORE_PATH . '/class/restful/restful.class.php');
    $rest = new RESTful('create', 'create,created,updated,name,secondname,patronymic,dob,gender,studgroup,affiliate,phone,email,contact1_name,contact1_phone,contact2_name,contact2_phone,contact3_name,contact3_phone,vk_id,interests,prof_experience,prof_plan,prof_orientation,prof_status,prof_income,referer,source,sourceId,http_referer');

//print $modx->parseChunk('hello_world', array());
    $hours3 = 60 * 60 * 3;
    $time = time() + $hours3;
    $prop = array(
        'sign' => hash('sha256', rand()),
        'created' => $time,
        'updated' => $time,
        'name' => '',
        'secondname' => '',
        'patronymic' => '',
        'dob' => '0',
        'gender' => '0',
        'studgroup' => '',
        'affiliate' => '',
        'phone' => '',
        'email' => '',
        'contact1_name' => '',
        'contact1_phone' => '',
        'contact2_name' => '',
        'contact2_phone' => '',
        'contact3_name' => '',
        'contact3_phone' => '',
        'vk_id' => '',
        'interests' => '',
        'prof_experience' => '',
        'prof_plan' => '',
        'prof_orientation' => '',
        'prof_status' => '',
        'prof_income' => '',
        'referer' => ''
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
    $prop['modxuserid'] = $modx->user->id;

    $object = $modx->newObject('StudentCensus');
    foreach ($prop as $k => $v) {
        switch ($k) {
            case 'create':
                // Ignore
                break;
            default:
                $object->set($k, $v);
        }
    }

    if (DEBUG) {
        print_r($prop);
        print "Object creation: \n";
        if(gettype($object)=='object'){
            print_r($object->toArray());
        }
//        throw new Exception('DEBUG stop',200);
    }
    $res=$object->save();
    if(DEBUG){
        var_dump($res);
        //throw new Exception('DEBUG stop',200);
    }

    if ($res) $response['status'] = 'OK';
    else  {
        $response['status'] = 'failed';
        throw new Exception('Failed to save',500);
    }


    $id = $object->get('id');

    $response = array(
        'status' => 'OK',
        'verify'=> $prop['sign'],
        'message' => 'Created successfully'
    );

    unset($prop['sign']);
    $response['data']=$prop;
    $response['data']['id'] = $id;
}
catch(Exception $e){
    $response['message']=$e->getMessage();
    $response['code']=$e->getCode();
}

require_once(API_CORE_PATH.'/class/format/format.class.php');
print Format::parse($response, $format);