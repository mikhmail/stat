<?php

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
$login = Login::getInstance();
$baza = Baza::getInstance();

$sklad = Sklad::getInstance();
$user_filter = User::getInstance();

// проверка авторизации
$auth = $login->auth();
if ($auth == true AND ($_SESSION['id_group'] == 1 or $_SESSION['id_group'] == 2 or $_SESSION['id_group'] == 3)) {

//$where = $filter->select_where_teh ();
$where = $sklad->select_where ();

$users = $user_filter->select_users (); //var_dump ($user); die();
$proizvoditel = $filter->select_proizvoditel ();
$apparati = $filter->select_aparat ();
$brand = $filter->select_proizvoditel ();

# Открытие сессии.
		session_start();

if(isset($_GET["id"])) {
//if ($_GET) var_dump($_GET);die;

$query = $sklad->main_select(
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								$_GET['id']
								
								
);

//if ($query) var_dump($query[0]);die;

foreach ($query as $key => $row) {
?>

<html>
<head>
	<title>
		СКЛАД
	</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link href='http://fonts.googleapis.com/css?family=Istok+Web' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" type="text/css" />

	
	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>

</head>

<body style="width:1280px;">
<form name="save_store" id="save_store" action="<?=$_SERVER['PHP_SELF']?>" method="POST" autocomplete="off">


<input class="rc-button-red rc-button-submit" type="button" value="Reset" onclick="window.location.replace('<?=$_SERVER['PHP_SELF']?>')">	



<table align="center" border="1" width="768">



<tr>
<td>Выберите аппарат из списка:</td>
<td>

<div id="proizvod_div">
<!-- новый фильттр производ -->
						<div align="left">
                                <span>Поиск бренда<span>
                                <br />
                                <input class="new_kvitancy" type="text" size="30" value="" id="inputProizvod" onkeyup="look_proizvod(this.value);" />
                        </div>
                        <div align="left" class="suggestionsBox" id="proizvod_box" style="display: none;">
                                
                                <div class="suggestionList" id="proizvod_list">
                                         
                                </div>
                        </div>
<!-- новый фильттр производ -->


<!--/фильтр производителя -->
<select name="id_proizvod" id="id_proizvod" readonly>
	<option value="0">--Производитель--</option>
	<?
	
	//var_dump($proizvoditel);die;
	foreach ($proizvoditel as $a=>$rowpr)
   {?>
	   <option value="<?=$rowpr['id_proizvod']?>" <? if($row["id_proizvod"]==$rowpr['id_proizvod']) {echo 'selected';} ?>><?=$rowpr['name_proizvod']?></option>
   <?}
	?>
   </select>
<a href="" class="btn-slide">+ Добавить</a>
<span id="panel">
<input class="new_kvitancy" name="add_proizvod_name" id="add_proizvod_name" type="text">
<input class="new_kvitancy" name="submit" id="add_proizvod" type="button" value="Добавить бренд">
</span>
<!--/////////фильтр производителя кончился -->
</div>
<br><br>
<div id="apparat_div">
<!-- новый фильттр аппараторв -->
						<div align="left">
                                <b>Выбрать аппарат</b>
                                
                                
                        </div>
                        
<!-- новый фильттр аппараторв -->


<!--/фильтр аппаратов -->
<select name="id_aparat" id="id_aparat" required readonly>
	<option value="">--Название аппарата--</option>
	<?
	
	//var_dump($apparati);die;
	foreach ($apparati as $a=>$rowap)
   {?>
	   <option value="<?=$rowap['id_aparat']?>" <? if($row["id_aparat"]==$rowap['id_aparat']) {echo 'selected';} ?>><?=$rowap['aparat_name']?></option>
   <?}
	?>
   </select>
<a href="" class="btn-slide">+ Добавить</a>
<span id="panel">
<input class="new_kvitancy" name="add_aparat_name" id="add_aparat_name" type="text">
<input class="new_kvitancy" name="submit" id="add_aparat" type="button" value="Добавить аппарат">
</span>
<br>
<!--/////////фильтр аппаратов кончился -->
<br>
</div>

</td>
</tr>

<tr>



	<td><b>Раздел:</b></td>
						<td>
							<select name="id_aparat_p" id="id_aparat_p" required readonly> 
								<option value="<?=$row["id_aparat_p"]?>" selected><?=$row["title"]?></option> 
							</select>
							<a href="#" onclick="anichange(this); return false">+ Добавить</a>
<span style="display: none;">
<input class="new_kvitancy" name="add_id_aparat_p" id="add_id_aparat_p" type="text">
<input class="new_kvitancy" name="submit" id="submit_add_id_aparat_p" type="button" value="Добавить">
</span>
						
						</td>
					</tr>

<tr>
<td><b>Модель:</b></td>
<td><input class="new_kvitancy" name="model" type="text" size="65" value="<?=$row["model"]?>" placeholder="Например: me301 k001" autocomplete="off" required></td>
</tr>					

<tr>
<td><b>Выбрать состояние:</b></td>
<td>
<select name="id_sost">
						
						<option value="1" <? if($row["id_sost"]==1) {echo 'selected';} ?>>Новый</option>
						<option value="0" <? if($row["id_sost"]==0) {echo 'selected';} ?>>Б.У.</option>
					</select>

</td>
</tr>
<!--
<tr>
<td>Введите модель аппарата:</td>
<td><input class="new_kvitancy" name="model" type="text" size="65" placeholder="Например: me301 k001" autocomplete="off"></td>
</tr>
-->

<tr>
<td>Введите серийный номер:</td>
<td><input class="new_kvitancy" name="serial" type="text" size="65" placeholder="Ищите номер с пометкой sn или pn" value="<?=$row["serial"]?>" autocomplete="off"></td>
</tr>


<tr>
<td>Опишите внешний вид, видимые дефекты:</td>
<td>
<textarea rows="2" cols="65" name="vid" placeholder="Следы эксплуатации (б.у.): царапины, потертости"><?=$row["vid"]?></textarea>
</td>
</tr>

<tr>
<td><b>Цена</b></td>
						<td><input required maxlength="5" size="5" name="price" type="number" value="<?=$row["price"]?>" placeholder="Число в $" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"></td>
						
					</tr>
					
<tr>
<td><b>Количество</b></td>
						<td><input type="text" name="id_count" value="1" readonly required></td>
						
</tr>					

<tr>
<td><b>Выбрать место склада</b></td>
<td>
<!-- Замена места нахождения-->
<select name="id_where" required>
	<option value="" selected>--выбрать склад--</option>
   <?
   

	foreach ($where as $a=>$rowwhere)
   {?>
       <option value="<?=$rowwhere['id_sc']?>" <? if($row["id_where"]==$rowwhere['id_sc']) {echo 'selected';} ?>><?=$rowwhere['name_mechanic']?></option>
   <?}
   ?>
</select>
<!-- ///////Замена места нахождения-->
</td>
</tr>

<tr>
<td><b>Описание запчасти:</b></td>
<td><input id="new_zapchast" name="name" type="text" size="65" value="<?=$row["name"]?>" placeholder="модель, цвет, размер, тип и тд и тп" autocomplete="off" required/></td>
</tr>

<tr><td>
<input name="id" type="hidden" value="<?=$row["id"]?>">

<input name="save" type="submit" id="" class="rc-button rc-button-submit" value="Сохранить">

</td>
<td></td>
</tr>

</form>


</table>

<?}}

if(isset($_POST["save"])) {

//var_dump($_POST);die;


	$sklad->update_store ( 		$_POST["id"],
								$_POST["name"],
								$_POST["id_aparat"],
								$_POST["id_proizvod"],
								$_POST["serial"],
								$_POST["vid"],
								
								'',
								$_SESSION["user_id"],
								
								
								
								$_POST["id_where"],
								
								$_POST["price"],
								$_POST["id_sost"],
								$_POST["id_aparat_p"],
								$_POST["model"]
								
								
								);
								$self = $_SERVER['PHP_SELF'];
								$id = $_POST["id"];
								
								header("Location: $self?id=$id");exit;
}

}?>