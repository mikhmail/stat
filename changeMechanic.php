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

if ($_POST['meh_id']) {
$baza->update_mehanic($_POST['meh_id'], $_POST['id_kvitancy'], $_SESSION['login']);

//echo $_POST['meh_id'] . ' ' . $_POST['id_kvitancy'] . ' ' . $_SESSION['login'];

echo "<p><font size=\"1\">Обновил: </font><font size=\"1\" color=\"red\"><b>".$_SESSION['login']."</b></font> <font size=\"1\">".date("j-m-Y, H:i:s")."</font></p>";

}

elseif ($_POST['resp_id']) {

//var_dump($_POST['resp_id']);

$update_id_responsible = $baza->update_id_responsible($_POST['resp_id'], $_POST['id_kvitancy'], $_SESSION['login']);
if ($update_id_responsible) echo 1;
}



?>