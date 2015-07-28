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



$baza->add_primechaniya ($_POST['primechanie_id'], $_POST['id_kvitancy']);
echo $_POST['primechanie_id'] . ' ' . $_POST['id_kvitancy'];
?>