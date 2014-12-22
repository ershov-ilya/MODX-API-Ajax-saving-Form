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

define('MODX_API_MODE', true);
require('../../index.php');


$rand=rand();
echo $rand."\n";
echo hash('sha256', $rand);

$prop=array(
    'sign' => hash('sha256', rand()),
    'updated'=>time(),
    'name' => '',
    'secondname' => '',
    'patronymic'=>'',
    'birth_day' => '8',
    'birth_month' => '1',
    'birth_year' => '1984',
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

print_r($prop);
$dob=date_create($prop['birth_year']."-".$prop['birth_month']."-".$prop['birth_day']);

echo date_format($dob,"d.m.Y");

$object = $modx->newObject('StudentCensus');
//print_r($object);