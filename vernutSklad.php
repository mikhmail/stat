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


//Подгрузка классов
$sklad = Sklad::getInstance();

//списуем чип.
$spisat = $sklad->vernut ($_POST['nomer_kvitancy'], $_POST['id'], $_POST['user_id']);

// если чип списался, то выводим его в сохранке..
if ($spisat) {
return true;
}
?>