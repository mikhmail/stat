<?php
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
$filter = Filter::getInstance();
$new = NewKvit::getInstance();
$user_filter = User::getInstance();
$login = Login::getInstance();

// проверка авторизации
$auth = $login->auth();
if ($auth == true and $_SESSION['id_group'] == 1) {

# Открытие сессии.
		session_start();
?>

<html>
<head>
	<title>
		ФИЛЬТР ЗАЯВОК | Редактировать пользователя
	</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link href='http://fonts.googleapis.com/css?family=Istok+Web' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>

</style><script type="text/javascript">
</script>
</head>
<h1>Добавить пользователя</h1>
<table align="center" border="1" width="1024">
<tr>
<td align="right"><? print 'Вы: <b>' . $_SESSION['login']; ?></b> <a href="exit.php">Выход</a> <a href=javascript:window.close()>ЗАКРЫТЬ ОКНО</a></td>
</tr>
</table>

		<form name="save" id="save" action="<?=$_SERVER['PHP_SELF']?>" method="POST">		
<table align="center" border="1" width="1024">

	<tr>
		<td>
		<b>Логин:</b>
		
		<input autocomplete="off" name="login" id="login" value="" type="text" size="10" class="">
		
		<b>Пароль:</b>
		<input autocomplete="off" name="password" value="" type="password" size="10">
		<br>
		<br>
		<b>Фамилия:</b>
		<input autocomplete="off" name="fam" value="" type="text" size="20">

		<b>Имя:</b>
		<input autocomplete="off" name="imya" value="" type="text" size="15">

		<b>Отчество:</b>
		<input autocomplete="off" name="otch" value="" type="text" size="20">

		</td>
	</tr>
	<tr>
		<td>

		<b>Номер телефона:</b>
		<input autocomplete="off" name="phone" value="" type="text" size="50"><br>

		<b>E-mail:</b>
		<input autocomplete="off" name="mail" value="" type="text" size="50"><br>
		
		<b>Адрес:</b>
		<input autocomplete="off" name="adres" value="" type="text" size="65">
		
		</td>
	</tr>

	<tr>
		<td>
		<b>Сервисный Центр:</b>
		
		<select name="id_sc">
		<option value="">--Выбрать сервисный центр--</option>
			<? $sc = $filter->select_all_service_centers (); //var_dump ($user); die();
			foreach ($sc as $a => $rowsc)
			{?>
			<option value="<?=$rowsc['id_sc']?>">[<?=$rowsc['name_sc']?>] <?=$rowsc['adres_sc']?></option>
			<?}?>
			
		</select>
		
		<b>Группа доступа:</b>

		<select name="groups_dostupa">
		<option value="">--Выбрать группу доступа--</option>
			<option value="1">Администраторы</option>
			<option value="2">Менеджеры</option>
			<option value="3">Механики</option>			
		</select>
		
		
		</td>
	</tr>
	
	
	<tr>
		<td>
		<input autocomplete="off" name="save" type="submit" id="add_user_save" value="Добавить">
		</td>
	</tr>
	
	</form>
		</table>		
				
<?

if (isset($_POST['groups_dostupa'])) {


$new_user = $new->add_user(
							  $new->clearData($_POST['id_sc'], $type="i"),
							  $new->clearData($_POST["fam"]),
							  $new->clearData($_POST["imya"]),
							  $new->clearData($_POST["otch"]),
							  $new->clearData($_POST["login"]),
							  $new->clearData($_POST["password"]),
							  $new->clearData($_POST["mail"]),
							  $new->clearData($_POST["phone"]),
							  $new->clearData($_POST["adres"]),
							  $new->clearData($_POST["id_sc"], $type="i"),
							  $new->clearData($_POST["gorod_id"], $type="i"),
							  $new->clearData($_POST["groups_dostupa"], $type="i")
							  );
				
				
				}
				

}
?>