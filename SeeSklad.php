<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
		СКЛАД ЧИПОВ СЦ ТЕХНОДОКТОР
	</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link href='http://fonts.googleapis.com/css?family=Istok+Web' rel='stylesheet' type='text/css'>
	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/functions.js"></script>

<script language="javascript">



function checkedForm(form){
// проверка полей формы
if(sklad.vendor.value==""){
alert('Не выбран раздел!');
sklad.vendor.focus();
return false;
	};
	
if(sklad.name.value==""){
alert('Не заполнено имя!');
sklad.name.focus();
return false;
	};
		
	if(sklad.serial.value==""){
alert('Нет серийника!');
sklad.serial.focus();
return false;
	};
	
	if(sklad.type.value==""){
alert('Не выбран тип!');
sklad.type.focus();
return false;
	};
	
	if(sklad.cost.value==""){
alert('Нет цены!');
sklad.cost.focus();
return false;
	};
	
	
return true;
};


</script>

<?
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
$sklad = Sklad::getInstance();
$login = Login::getInstance();

// проверка авторизации
$auth = $login->auth();
if ($auth == true) {

?>
<table>
<tr>
<td align="right"><? print 'Вы: <b>' . $_SESSION['login']; ?></b> <a href="exit.php">Выход</a> <a href=javascript:window.close()>Закрыть окно</a></td>
<tr>
</table>
<div id="table">
<form name="form2" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
				
				<table border="1">
				<h2>Добавить новый раздел</h2>
				<input type="text" name="razlel" value="Название раздела" onclick="this.value='';" onfocus="this.value='';">
				
				<input type="submit" name="new_razdel" value="Добавить">
				</form>
<form name="sklad" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" onSubmit="return checkedForm(this)">
				</table>
				<table border="1">
				<tr><h2>Добавить товар на склад</h2></tr>
					<tr>
						<td>Название</td>
						<td><input type="text" name="name"></td>
					</tr>
					
						<td>Тип</td>
						<td>
<? 

// фильтр запчастей
$zap_q = mysql_query("SELECT id, zap_name FROM zapchasti");
echo '<select name="vendor">';
echo '<option value=""></option>';
while($rowzap = mysql_fetch_assoc($zap_q))
   {?>
      
	   <option value="<?=$rowzap['id']?>"><?=$rowzap['zap_name']?></option>
   <?}
echo '</select>';
?>
						
						</td>
					</tr>
					<tr>
						<td>Серийный номер</td>
						<td><input type="text" name="serial"></td>
					</tr>
					
					<tr>
						<td>Цена покупки</td>
						<td><input type="text" name="cost"></td>
						
					</tr>
					<tr>
					<td>Состояние</td>
					<td>
						<select name="sost">
						
						<option value="1" selected>Новый</option>
						<option value="0">Б.У.</option>
					</td>				
					</tr>
					
					<td>Примечание</td>
					<td>
						<textarea name="primechanie" cols="40" rows="3"></textarea>
					</td>				
					</tr>
					
				</table>
				<input type="submit" name="new" value="Добавить">
			</form>


<h3>По умолчанию ничего не показуется, чтобы не нагружать базу</h3>
<?//var_dump($_POST);?>
<form name="form3" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
<?

// фильтр ремонта
echo '<select name="type2">';
	echo '<option value="">Выбрать что показывать</option>';
	echo '<option value="0">Показать что на складе</option>';
	echo '<option value="1">Показать что установлено</option>';
echo '</select>';

// фильтр запчастей
$zap_q = mysql_query("SELECT id, zap_name FROM zapchasti");
echo '<select name="vendor">';
echo '<option value="">Выбрать запчасть</option>';
while($rowzap = mysql_fetch_assoc($zap_q))
   {?>
	   <option value="<?=$rowzap['id']?>" <?if($rowzap['id'] == $_POST['vendor']) echo 'selected';?>><?=$rowzap['zap_name']?></option>
   <?}
echo '</select>';

// поиск по базе
echo 'Искать: <input type="text" name="search">';

echo "<input type=submit value='Показать'></td>
		</form>";

?>

<table border="1">
<tr>
		<td ><b>Название</td>
		<td ><b>Тип</td>
		<td ><b>Серийник</td>
		<td ><b>№ Сохранки(списать чип)</td>
		<td ><b>Состояние</td>
		<td ><b>Стоимость</td>
		<td ><b>Примечание</td>
		<td ><b>Действие</td>
	</tr>
<?


if($_POST["type2"]==false) {$where = "WHERE type2='3' ";}

if($_POST["type2"]=='0') {$where = "WHERE type2='0' ";}
elseif($_POST["type2"]=='1') {$where = "WHERE type2='1' ";}

if($_POST["search"]==true) {$where = "WHERE UPPER(name) LIKE '%".strtoupper($_POST['search'])."%' OR UPPER(type) LIKE '%".strtoupper($_POST['search'])."%'";}

if($_POST["vendor"]==true) {$vendor="AND vendor='".$_POST["vendor"]."' ";}


//var_dump($_POST);

// запрос к базе
$com = mysql_query("SELECT * FROM sklad ".$where." ".$vendor." ORDER BY vendor DESC");


list($tot) = mysql_fetch_row(mysql_query('SELECT FOUND_ROWS()'));
echo "Найдено: <b>$tot</b> товаров, ";
			$qsum=mysql_query("SELECT SUM(cost) FROM sklad ".$where." ".$vendor." "); 
				$sum=mysql_result($qsum,0);
				echo 'на сумму: <b>'. $sum . ' $';
			while ( $rowcom = mysql_fetch_array($com)) {?>
		
		<?
		if($rowcom["type"]== true) {$color = 'bgcolor=#2E8B57';}
		elseif($rowcom["sost"]==1) {$color = 'bgcolor=#66CCFF';}
		elseif($rowcom["sost"]==0) {$color = 'bgcolor=#FFFF9F';}
		?> 
	
	<tr>
		<td <?=$color?>><?=$rowcom["name"]?></span></td>
		<td <?=$color?>>
		
		
		<?
		$zap_q = mysql_query("SELECT id, zap_name FROM zapchasti");
		while($rowzap = mysql_fetch_assoc($zap_q))
   {
	  if($rowzap['id'] == $rowcom["vendor"]) echo $rowzap['zap_name'];
   }
   ?>
		
		
		
		</td>
		<td <?=$color?>><?=$rowcom["serial"]?></span></td>
		
		
		
		<?if($rowcom["type"]== true) {?>
		<td <?=$color?>><?=$rowcom["type"]?></td>
		<?}
		else {?>
		<td>
		<form name="form1" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		<input type="text" name="type">
		<input type="hidden" name="id" value="<?=$rowcom['id'] ?>">		
			<input type="submit" name="new" value="Списать">
			</form>			
		</td>
		<?}?>
		<td <?=$color?>><?
		if($rowcom["sost"]==1) {echo 'Новый ';} else {echo 'Б.У. ';}		
		if($rowcom["date"] != '0000-00-00') echo $rowcom["date"];
		?></td>
		
		<td <?=$color?>><?=$rowcom["cost"]?></td>
		
		<td <?=$color?>><?=$rowcom["primechanie"]?></td>
		
		<td>
		<form name="form4" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		
		
		
		<?if($rowcom["type2"]!=1) {echo '<input type="submit" name="delete" value="Удалить с базы">';}  else {echo '<input type="submit" name="sklad" value="Вернуть на склад">';}?>
		
		<?if($rowcom["sost"]==1) {echo '<input type="submit" name="bu" value="Сделать Б.У.">';} else {echo '';}?>
		
		
		<input type="hidden" name="id" value="<?=$rowcom['id'] ?>">
		<input type="hidden" name="name_del" value="<?=$rowcom['name'] ?>">
		<input type="hidden" name="serial_del" value="<?=$rowcom['serial'] ?>">
		
		</form>
		</td>
	</tr>
	
		<? 
	
		}?>
</table>		
<?php
$time=date("Y-m-d");

// удалить со склада
if ($_POST['delete']) {
$rez3 = mysql_query ("DELETE FROM `techn157_glafira`.`sklad` WHERE `sklad`.`id`='".$_POST['id']."' ") or die(mysql_error());
mail('mikh.mail@gmail.com', 'Удалилась записать на складе', "".$userdata['login']." ".$_POST['name_del']." ".$_POST['serial_del']."", 'From:admin@technodoctor.kiev.ua'); 
}

// добавить новый чип
if($_POST['name']) { 
$rez = mysql_query ("INSERT INTO sklad (name, vendor, serial, type, cost, type2, sost, date, primechanie) VALUES ('".$_POST['name']."', '".$_POST['vendor']."', '".$_POST['serial']."', '".$_POST['type']."', '".$_POST['cost']."', '0', '".$_POST['sost']."', '".$time."', '".$_POST['primechanie']."') ") or die(mysql_error());
}

//списать чип, type=номер сохранки, type2=1-то что он списан, sost=0- то что он стал б.у.
$time=date("d-M-Y H:i");
if ($_POST['type']) {
$rez2 = mysql_query ("UPDATE sklad SET type='№" .$_POST['type']." Время: ".$time." by ".$userdata['login']."', type2='1' WHERE id='".$_POST['id']."' ") or die(mysql_error());

}
// сделать чип б.у. sost=0
if ($_POST['bu']) {
$rez4 = mysql_query ("UPDATE sklad SET sost='0' WHERE id='".$_POST['id']."' ") or die(mysql_error());

}

// добавить новый раздел
if ($_POST['razlel']) {
$rez5 = mysql_query ("INSERT INTO `zapchasti` (`zap_name`, `cena_position`) VALUES ('".$_POST['razlel']."', '0.00') ") or die(mysql_error());
}

// вернуть на склад
if ($_POST['sklad']) {
$rez6 = mysql_query ("UPDATE sklad SET sost='0', type='', type2='0' WHERE id='".$_POST['id']."' ") or die(mysql_error());
}




if($rez or $rez2 or $rez3 or $rez4 or $rez5 == true or $rez6 == true) {
echo "<script language='JavaScript' type='text/javascript'>window.location.replace('".$_SERVER['PHP_SELF']."')</script>";
}

}

else { 
echo "<script language='JavaScript' type='text/javascript'>window.location.replace('login_form.php')</script>";
}

?>
		

