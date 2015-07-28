<?php

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
$filter = Filter::getInstance();
$login = Login::getInstance();

// проверка авторизации
$auth = $login->auth();
if ($auth == true and ($_SESSION['id_group'] == 1 OR $_SESSION['id_group'] == 2)) {

# Открытие сессии.
		session_start();

if (isset($_POST['id_kvitancy'])) {
	
	$edit_kvit = $new->edit_kvitancy(
								$new->clearData($_POST['id_kvitancy'], $type="i"),
								$new->clearData($_POST['id_aparat'], $type="i"),
								$new->clearData($_POST['id_proizvod'], $type="i"),
								$new->clearData($_POST['model']),
								$new->clearData($_POST['ser_nomer']),
								$new->clearData($_POST['id_remonta'], $type="i"),
								$new->clearData($_POST['neispravnost']),
								$new->clearData($_POST['vid']),
								$new->clearData($_POST['komplektnost']),
								$new->clearData($_POST['primechaniya']),
								$new->clearData($_POST['id_mechanic'], $type="i")
											);
	
	$id_kvitancy = $_POST['id_kvitancy'];
	
	header("Location: edit_kvitancy.php?id_kvitancy=$id_kvitancy");exit;
	}else{

if (isset($_GET['id_kvitancy'])) {?>

<html>
<head>
	<title>
		ФИЛЬТР ЗАЯВОК | Редактировать КВАТАНЦИЮ
	</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link href='http://fonts.googleapis.com/css?family=Istok+Web' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>

</head>
<h1>Редактировать квитанцию</h1>
<body>
<form name="main" id="main" action="<?=$_SERVER['PHP_SELF']?>" method="POST">

<div class="table" id="table">

<table align="center" border="1" width="1024">
<tr><td align="right">Вы: <b><?=$_SESSION['login']?></b> <a href="exit.php">Выход</a>      <a href=javascript:window.close()>ЗАКРЫТЬ ОКНО</a></td></tr>

</table>

<?

$query = $filter->main_select(
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					$_GET['id_kvitancy'],
					'',
					'',
					'',
					'',
					''
					);
foreach ($query as $a=>$row) {

//var_dump ($row);
?>

<table align="center" border="1" width="1024">

<tr>
<td><b>Выберите аппарат из списка:</b></td>
<td>
<!--/фильтр аппаратов -->
<select name="id_aparat">
	<option value="">--Название аппарата--</option>
	<?
	$apparati = $filter->select_aparat ();
	foreach ($apparati as $a=>$rowap)
   {?>
	   <option value="<?=$rowap['id_aparat']?>" <?if($rowap['id_aparat'] == $row['id_aparat']) {echo 'selected';}?>><?=$rowap['aparat_name']?></option>
   <?}
	?>
   </select>
<!--/////////фильтр аппаратов кончился -->

<!--/фильтр производителя -->
<select name="id_proizvod">
	<option value="">--Производитель--</option>
	<?
	$apparati = $filter->select_proizvoditel ();
	foreach ($apparati as $a=>$rowap)
   {?>
	   <option value="<?=$rowap['id_proizvod']?>" <?if($rowap['id_proizvod'] == $row['id_proizvod']) echo 'selected';?>><?=$rowap['name_proizvod']?></option>
   <?}
	?>
   </select>
<!--/////////фильтр производителя кончился -->
</td>
</tr>

<tr>
<td><b>Введите модель аппарата:</b></td>
<td><input name="model" type="text" value="<?=$row['model']?>" size="65"></td>
</tr>

<tr>
<td><b>Введите серийный номер аппарата:</b></td>
<td><input name="ser_nomer" type="text" value="<?=$row['ser_nomer']?>" size="65"></td>
</tr>

<tr>
<!--фильтр ремонта -->
<td><b>Выберите вид ремонта:</b></td>
<td>

<select name="id_remonta" id="id_remonta">
	<option value="">--Вид ремонта--</option>
	<?
	$id_remonta = $filter->select_vid_remont ();
	
	foreach ($id_remonta as $a=>$rowidrem)
   {?>
	   <option value="<?=$rowidrem['id_remonta']?>" <?if($rowidrem['id_remonta'] == $row['id_remonta']) echo 'selected';?>><?=$rowidrem['name_remonta']?></option>
   <?}
	?>
   </select>

</td>
<!--/////////фильтр ремонта кончился -->
</tr>

<tr>
<td><b>Заявленная клиентом неисправность:</b></td>
<td>
<textarea rows="2" cols="65" name="neispravnost"><?=$row['neispravnost']?></textarea>
</td>
</tr>

<tr>
<td><b>Опишите внешний вид аппарата, видимые дефекты:</b></td>
<td>
<textarea rows="2" cols="65" name="vid"><?=$row['vid']?></textarea>
</td>
</tr>

<tr>
<td><b>Укажите комплектность:</b></td>
<td>
<textarea rows="1" cols="65" name="komplektnost"><?=$row['komplektnost']?></textarea>
</td>
</tr>

<tr>
<!--/ фильтра механиков -->
<td><b>СЦ, выполняющий ремонт:</b></td>
<td>
<select name="id_mechanic">
	<option value="">--Выбрать приемку--</option>
   <?
	$service = $filter->select_service ();
		foreach ($service as $a=>$rowsc)
   {?>
       <option value="<?=$rowsc['id_mechanic']?>" <?if ($rowsc['id_mechanic'] == $row['id_mechanic']) echo 'selected';?>><?=$rowsc['name_mechanic']?></option>
   <?}
   ?>
</select>
</tr>

<tr>
<!--/////////// фильтра механиков кончился:) -->
<td><b>Есть что добавить? Напишите примечание:</b></td>
<td>
<textarea rows="1" cols="65" name="primechaniya"><?=$row['primechaniya']?></textarea>
</td>
</tr>
<input name="id_kvitancy" type="hidden" value="<?=$_GET['id_kvitancy']?>">
<tr><td><input name="submit" type="submit" value="Сохранить"></td></tr>
</table>
<br>


</form>
<?php
	}
}

}
}
?>