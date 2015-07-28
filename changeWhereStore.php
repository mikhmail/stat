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

if (isset($_POST['id_where']) AND isset($_POST['id']))
$sklad->update_where ((int)$_POST['id'], (int)$_POST['id_where'], (int)$_POST['user_id']);

//echo "<p><font size=\"1\">Сохранил..:</font><font size=\"1\" color=\"red\"><b>".$_SESSION['login']."</b></font> <font size=\"1\">".date("j-m-Y, H:i:s")."</font></p>";

?>