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
/** @var modObject $obj */
//print $modx->parseChunk('hello_world', array());
$time=time();
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
    'mother_fullname'=>'',
    'mother_phone'=>'',
    'father_fullname'=>'',
    'father_phone'=>'',
    'vkcomID'=>'',
    'interests'=>''
);
$prop=array_merge($prop, $_REQUEST);
$prop['dob']=date_create($prop['birth_year']."-".$prop['birth_month']."-".$prop['birth_day']);
if(DEBUG) print_r($prop);

$object = $modx->newObject('StudentProfile');
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
$object->set('mother_fullname', $prop['mother_fullname']);
$object->set('mother_phone', $prop['mother_phone']);
$object->set('father_fullname', $prop['father_fullname']);
$object->set('father_phone', $prop['father_phone']);
$object->set('vkcomID', $prop['vkcomID']);
$object->set('interests', serialize($prop['interests']));
if($object->save()) $response['status']='OK';
else  $response['status']='failed';

$id=$object->get('id');
$response['id']=$id;
$response['verify']=$prop['sign'];

$json=json_encode($response);
print $json;
