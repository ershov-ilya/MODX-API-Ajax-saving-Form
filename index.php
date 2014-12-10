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

if($_GET['action']=='update'){define('ACTION','update');}
elseif($_GET['action']=='new'){define('ACTION','new');}
elseif($_GET['action']=='check'){define('ACTION','check');}
else{define('ACTION','none');}

define('MODX_API_MODE', true);
require('../../index.php');

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

if(ACTION=='check') {
    $filter=array();
    if(isset($_GET['id'])) $filter['id']=$_GET['id'];
    else {$filter['id']=1;}

    $object = $modx->getObject('StudentProfile', $filter);
    $response=$object->toArray();

    if(DEBUG)
    {
        print("\nObject to array.\n");
        print_r($response);
    }

    $json=json_encode($response);
    print $json;
}

if(ACTION=='new') {
    $object = $modx->newObject('StudentProfile');
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
    $object->save();
    if(DEBUG) print("\nSave done.\n");
    $id=$object->get('id');

    $response=array(
        'id' => $id
    );
    $json=json_encode($response);
    print $json;
}

