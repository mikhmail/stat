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
if ($auth == true) {

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


</form>
<?
if (isset($_SESSION['user_id'])) {
			$user = $user_filter->select_user ($_SESSION['user_id']);
				foreach ($user as $a => $rowuser) {?>
		<form name="save" action="<?=$_SERVER['PHP_SELF']?>" method="POST">		
<table align="center" border="1" width="1024">

	<tr>
		<td>
		<b>Логин:</b>
		<input autocomplete="off" name="user_id" value="<?=$_SESSION['user_id']?>" type="hidden" size="10">
		
		<input autocomplete="off" name="login" value="<?=$rowuser['login']?>" type="text" size="10" class="inputGrey" disabled>
		
		<b>Пароль:</b>
		<input autocomplete="off" name="password" value="<?=$rowuser['password']?>" type="password" size="10">
		<br>
		<br>
		<b>Фамилия:</b>
		<input autocomplete="off" name="fam" value="<?=$rowuser['fam']?>" type="text" size="20">

		<b>Имя:</b>
		<input autocomplete="off" name="imya" value="<?=$rowuser['imya']?>" type="text" size="15">

		<b>Отчество:</b>
		<input autocomplete="off" name="otch" value="<?=$rowuser['otch']?>" type="text" size="20">

		</td>
	</tr>
	<tr>
		<td>

		<b>Номер телефона:</b>
		<input autocomplete="off" name="phone" value="<?=$rowuser['phone']?>" type="text" size="50"><br>

		<b>E-mail:</b>
		<input autocomplete="off" name="mail" value="<?=$rowuser['mail']?>" type="text" size="50"><br>
		
		<b>Адрес:</b>
		<input autocomplete="off" name="adres" value="<?=$rowuser['adres']?>" type="text" size="65">
		
		</td>
	</tr>

	<tr>
		<td>
		<b>Сервисный Центр:</b>
		
		<select name="id_sc" disabled>
			<? $sc = $filter->select_all_service_centers (); //var_dump ($user); die();
			foreach ($sc as $a => $rowsc)
			{?>
			<option value="<?=$rowsc['id_sc']?>" <?if ($rowsc['id_sc'] == $rowuser['id_sc']) echo 'selected';?>>[<?=$rowsc['name_sc']?>] <?=$rowsc['adres_sc']?></option>
			<?}?>
			
		</select>
		
		<b>Группа доступа:</b>

		<select name="groups_dostupa" disabled>
			<? $groups_dostupa = $user_filter->select_groups_dostupa ();
			foreach ($groups_dostupa as $a => $rowg)
			{?>
			<option value="<?=$rowg['id']?>" <?if ($rowg['id'] == $rowuser['id_group']) echo 'selected';?>><?=$rowg['name']?></option>
			<?}?>
			
		</select>
		<br>
		
		<b>Вид базы:</b>

		<select name="id_portret">
			
			<option value="1" <?if ($rowuser['id_portret'] == 1) echo 'selected';?>>Старая</option>
			<option value="3" <?if ($rowuser['id_portret'] == 3) echo 'selected';?>>Старая v.2</option>
			<option value="2" <?if ($rowuser['id_portret'] == 2) echo 'selected';?>>Новая</option>
			
		</select>
		
		</td>
	</tr>
	
	
	<tr>
		<td>
		<input name="save" type="submit" value="Сохранить">
		
		
		</td>
	</tr>
	
	</form>
				
				<?}
	}
	
if (isset($_POST['save'])) {

//var_dump($_POST);die;

$update = $user_filter->update_settings
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
									$_POST['groups_dostupa'],
									$_POST['id_portret']
									);
									
						
						
						}

						


}
else { 
echo "<script language='JavaScript' type='text/javascript'>window.location.replace('login_form.php')</script>";
}

?>