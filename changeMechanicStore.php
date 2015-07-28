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


if ($_POST['id_resp']) {

//var_dump($_POST['resp_id']);

$update_id_responsible = $sklad->update_id_responsible($_POST['id_resp'], $_POST['id'], $_POST['user_id']);
if ($update_id_responsible) echo 1;
}



?>