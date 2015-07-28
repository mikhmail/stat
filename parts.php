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
<script type="text/javascript" src="js/jquery.validate.min.js"></script>


</head>
<?php

//error_reporting(E_ALL);


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
$user_filter = User::getInstance();
// проверка авторизации
$auth = $login->auth();
if ($auth == true) {
?>



<table width="100%">

<tr>
<td align="right"><? print 'Вы: <b>' . $_SESSION['login']; ?></b> <a href="exit.php">Выход</a> <a href=javascript:window.close()>Закрыть окно</a></td>
<tr>
</table>

<a href="#" onclick="anichange(this); return false">+ Заказать новую запчасть</a>

<div class="cat" style="display:none; margin-bottom:50px;">



<table align="center" border="1" width="500">



<tr>
<td><b>№ квитанции</b></td>
<td><input id="nomer_kvit" type="text" size="15" value="<?if(isset($_GET["nomer_kvitancy"])) echo $_GET["nomer_kvitancy"]; ?>" placeholder="Номер квитанции" autocomplete="off"></td>
</tr>

<tr>
<td><b>Выберите аппарат</b></td>
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
<select name="id_proizvod" id="id_proizvod">
	<option value="0">--Производитель--</option>
	<?
	$proizvoditel = $filter->select_proizvoditel ();
	//var_dump($proizvoditel);die;
	foreach ($proizvoditel as $a=>$rowpr)
   {?>
	   <option value="<?=$rowpr['id_proizvod']?>" <?if ($_GET["id_proizvod"] == $rowpr['id_proizvod']) echo 'selected'; ?>><?=$rowpr['name_proizvod']?></option>
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




<!--/фильтр аппаратов -->
<select name="id_aparat" id="id_aparat" required>
	<option value="">--Название аппарата--</option>
	<?
	$apparati = $filter->select_aparat ();
	//var_dump($apparati);die;
	foreach ($apparati as $a=>$rowap)
   {?>
	   <option value="<?=$rowap['id_aparat']?>" <?if ($_GET["id_aparat"] == $rowap['id_aparat']) echo 'selected'; ?>><?=$rowap['aparat_name']?></option>
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
<? if (!empty($_GET["id_aparat"])) {?>
<script>
$(document).ready(function(){
  $("#id_aparat").click(function(){
  
		$("#id_aparat_p").load("ajaxApparat_p.php", { id_aparat: $("#id_aparat option:selected").val() });
	});
});
</script>
<?}?>   
							<select name="id_aparat_p" id="id_aparat_p" required> 
								<option value=""></option> 
							</select>
							<a href="#" onclick="anichange(this); return false">+ Добавить</a>
<span style="display: none;">
<input class="new_kvitancy" name="add_id_aparat_p" id="add_id_aparat_p" type="text">
<input class="new_kvitancy" name="submit" id="submit_add_id_aparat_p" type="button" value="Добавить">
</span>
			

</td>
</tr>				


<tr>
<td><b>Модель аппарата:</b></td>
<td><input id="model" type="text" size="65" placeholder="модель, например me302 k001" autocomplete="off" required></td>
</tr>

<tr>
<td><b>Описание запчасти:</b></td>
<td><input id="name_zap" type="text" size="65" placeholder="тип, цвет, размер и тд и тп" autocomplete="off" required></td>
</tr>

<tr>
<td><b>Кол-во:</b></td>
<td>
<input id="kolvo" type="text" maxlength="2" size="2" placeholder="" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" required>
</td>
</tr>

<tr>
<td colspan="2">
<input align="center" class="blue-btn" type="button" name="zakazat" id="zakazat" value="Заказать" onclick="AddZapchast2('<?=$row['nomer_kvitancy']?>', '<?=$_SESSION['user_id']?>', '<?=$_SESSION['id_sc']?>')"></input>
</td>

</tr>

</form>


</table>
</div>



<form name="MAIN" action="<?=$_SERVER['PHP_SELF']?>" method="GET">
<table width="100%">
<tr>
<td>


<select name="id_aparat" id="zap_id_aparat">
	<option value="">--аппарат--</option>
	<?

	//var_dump($apparati);die;
	foreach ($apparati as $a=>$rowap)
   {?>
	   <option value="<?=$rowap['id_aparat']?>" <?if($rowap['id_aparat'] == $_GET['id_aparat']) echo 'selected';?>><?=$rowap['aparat_name']?></option>
   <?}
	?>
</select>
<select name="id_aparat_p" id="zap_id_aparat_p"> 
	<option value=""></option> 
</select>

<!-- выбор ответственного -->
<select name="id_zakazchik" id="id_zakazchik">
			<option value="">-ответственный-</option>
			<? $user = $user_filter->select_users (); //var_dump ($user); die();
			//print_r ($user);
			foreach ($user as $a => $rowuser)
			{?>
			<option value="<?=$rowuser['user_id']?>" <?if($rowuser['user_id'] == $_GET['id_zakazchik']) echo 'selected';?>><?=$rowuser['login']?> | <?=$rowuser['fam']?> <?=$rowuser['imya']?></option>
			
			<?}?>
			
</select>
<!-- выбор ответственного-->

<input id="signIn" name="signIn" class="rc-button rc-button-submit" type="submit" value="Показать">

<input class="rc-button-red rc-button-submit" type="button" value="Сброс" onClick="window.location.replace('<?=$_SERVER['PHP_SELF']?>')">

</td>

</tr>
</form>
</table>
<?
$zap = $baza->show_zapchasti_new($_GET['id_zakazchik'], $_GET['id_aparat'], $_GET['id_aparat_p'], $_GET['id_proizvod']); // показать Все запчасти WHERE status=1 - актуальные
//var_dump($zap);die;
if (count($zap)>0) {
?><h3 style="color: #3079ed;">Нужно заказать запчастей: <?=count($zap)?></h3><?

/* Сортировка масива по аппаратам id_apatat*/	
$row_global = array ();
	foreach ($zap as $a=>$row) { //arr63
				$row_global[$row["aparat_name"]][] = $row;
		}
/* Сортировка масива по аппаратам */

//var_dump($row_global);die;

if (count($row_global)>=1) {
foreach ($row_global as $aparat_name => $value) {
						$aparat = $value;


/* Сортировка масива по запчастям id_apatat_p */	
$row_zap = array ();

	foreach ($value as $a=>$row45) { //arr45

			$row_zap[$row45["title"]][] = $row45;

	}
/* Сортировка масива по запчастям id_apatat_p */

//var_dump($row_zap);die;
?>


<div style="width:100%; text-align: left; float: left; margin-left: 10px;">	
	<a href="#" onclick="anichange(this); return false"><h3><span>+</span><?=$aparat_name?><font color="red"><sup><?=count($value)?></sup></font></h3></a>
										
			<div class="cat" style="display:none;">
				<? foreach ($row_zap as $title => $value2) { ?>
					<ul>
						<li style="list-style-type: none;">
					<a href="#" onclick="anichange(this); return false"><span>+</span><b><?=$title?></b><font color="red"><sup><?=count($value2)?></sup></font></a>
						<div class="cat" style="display:none;">
									<table style="width:90%;">
									<tr>
										<th>#квит</th>
										
										<th>Аппарат</th>
										
										<th>Название</th>
										<th>Описание</th>
										<th>Кол-во</th>
										
										<th>Дата заказа</th>
										
										
										<th>Кто ответственный</th>
										
									
										<th>Статус</th>
										<th>Склад</th>
										<th>Опции</th>
										
										
									</tr>
						
						<? foreach ($value2 as $key => $rowzp) {?>
<?
settype($rowzp['kuda'], "integer"); 
	$id_sost = $baza->nomer_kvit2id_sost($rowzp['kuda']); //глюки тут
		$span = $baza->get_color ($id_sost);
?>

							
							<tr id="<?=$rowzp['id_zap']?>" <?=$span?>>
<td>
<a href="index.php?nomer_kvitancy=<?=$rowzp['kuda']?>"><?=$rowzp['kuda']?></a>
</td>
<td><?
$app = $filter->nomer2model ($rowzp['kuda']);

foreach ($app as $a=>$rowapp) {

echo $rowapp['aparat_name'] .' <span id="aparat_'.$rowzp['id_zap'].'">' .$rowapp['name_proizvod'];

echo ' <span id="model_' . $rowzp['id_zap']. '">' . $rowapp['model']. '</span>';
}
?></span>

</td>

<td><?=$rowzp['title']?></td>

<td><?=$rowzp['name_zap']?></td>


<td><?=$rowzp['kolvo']?></td>
<td>
<div style="font-size:x-small; border-bottom: 1px dashed #61B0FF; margin: 1px;">Заказал: <?=$baza->user_id2name($rowzp['user_id'])?></div>
<?=$rowzp['date_zakaz']?>
</td>
<td>

<!-- выбор ответственного-->
<select name="<?=$rowzp['id_zap']?>" id="id_resp_zap_<?=$rowzp['id_zap']?>" title="<?=$_SESSION['user_id']?>">
			<option value="">-ответственный-</option>
			<? //$user = $user_filter->select_users (); //var_dump ($user); die();
			//print_r ($user);
			foreach ($user as $a => $rowuser)
			{?>
			<option value="<?=$rowuser['user_id']?>" <?if($rowuser['user_id'] == $rowzp['id_resp']) echo 'selected';?>><?=$rowuser['login']?> | <?=$rowuser['fam']?> <?=$rowuser['imya']?></option>
			
			<?}?>
			
</select>

<!-- выбор ответственного-->

</td>
<td>

<?

if ($id_sost == 7 OR $id_sost == 8 OR $id_sost == 9) {echo '<p><b><font color="fff">Аппарат выдан!</b></font></p>';}
elseif ($id_sost == 4) {echo '<p><b><font color="fff">Аппарат без ремонта!</b></font></p>';}

else {echo '<p><font color="green">Актуально</font></p>';}

?>
</td>

<td>
<input class="" id="price_<?=$rowzp['id_zap']?>" type="text" placeholder="цена [число в $.]" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"/></br>
<!-- Замена места нахождения-->
<select id="sklad_<?=$rowzp['id_zap']?>">
	<option value="" selected>--выбрать склад--</option>
   <?
   
   $where = $filter->select_where_teh ();
	foreach ($where as $a=>$rowwhere)
   {?>
       <option value="<?=$rowwhere['id_where']?>"><?=$rowwhere['name_where']?></option>
   <?}
   ?>
</select>
<!-- ///////Замена места нахождения-->
<select id="id_sost_<?=$rowzp['id_zap']?>">
						
						<option value="1" selected="">Новый</option>
						<option value="0">Б.У.</option>
					</select>

</td>
<td><input class="" id="<?=$rowzp['id_zap']?>" type="button" value="Поставить на склад" onclick="changeStatusZapchast('<?=$rowzp['id_zap']?>', '<?=$rowzp['name_zap']?>', '<?=$rowzp['id_aparat']?>', '<?=$rowzp['id_aparat_p']?>', '<?=$rowzp['id_proizvod']?>', '<?=$rowzp['kolvo']?>')"/></br>
<input class="" id="<?=$rowzp['id_zap']?>" type="button" value="Удалить" onclick="DeleteZapchast('<?=$rowzp['id_zap']?>')"/></br>

<div style="font-size:x-small; border-top: 1px dashed #61B0FF; margin: 1px;">
<?if ($rowzp["update_time"]) {?>
						Обновлено: <?=$rowzp["update_time"]?> by

			<?
			foreach ($user as $a => $rowuser)
			{?>
			<?if($rowzp['update_user'] == $rowuser['user_id']) echo  $rowuser['login'];
			}}?>
						
	</div>

</td>
</tr>
							
							<?}?></table></div>
						</li>
					</ul>
			<?}?></div>
		</div>



<?}?>
<?}?>
<?}?>

<?}?>
