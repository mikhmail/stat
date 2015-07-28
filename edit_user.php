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
</head>
<h1>Редактировать пользователя</h1>
<table align="center" border="1" width="1024">
<tr>
<td align="right"><? print 'Вы: <b>' . $_SESSION['login']; ?></b> <a href="exit.php">Выход</a> <a href=javascript:window.close()>ЗАКРЫТЬ ОКНО</a></td>
</tr>
</table>

<table align="center" border="1" width="1024">

<tr>
	<td>
		<b>Поиск пользователя:</b>
		<select name="user">
			<option value="">--Выбрать критерий--</option>
			<option value="1">Фамилия</option>
			<option value="2">Имя</option>			
			<option value="3">логин</option>
			<option value="4">телефон</option>
		</select>
		<input name="search" type="submit" value="Поиск">
	</td>
	<td>
		<form name="user" action="<?=$_SERVER['PHP_SELF']?>" method="GET">
		<b>Выбрать пользователя:</b>
		<select name="user_id">
			<option value="">--Выбрать пользователя--</option>
			<? $user = $user_filter->select_users (); //var_dump ($user); die();
			//print_r ($user);
			foreach ($user as $a => $rowuser)
			{?>
			<option value="<?=$rowuser['user_id']?>" <?if($_GET['user_id'] == $rowuser['user_id']) echo 'selected';?>>*<?=$rowuser['login']?>* | <?=$rowuser['fam']?> <?=$rowuser['imya']?></option>
			<?}?>
			
		</select>
		<input name="pokaz" type="submit" value="Показать">
	</td>	
</tr>
</table>
</form>
<?
if (isset($_GET['pokaz'])) {
			$user = $user_filter->select_user ($_GET['user_id']);
				foreach ($user as $a => $rowuser) {?>
		<form name="save" action="<?=$_SERVER['PHP_SELF']?>" method="POST">		
<table align="center" border="1" width="1024">

	<tr>
		<td>
		<b>Логин:</b>
		<input name="user_id" value="<?=$_GET['user_id']?>" type="hidden" size="10">
		
		<input name="login" value="<?=$rowuser['login']?>" type="text" size="10" class="inputGrey" readonly>
		
		<b>Пароль:</b>
		<input name="password" value="<?=$rowuser['password']?>" type="password" size="10">
		<br>
		<br>
		<b>Фамилия:</b>
		<input name="fam" value="<?=$rowuser['fam']?>" type="text" size="20">

		<b>Имя:</b>
		<input name="imya" value="<?=$rowuser['imya']?>" type="text" size="15">

		<b>Отчество:</b>
		<input name="otch" value="<?=$rowuser['otch']?>" type="text" size="20">

		</td>
	</tr>
	<tr>
		<td>

		<b>Номер телефона:</b>
		<input name="phone" value="<?=$rowuser['phone']?>" type="text" size="50"><br>

		<b>E-mail:</b>
		<input name="mail" value="<?=$rowuser['mail']?>" type="text" size="50"><br>
		
		<b>Адрес:</b>
		<input name="adres" value="<?=$rowuser['adres']?>" type="text" size="65">
		
		</td>
	</tr>

	<tr>
		<td>
		<b>Сервисный Центр:</b>
		
		<select name="id_sc">
			<? $sc = $filter->select_all_service_centers (); //var_dump ($user); die();
			foreach ($sc as $a => $rowsc)
			{?>
			<option value="<?=$rowsc['id_sc']?>" <?if ($rowsc['id_sc'] == $rowuser['id_sc']) echo 'selected';?>>[<?=$rowsc['name_sc']?>] <?=$rowsc['adres_sc']?></option>
			<?}?>
			
		</select>
		
		<b>Группа доступа:</b>

		<select name="groups_dostupa">
			<? $groups_dostupa = $user_filter->select_groups_dostupa ();
			foreach ($groups_dostupa as $a => $rowg)
			{?>
			<option value="<?=$rowg['id']?>" <?if ($rowg['id'] == $rowuser['id_group']) echo 'selected';?>><?=$rowg['name']?></option>
			<?}?>
			
		</select>
		
		
		</td>
	</tr>
	
	
	<tr>
		<td>
		<input name="save" type="submit" value="Сохранить">
		<input name="delete" type="submit" value="Удалить пользователя">
		
		</td>
	</tr>
	
	</form>
				
				<?}
	}
	
if (isset($_POST['save'])) {
$update = $user_filter->update_user
									(
									$_POST['user_id'],
									$_POST['password'],
									$_POST['fam'],
									$_POST['imya'],
									$_POST['otch'],
									$_POST['phone'],
									$_POST['mail'],
									$_POST['adres'],
									$_POST['id_sc'],
									$_POST['groups_dostupa']
									);
									if ($update) echo 'обновил!';
						}

						
						
if (isset($_POST['delete'])) {
$delete = $user_filter->delete_user($_POST['user_id']);
									if ($delete) echo 'удалил!';
				}

} 
?>