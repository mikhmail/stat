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

<table id="table">
<tr>
<th><b>Название</b></th>

</tr>

<tr>
<td>
<!--квитанции гарантия!!! -->

<?

$gar = $baza->select_warranty_kvitancys ();

if ($gar != false) {

echo '<b>Гарантийные</b> квитанции:<br>';
	foreach ($gar as $rowgar) {?>
		<a href="index.php?nomer_kvitancy=<?=$rowgar["nomer_kvitancy"]?>"><?=$rowgar["nomer_kvitancy"]?></a>
		<?} }
		
		?>
<!--///////// кончились-->
<br>
<br>


<!--квитанции без комментов-->

<?

$att = $baza->select_k ();

if ($att != false) {

echo '3х-дневные квитанции без комментов:<br>';
	foreach ($att as $rowatt) {?>
		<a href="index.php?nomer_kvitancy=<?=$filter->id2nomer ($rowatt)?>"><?=$filter->id2nomer ($rowatt)?></a>
		<?} }
		
		
//var_dump ($baza->select_kvit_3days());
?>
<!--///////// кончились-->
<br>
<br>

<?

$att2 = $baza->select_kvit_5days ($_SESSION["user_id"]);

if ($att2 != false) {

//var_dump ($att2);die;

echo 'Квитанции в которые на писали ничего 5 дней:<br>';
	foreach ($att2 as $rowatt2) {?>
		<a href="index.php?nomer_kvitancy=<?=$filter->id2nomer ($rowatt2)?>"><?=$filter->id2nomer ($rowatt2)?></a>
		<?} }
?>
<br>
<br>

<!--квитанции на согласование-->

<?
/*

	$sql = mysql_query("SELECT nomer_kvitancy FROM kvitancy
						WHERE
						id_sost = 10
					") or die(mysql_error());
					$n = mysql_num_rows($sql);
							$sog = array();
						
							for($i = 0; $i < $n; $i++)
							{
								$row = mysql_fetch_assoc($sql);		
								$sog[] = $row;
								}
*/								
								$sog = $baza->soglasovat($_SESSION['user_id']);
							
	if (count($sog) >=1) {
echo 'Квитанции на звонок/согласование:<br>';
	foreach ($sog as $rowsog) {?>
		<a href="index.php?nomer_kvitancy=<?=$rowsog['nomer_kvitancy']?>"><?=$rowsog['nomer_kvitancy']?></a>
		<?}
		}
?>
<!--///////// согласование кончились-->


</td>
</tr>

<?}?>