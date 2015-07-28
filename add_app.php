<?

error_reporting(E_ERROR | E_WARNING | E_PARSE);

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
$new = NewKvit::getInstance();
$login = Login::getInstance();

// проверка авторизации
$auth = $login->auth();
if ($auth == true) {

# Открытие сессии.
session_start();

	if (isset($_POST['aparat_name'])) {
		$check_app = $new->check_app($new->clearData($_POST["aparat_name"]));
				if ($check_app) {
					$add_apparat_id = $new->add_apparat($new->clearData($_POST["aparat_name"]));

					if ($add_apparat_id) echo $add_apparat_id;
								}
				else echo 'Такой аппарат уже есть в базе!';
			
		}	

	if (isset($_POST['name_proizvod'])) {
			$check_app = $new->check_proizvod($new->clearData($_POST["name_proizvod"]));
					if ($check_app) {
						$add_apparat_id = $new->add_proizvod($new->clearData($_POST["name_proizvod"]));

						if ($add_apparat_id) echo $add_apparat_id;
									}
					else echo 'Такой бренд уже есть в базе!';
				
			}		
		
		if (isset($_POST['aparat_p_name'])) {
			$check_app = $new->check_aparat_p($new->clearData($_POST["aparat_p_name"]), $_POST["id_aparat"]);
					if ($check_app) {
						$add_apparat_id = $new->add_aparat_p($new->clearData($_POST["aparat_p_name"]), $_POST["id_aparat"]);

						if ($add_apparat_id) echo $add_apparat_id;
									}
					else echo 'Такая запчасть уже есть в базе!';
				
			}		
}

