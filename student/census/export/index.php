<?php
/**
 * Created by PhpStorm.
 * Author:   ershov-ilya
 * GitHub:   https://github.com/ershov-ilya/
 * About me: http://about.me/ershov.ilya (EN)
 * Website:  http://ershov.pw/ (RU)
 * Date: 24.02.2015
 * Time: 11:36
 */

define('SCREEN', false);

if(SCREEN) {
    header('Content-Type: text/plain; charset=utf-8');
}
else {
    header('Content-type: text/csv');
    header('Content-disposition: attachment;filename=Выгрузка-базы-студентов.csv');
}
// Access-Control-Allow-Origin: http://api.bob.com
//header('Access-Control-Allow-Origin: *');
//header('Access-Control-Allow-Credentials: true');

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

$fields = array(
    'no'	            => '№ п/п',
    'updated'	        => 'Обновлено',
    'name'	            => 'Имя',
    'patronymic'	    => 'Отчество',
    'secondname'	    => 'Фамилия',
    'dob'	            => 'Дата рождения',
    'gender'	        => 'Пол',
    'studgroup'	        => 'Учебная группа',
    'affiliate'	        => 'Филиал',
    'phone'	            => 'Номер телефона',
    'email'	            => 'email',
    'contact1_name'	    => 'Имя контакта 1',
    'contact1_phone'	=> 'Тел. контакта 1',
    'contact2_name'	    => 'Имя контакта 2',
    'contact2_phone'	=> 'Тел. контакта 2',
    'contact3_name'	    => 'Имя контакта 3',
    'contact3_phone'	=> 'Тел. контакта 3',
    'vk_id'	            => 'ВК',
    'interests'         => 'Интересы',
    'prof_experience'	=> 'Профессиональный опыт',
    'prof_plan'	        => 'Планируемая профессия',
    'prof_orientation'	=> 'Проф. ориентированность',
    'prof_status'	    => 'Статус',
    'prof_income'	    => 'Доход',
    'referer'	        => 'Источник информации'
);

$output=implode(';', $fields);

$i=1;
$docArray = $modx->getCollection('StudentCensus', array());
foreach($docArray as $doc){
    $str='';
    foreach($fields as $field => $val){
        switch($field){
            case 'no':
                $str.= $i;
                break;
            case 'interests':
                $arr=unserialize($doc->get($field));
                $str.= implode(', ', $arr);
                break;
            case 'phone':
            case 'contact1_phone':
            case 'contact2_phone':
            case 'contact3_phone':
                $phonestr=$doc->get($field);
                $res=preg_match('/(\d*)(\d{3})(\d{3})(\d{2})(\d{2})$/', $phonestr, $m);
                if($res){
                    $phonestr="$m[1]($m[2]) $m[3]-$m[4]-$m[5]";
                }
                $str.= $phonestr;
                break;
            case 'updated':
            case 'dob':
                $timestamp=$doc->get($field);
                if($timestamp<1000) $timestr='';
                else $timestr=date('d.m.Y', $doc->get($field));
                $str.= $timestr;
                break;
            default:
                $str.=$doc->get($field);
        }
        $str.=";";
    }
    $str = preg_replace('/;$/','',$str);
    $output.=$str."\n";
    $i++;
} // foreach $docArray

if(SCREEN) {
    print $output;
}
else{
    print iconv("UTF-8", "Windows-1251", $output);
}
