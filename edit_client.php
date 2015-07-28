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
		
if (isset($_POST['save'])) {

$user_id = $_POST['user_id'];
$update = $user_filter->update_client ($_POST['user_id'], $_POST['fam'], $_POST['imya'], $_POST['otch'], $_POST['phone'], $_POST['mail'], $_POST['adres'] );
																
	header("Location: edit_client.php?user_id=$user_id");exit;					
	}		
?>

<html>
<head>
	<title>
		ФИЛЬТР ЗАЯВОК | Редактировать пользователя - клиента
	</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link href='http://fonts.googleapis.com/css?family=Istok+Web' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
</head>
<h1>Редактировать пользователя - клиента</h1>

<table align="center" border="1" width="1024">
<tr>
<td align="right"><? print 'Вы: <b>' . $_SESSION['login']; ?></b> <a href="exit.php">Выход</a> <a href=javascript:window.close()>ЗАКРЫТЬ ОКНО</a></td>
</tr>
</table>



<?
if (isset($_GET['user_id'])) {
			$user = $user_filter->select_user ($_GET['user_id']);
				foreach ($user as $a => $rowuser) {?>
		<form name="save" action="<?=$_SERVER['PHP_SELF']?>" method="POST">		
<table align="center" border="1" width="1024">

	<tr>
		<td>
		
		<input name="user_id" value="<?=$_GET['user_id']?>" type="hidden" size="10">
		
		<input name="login" value="<?=$rowuser['login']?>" type="hidden" size="10" class="inputGrey" readonly>
		
		
		<input name="password" value="<?=$rowuser['password']?>" type="hidden" size="10">
		<br>
		<br>
		<b>Фамилия:</b>
		<input name="fam" value="<?=$rowuser['fam']?>" type="text" size="25">

		<b>Имя:</b>
		<input name="imya" value="<?=$rowuser['imya']?>" type="text" size="25">

		<b>Отчество:</b>
		<input name="otch" value="<?=$rowuser['otch']?>" type="text" size="30">

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
		<input name="save" type="submit" value="Сохранить">
		
		
		</td>
	</tr>
	
	</form>
				
				<?}
	}
	

}
?>