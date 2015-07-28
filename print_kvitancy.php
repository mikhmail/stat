<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);

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


# Открытие сессии.
		session_start();

// Подключение к БД.
$db = Connect::getInstance();

// Подгружаем классы
$login = Login::getInstance();
$filter = Filter::getInstance();
// конец подгрузок

// проверка авторизации
$auth = $login->auth();
if ($auth == true) {

if ($_SERVER['REQUEST_METHOD'] == "GET") {
	
	if (isset($_GET["id_kvitancy"])) {
	
			$a = $filter->print_kvitancy ($_GET["id_kvitancy"]);
echo $a;
		}
	}
}
?>