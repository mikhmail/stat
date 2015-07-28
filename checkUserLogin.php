<?
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//error_reporting(E_ALL);

// Определение путей
set_include_path(get_include_path()
					.PATH_SEPARATOR.'classes');
					
// Автозагрузка классов					
function __autoload($class){
	require_once $class.'.php';
}


// Подключение к БД.
$db = Connect::getInstance();

// Подгружаем классы
$user_filter = User::getInstance();


$check = $user_filter->check_user_login($_POST['login']);
if ($check == true and (!empty($_POST['login']))) { echo 'true';} else echo 'false';

?>