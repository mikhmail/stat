<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
		ЗАПЧАСТИ
	</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link href='http://fonts.googleapis.com/css?family=Istok+Web' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/functions.js"></script>

</head>
<?php
// Определение путей
set_include_path(get_include_path()
					.PATH_SEPARATOR.'classes');
					
// Автозагрузка классов					
function __autoload($class){
	require_once $class.'.php';
}


# Открытие сессии.
//	session_start();

// Подключение к БД.
$db = Connect::getInstance();

//Подгрузка классов
$baza = Baza::getInstance();
$login = Login::getInstance();
$filter = Filter::getInstance();
// проверка авторизации
$auth = $login->auth();
if ($auth == true) {
?>

<table id="table">

<tr>
<td align="right"><? print 'Вы: <b>' . $_SESSION['login']; ?></b> <a href="exit.php">Выход</a> <a href=javascript:window.close()>ЗАКРЫТЬ ОКНО</a></td>
<tr>
</table>
<br>
<form method="POST">
<table id="table">

<tr>
<td>
Поиск по модели

<input type="text" name="search_text" id="search_text">
<input type="submit" name="search_zap" id="search_zap" value="Искать">

</td>
<tr>

</table>
</form>
<br>

<table id="table">
<tr>
<th><b>Название</b></th>
<th><b>Что делали</b></th>
<th><b>Цена</b></th>
<th><b>Кнопки</b></th>

</tr>

<?
if (isset($_POST["search_text"])) { 
$zap = $baza->show_price($_POST["search_text"]);
//var_dump($zap);
if (count($zap)>0) {
foreach ($zap as $a=>$rowzp) {?>

<tr>
<td><?=$rowzp['name_proizvod']?> <?=$rowzp['model']?></td>
<td><?=$rowzp['name_zap']?></td>
<td><?=$rowzp['cost']?></td>
<td>Управление, пока нет</td>
</tr>

<?}?>

</table>

<?}}}?>