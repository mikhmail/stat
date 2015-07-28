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


// Авторизация

if ($_SERVER['REQUEST_METHOD'] == "GET") {

if (!isset($_COOKIE['id']) or !isset($_COOKIE['hash'])) {
echo "<script language='JavaScript' type='text/javascript'>window.location.replace('login_form.php')</script>";
exit();
	}
}
//---конец авторизации



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



// проверка авторизации
$auth = $login->auth();
if ($auth == true) {

// какую версию морды базы загружать, 1- старая, 2 - новая это ячейка id_portret
$user_id_portret = $user_filter->get_id_portret ($_SESSION['user_id']);


	if ($user_id_portret == 1) {
		require_once("home1.php"); 
	}
	elseif ($user_id_portret == 2) {
		require_once("home2.php"); 
	}
	elseif ($user_id_portret == 3) {
		require_once("home3.php"); 
	}
	
}
else { 
echo "<script language='JavaScript' type='text/javascript'>window.location.replace('login_form.php')</script>";
}






?>