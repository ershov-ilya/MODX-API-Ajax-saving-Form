<?php
/**
 * Created by PhpStorm.
 * User: IErshov
 * Date: 10.12.2014
 * Time: 15:19
 */

header('Content-Type: text/plain; charset=utf-8');
error_reporting(E_ERROR | E_WARNING);
ini_set("display_errors", 1);

/* Init
-------------------------------------------------*/
if(isset($_GET['debug'])){define('DEBUG',true);}
else{define('DEBUG',false);}
$response=array();

define('MODX_API_MODE', true);
require('../../../index.php');

/** @var modX $modx */
/** @var modObject $obj */
//print $modx->parseChunk('hello_world', array());

$prop=array(
    'updated'=>time(),
    'name' => 'empty name',
    'secondname' => 'empty secondname',
    'patronymic'=>'',
    'dob'=>'',
    'gender'=>'',
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
if(DEBUG) print_r($prop);

$filter=array();
if(isset($_GET['id'])) $filter['id']=$_GET['id'];
else {
    $response['status']='failed';
    $response['message']='ID is not set';
}

if($response['status']!='failed')
{
    $object = $modx->getObject('StudentProfile', $filter);
    $response = $object->toArray();
}

if(DEBUG)
{
    print("\nObject to array.\n");
    print_r($response);
}

$json=json_encode($response);
print $json;

