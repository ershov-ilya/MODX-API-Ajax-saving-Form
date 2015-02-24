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
$response=array();

/** @var modX $modx */
/** @var modObject $obj */

$id=0;
if(isset($_REQUEST['id'])) $id=$_REQUEST['id'];
if(empty($id)) die('ID is not set');

$hours3=60*60*3;
$time=time()+$hours3;

$prop=array(
    'updated'=>$time,
    'birth_day' => '1',
    'birth_month' => '1',
    'birth_year' => '1970'
);

$prop=array_merge($prop, $_REQUEST);
$prop['dob']=date_timestamp_get(date_create($prop['birth_year']."-".$prop['birth_month']."-".$prop['birth_day']));

//$modx->log(MODX_LOG_LEVEL_WARN,'DOB: '.$prop['dob']);
if(DEBUG)
{
    print_r($prop);
    //exit(0);
}


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

if($response['status']=='OK')
{
    $object = $modx->getObject('StudentCensus', $filter);
    if(!empty($object)) $data = $object->toArray();
    else{
        $response['status']='failed';
        $response['message']='No such object';
    }
}

/* Обход проверки
$response['status']='OK';
$response['data']=$data;
/**/
// Проверка хэша
// id=18&verify=66e7cb9c266a7e495b89eb36363d44bd8c11c2d51b5fddfc0de780a1358d6685
if($response['status']=='OK') {
    if (($data['sign'] == $_REQUEST['verify'])) {
        $response['status'] = 'OK';
        $response['data'] = $data;
    } else {
        unset($response);
        $response['status'] = 'failed';
        $response['message'] = 'Wrong verify';
    }
}
/**/

if($response['status']!='failed') {
    $object->set('updated', $prop['updated']);
    if(isset($prop['name']))            $object->set('name', $prop['name']);
    if(isset($prop['secondname']))      $object->set('secondname', $prop['secondname']);
    if(isset($prop['patronymic']))      $object->set('patronymic', $prop['patronymic']);
    if(isset($prop['dob']))             $object->set('dob', $prop['dob']);
    if(isset($prop['gender']))          $object->set('gender', $prop['gender']);
    if(isset($prop['studgroup']))       $object->set('studgroup', $prop['studgroup']);
    if(isset($prop['affiliate']))       $object->set('affiliate', $prop['affiliate']);
    if(isset($prop['phone']))           $object->set('phone', $prop['phone']);
    if(isset($prop['email']))           $object->set('email', $prop['email']);
    if(isset($prop['contact1_name']))   $object->set('contact1_name', $prop['contact1_name']);
    if(isset($prop['contact1_phone']))  $object->set('contact1_phone', $prop['contact1_phone']);
    if(isset($prop['contact2_name']))   $object->set('contact2_name', $prop['contact2_name']);
    if(isset($prop['contact2_phone']))  $object->set('contact2_phone', $prop['contact2_phone']);
    if(isset($prop['contact3_name']))   $object->set('contact3_name', $prop['contact3_name']);
    if(isset($prop['contact3_phone']))  $object->set('contact3_phone', $prop['contact3_phone']);
    if(isset($prop['vk_id']))           $object->set('vk_id', $prop['vk_id']);
    if(isset($prop['interests']))       $object->set('interests', serialize($prop['interests']));
    if(isset($prop['prof_experience'])) $object->set('prof_experience', $prop['prof_experience']);
    if(isset($prop['prof_plan']))       $object->set('prof_plan', $prop['prof_plan']);
    if(isset($prop['prof_orientation']))$object->set('prof_orientation', $prop['prof_orientation']);
    if(isset($prop['prof_status']))     $object->set('prof_status', $prop['prof_status']);
    if(isset($prop['prof_income']))     $object->set('prof_income', $prop['prof_income']);
    if(isset($prop['referer']))         $object->set('referer', $prop['referer']);

    if ($object->save()) $response['status'] = 'OK';
    else  $response['status'] = 'failed';

    $id = $object->get('id');

    $response = array(
        'status' => 'OK',
        'data' => $data
    );

    $response['data']['id'] = $id;
}

$json=json_encode($response);
print $json;

