<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//error_reporting(E_ALL);

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

// Подгружаем классы
$login = Login::getInstance();

$baza = Baza::getInstance();

$filter = Filter::getInstance();

$sklad = Sklad::getInstance();

$user_filter = User::getInstance();

$lang = Language::getInstance('english');




		require_once("home2.php"); 







?>