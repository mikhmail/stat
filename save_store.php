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
$sklad = Sklad::getInstance();


if ($_GET['save']) {

//var_dump($_POST['resp_id']);

$store = $sklad->save_store($_GET['id_aparat'], $_GET['id_aparat_p']);
if ($store) echo $store;
}



?>