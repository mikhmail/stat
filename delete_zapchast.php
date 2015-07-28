<?php

// Установка кодировки
header("Content-type:text/html; charset=utf-8");

// Определение путей
set_include_path(get_include_path()
					.PATH_SEPARATOR.'classes');
					
// Автозагрузка классов					
function __autoload($class){
	require_once $class.'.php';
}


# Открытие сессии.
	session_start();

// Подключение к БД.
$db = Connect::getInstance();

// Авторизация
$login = Login::getInstance();

//Подгрузка классов
$baza = Baza::getInstance();

// НАДО ДАРАБОТАТЬ ЭТИ ИФЫ.........



if (isset($_POST["id_zap"])) {


$delete_zapchast = $baza->delete_zapchast ($_POST["id_zap"]);

}
// если чип списался, то выводим его в сохранке..
if ($delete_zapchast) {echo true;}



?>