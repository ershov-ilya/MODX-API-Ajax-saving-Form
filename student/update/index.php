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

define('MODX_API_MODE', true);
require('../../../../index.php');
$response=array();

/** @var modX $modx */
/** @var modObject $obj */

$prop=array(
    'updated'=>time(),
    'name' => '',
    'secondname' => '',
    'patronymic'=>'',
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
//$modx->log(MODX_LOG_LEVEL_WARN,'DOB: '.$prop['dob']);
if(DEBUG) print_r($prop);

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
    $object = $modx->getObject('StudentProfile', $filter);
    $data = $object->toArray();
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
    $object->set('interests', $prop['interests']);
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

