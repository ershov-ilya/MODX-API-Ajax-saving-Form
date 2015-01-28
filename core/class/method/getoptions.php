<?php
/**
 * Created by PhpStorm.
 * User: ershov-ilya
 * Website: ershov.pw
 * GitHub : https://github.com/ershov-ilya
 * Date: 25.01.2015
 * Time: 13:59
 */

function getOptions($shortopts="", $longopts  = array("id:","action:")){
    // Скрипт example.php
//    $shortopts  = "";
//    $shortopts .= "a:";  // Обязательное значение
//    $shortopts .= "v::"; // Необязательное значение
//    $shortopts .= "abc"; // Эти параметры не принимают никаких значений

//    $longopts  = array(
//        "id:",     // Обязательное значение
//        "action:"
//        "action::",    // Необязательное значение
//        "option",        // Нет значения
//        "opt",           // Нет значения
//    );
    $options = getopt($shortopts, $longopts);
    return $options;
}