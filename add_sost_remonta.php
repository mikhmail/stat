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
$baza = Baza::getInstance();
//$user_filter = User::getInstance();
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
		ФИЛЬТР ЗАЯВОК | Добавить состояние
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
<h1>Добавить состояние аппарата в ремонте</h1>
<table align="center" border="1" width="1024">
<tr>
<td align="right"><? print 'Вы: <b>' . $_SESSION['login']; ?></b> <a href="exit.php">Выход</a> <a href=javascript:window.close()>ЗАКРЫТЬ ОКНО</a></td>
</tr>
</table>

		<form name="save" id="save" action="<?=$_SERVER['PHP_SELF']?>" method="POST">		
<table align="center" border="1" width="1024">

	<tr>
		<td>
		<b>Название:</b>
		
		<input autocomplete="off" name="new_sost" value="" type="text" size="50">

<!--
		<b>Сайт:</b>
		<input autocomplete="off" name="site" value="" type="text" size="10">
		<br>
		<br>
		<b>Название:</b>
		<input autocomplete="off" name="name_sc" value="" type="text" size="20">

		<b>Адрес:</b>
		<input autocomplete="off" name="adres_sc" value="" type="text" size="25">

		<b>Телефоны:</b>
		<input autocomplete="off" name="phone_sc" value="" type="text" size="20">
-->	
		
		
		</td>
	</tr>
	
	
	<tr>
		<td>
		<input autocomplete="off" name="save" type="submit" value="Добавить">
		</td>
	</tr>
	
	<tr>
		<td>
		<b>Что есть, названия статусов в базе и тут отличаются, потому-что изначально все построено на другой базе.</b>
			<ul name="view_sost">		
					<?
				$remont = $filter->select_sost ();
				foreach ($remont as $a=>$rowrem)
			   {?>
				   <li value="<?=$rowrem['id_sost']?>" /><?=$rowrem['name_sost']?></li>
			   <?}
			   ?>
			</ul>
		</td>
	</tr>
	
	</form>
		</table>	
				
<?

if (isset($_POST['new_sost'])) {

//var_dump($_POST['new_sost']);die;

$new_sost = $baza->add_sost_remonta(trim($_POST['new_sost']));
				
		if($new_sost) echo "<script language='JavaScript' type='text/javascript'>alert('".$new_sost."')</script>";
				echo "<script language='JavaScript' type='text/javascript'>window.location.replace('".$_SERVER['PHP_SELF']."')</script>";
				}
				

}
?>