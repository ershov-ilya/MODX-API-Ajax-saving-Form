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
require('../../../../../index.php');

/** @var modX $modx */
/** @var modObject $obj */
//print $modx->parseChunk('hello_world', array());
$hours3=60*60*3;
$time=time()+$hours3;
$prop=array(
    'sign' => hash('sha256', rand()),
    'created'=>$time,
    'updated'=>$time,
    'name' => '',
    'secondname' => '',
    'patronymic'=>'',
    'birth_day' => '1',
    'birth_month' => '1',
    'birth_year' => '1970',
    'dob'=>'0',
    'gender'=>'0',
    'studgroup'=>'',
    'affiliate'=>'',
    'phone'=>'',
    'email'=>'',
    'contact1_name'=>'',
    'contact1_phone'=>'',
    'contact2_name'=>'',
    'contact2_phone'=>'',
    'contact3_name'=>'',
    'contact3_phone'=>'',
    'vk_id'=>'',
    'interests'=>'',
    'prof_experience'=>'',
    'prof_plan'=>'',
    'prof_orientation'=>'',
    'prof_status'=>'',
    'prof_income'=>'',
    'referer'=>''
);
$prop=array_merge($prop, $_REQUEST);
$prop['dob']=date_create($prop['birth_year']."-".$prop['birth_month']."-".$prop['birth_day']);
if(DEBUG) print_r($prop);

$object = $modx->newObject('StudentCensus');
$object->set('sign', $prop['sign']);
$object->set('created', $prop['updated']);
$object->set('updated', $prop['updated']);
$object->set('name', $prop['name']);
$object->set('secondname', $prop['secondname']);
$object->set('patronymic', $prop['patronymic']);
$object->set('dob', $prop['dob']);
$object->set('gender', $prop['gender']);
$object->set('studgroup', $prop['studgroup']);
$object->set('affiliate', $prop['affiliate']);
$object->set('phone', $prop['phone']);
$object->set('email', $prop['email']);
$object->set('contact1_name', $prop['contact1_name']);
$object->set('contact1_phone', $prop['contact1_phone']);
$object->set('contact2_name', $prop['contact2_name']);
$object->set('contact2_phone', $prop['contact2_phone']);
$object->set('contact3_name', $prop['contact3_name']);
$object->set('contact3_phone', $prop['contact3_phone']);
$object->set('vk_id', $prop['vk_id']);
$object->set('interests', serialize($prop['interests']));
$object->set('prof_experience', $prop['prof_experience']);
$object->set('prof_plan', $prop['prof_plan']);
$object->set('prof_orientation', $prop['prof_orientation']);
$object->set('prof_status', $prop['prof_status']);
$object->set('prof_income', $prop['prof_income']);
$object->set('referer', $prop['referer']);
if($object->save()) $response['status']='OK';
else  $response['status']='failed';

$id=$object->get('id');
$response['id']=$id;
$response['verify']=$prop['sign'];

$json=json_encode($response);
print $json;
