<html>
<head>
	<title>
		ФИЛЬТР ЗАЯВОК СЦ ТЕХНОДОКТОР1
	</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link href='http://fonts.googleapis.com/css?family=Istok+Web' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>

</head>
<body>



<div class="abc">
<? print 'Вы: <b>' . $_SESSION['login']; ?></b>  <a href="exit.php">Выход</a>
<br>
<a href="edit_settings.php" target="_blank">Настройки</a>
</div>

<div class="table" id="table">
<table align="center" border="1" width="1280">
<tr>
<td align="left"><img src="images/logo.png">

<!-- вывод графика
<img src="test/test.php">
<!-- конец вывода графика -->


</td>
</tr>

<?
if ($_SESSION['id_group'] == 1 or $_SESSION['id_group'] == 2 or $_SESSION['id_group'] == 3) {?>
<td align="left"><a href="store.php" target="_blank">Склад</a>   <a href="new_kvitancy.php" target="_blank">Новая квитанция</a>    <a href="parts.php" target="_blank">Запчасти</a>           
    <a href="search_comment.php" target="_blank">Поиск в комментариях</a>     <a href="last_comment.php" target="_blank">Последние комменты</a>     
	<a href="/stat/graf/stats.html" target="_blank">График</a>
	<a href="ShowKvit.php" target="_blank">Квитации</a>
	<a href="show_coffee_price.php" target="_blank">Кофе-прайс</a>
	<a href="http://technodoctor.kiev.ua/social/" target="_blank">SOCIAL</a>
	<a href="https://www.google.com/calendar/render?cid=support%40technopoisk.com.ua#main_7" target="_blank">Водитель</a>
	<a href="show_user.php" target="_blank">Сотрудники</a>
	
	
	
	
</td>
<?}?>


<tr> 
		<td>
	<form name="MAIN" action="<?=$_SERVER['PHP_SELF']?>" method="GET">
	
	<select name="date">
	<option value="pr" <? if(!$_GET["date"]) {echo 'checked';} elseif($_GET["date"]=='pr') {echo 'selected';} ?>>Дата приемки</option>
	<option value="vd" <? if($_GET["date"]=='vd') {echo 'selected';} ?>>Дата выдачи</option>
	<option value="ok" <? if($_GET["date"]=='ok') {echo 'selected';} ?>>Дата окончания ремонта</option>
	</select>
	
	<?
	// условия для выборки даты
		//$m='0'. (date('m') - 2);
		//$first_day = date('Y') . '-'. $m . '-01';
		
		$s = strtotime('-2 month');
		$first_day = date("Y-m-d", $s);
        
	?>
	<input name="start_date" type="date" value="<? if ( isset( $_GET['date'] ) ) {echo $_GET["start_date"];} else {echo $first_day;} ?>" />
	<input name="end_date" type="date" value="<? if ( isset( $_GET['date'] ) ) {echo $_GET["end_date"];} else {echo date("Y-m-d");} ?>" />  
	</br>
	<input name="nomer_kvitancy" type="text" size="1" value="<? echo $_GET["nomer_kvitancy"]; ?>" onclick="this.value='';" onfocus="this.value='';" autofocus />
<!-- ФИЛЬТРЫ!!! -->


<!--// фильтр сервиса-->
<select name="id_sc">
  <option value="">Приемка</option>
   <?
   
   $service = $filter->select_service ();
	foreach ($service as $a=>$rowsc)
   {?>
       <option value="<?=$rowsc['id_mechanic']?>" <?
	   if ($_GET) {
	   
	   if($rowsc['id_mechanic'] == $_GET['id_sc']) echo 'selected';
	   
	   }else{
	   
	   $sc_ = $filter->select_id_sc ($_SESSION['id_sc']);
	   if( ( $_SESSION['id_group'] == 2) AND ($rowsc['id_mechanic'] == $sc_) ) echo 'selected';
	   }
	   
	   ?>><?=$rowsc['name_mechanic']?></option>
   <?}
   ?>
</select>
<!--/////// фильтр сервиса-->


<!-- Замена места нахождения-->
<select name="id_where">
	<option value="">ГдеТехника</option>
   <?
   
   $where = $filter->select_where_teh ();
	foreach ($where as $a=>$rowwhere)
   {?>
       <option value="<?=$rowwhere['id_where']?>" <?if($rowwhere['id_where'] == $_GET['id_where']) echo 'selected';?>><?=$rowwhere['name_where']?></option>
   <?}
   ?>
</select>
<!-- ///////Замена места нахождения-->


<!--/ фильтра механиков -->
<!--/////////// фильтра механиков кончился:) -->

<!-- выбор ответственного-->
<select name="id_resp">
			<option value="">Ответственный</option>
			<? $users = $user_filter->select_users (); //var_dump ($user); die();
			//print_r ($user);
			foreach ($users as $a => $rowuser)
			{?>
			<option value="<?=$rowuser['user_id']?>" <?
			
			//if($rowuser['user_id'] == $_GET['id_resp']) echo 'selected';
			
			 if ($_GET) {
	   
				if($rowuser['user_id'] == $_GET['id_resp']) echo 'selected';
	   
					}else{
	   
					   $sc_ = $filter->select_id_sc ($_SESSION['id_sc']);
					   if( ( $_SESSION['id_group'] == 3) AND ($rowuser['user_id'] == $_SESSION['user_id']) ) echo 'selected';
					}
			
			
			?>>*<?=$rowuser['login']?>* | <?=$rowuser['fam']?> <?=$rowuser['imya']?></option>
			<?}?>
			
</select>

<!-- выбор ответственного-->
<!--/ фильтра механиков -->
<select name="id_mechanic">
	<option value="">Выбрать механика</option>
	<?
	$meh = $filter->select_mechanic ();
	foreach ($meh as $a=>$rowmeh)
   {?>
	   <option value="<?=$rowmeh['id_mechanic']?>" <?if($rowmeh['id_mechanic'] == $_GET['id_mechanic']) echo 'selected';?>><?=$rowmeh['name_mechanic']?></option>
   <?}
   ?>
</select>
<!--/////////// фильтра механиков кончился:) -->


<!--/фильтр аппаратов -->
<select name="id_aparat">
	<option value="">Аппарат</option>
	<?
	$apparati = $filter->select_aparat ();
	foreach ($apparati as $a=>$rowap)
   {?>
	   <option value="<?=$rowap['id_aparat']?>" <?if($rowap['id_aparat'] == $_GET['id_aparat']) echo 'selected';?>><?=$rowap['aparat_name']?></option>
   <?}
	?>
   </select>
<!--/////////фильтр аппаратов кончился -->

<!--/фильтр производителя -->
<select name="id_proizvod">
	<option value="">Производитель</option>
	<?
	$brand = $filter->select_proizvoditel ();
	foreach ($brand as $a=>$rowbr)
   {?>
	   <option value="<?=$rowbr['id_proizvod']?>" <?if($rowbr['id_proizvod'] == $_GET['id_proizvod']) echo 'selected';?>><?=$rowbr['name_proizvod']?></option>
   <?}
	?>
   </select>
<!--/////////фильтр производителя кончился -->



<!-- фильтр ремонта -->
<select name="id_sost">
<option value="">-состояние-</option>
<option value="14" <? if ($_GET['id_sost'] == 14) echo 'selected';?>>Показать:"Все что ремонте" </option>
<option value="11" <? if (($_GET['id_sost'] == 11) or (!isset($_GET["id_sost"]))) echo 'selected';?>>Показать:"В РАБОТЕ и заказана деталь" </option>
<option value="12" <? if ($_GET['id_sost'] == 12) echo 'selected';?>>Показать:"Все что на ВЫДАЧЕ лежит" </option>
<option value="13" <? if ($_GET['id_sost'] == 13) echo 'selected';?>>Показать:"Все что ВЫДАНО" </option>

	<?
	$remont = $filter->select_sost ();
	foreach ($remont as $a=>$rowrem)
   {?>
       <option value="<?=$rowrem['id_sost']?>" <?if($rowrem['id_sost'] == $_GET['id_sost'] ) echo 'selected';?>><?=$rowrem['name_sost']?></option>
   <?}
   ?>
</select>
<!-- //////////фильтр ремонта кончился-->

<!-- фильтра vid_remonta типа ремонта-->
<select name="id_vid_remonta">
	<option value="">Вид ремонта</option>
   <?
   
   $vid_remonta = $filter->select_vid_remonta ();
	foreach ($vid_remonta as $a=>$row_vid_remonta)
   {?>
       <option value="<?=$row_vid_remonta['id_remonta']?>" <?if($row_vid_remonta['id_remonta'] == $_GET['id_vid_remonta']) echo 'selected';?>><?=$row_vid_remonta['name_remonta']?></option>
   <?}
   ?>
</select>
<!-- //////фильтра типа ремонта кончился-->


<input id="signIn" name="signIn" class="rc-button rc-button-submit" type="submit" value="Показать">

<input class="rc-button-red rc-button-submit" type="button" value="Сброс" onClick="window.location.replace('<?=$_SERVER['PHP_SELF']?>')">

</form>
<!--///////// ФИЛЬТРЫ кончились-->
<?php
//var_dump($_GET);die;
 ?>

<!--///////// ПОИСК-->

<form name="search" action="<?=$_SERVER['PHP_SELF']?>" method="GET">

<input name="search" type="text" value="<?=$_GET['search']?>" />
<input class="rc-button-green rc-button-submit" type="submit" value="Поиск"> - Поиск по <b>фамилии, телефоне</b> клиента или <b>модели</b> устройства.
</form>
<!--///////// ПОИСК кончились-->

<!--квитанции гарантия!!! -->

<?
if ($_SESSION['id_group'] == 2) {
$gar = $baza->select_warranty_kvitancys ();

if (count($gar) >=1) {

echo '<b>Гарантийные</b> квитанции:';
	foreach ($gar as $rowgar) {?>
		&nbsp;<a href="<?=$_SERVER['PHP_SELF']?>?nomer_kvitancy=<?=$rowgar['nomer_kvitancy']?>"><b>&laquo;</b><?=$rowgar['aparat_name']?> <?=$rowgar['name_proizvod']?> <?=$rowgar['model']?><b>&raquo;</b></a>&nbsp;
		<?} 
echo '<br><br>';
	}
}		
?>
<!--///////// кончились-->



<!--квитанции которых тут быть не должно!!!! -->
<?
if ($_SESSION['id_group'] == 2) {
$att2 = $baza->select_kvit_5days ($_SESSION["user_id"]);

if (count($att2) >=1) {

//var_dump ($att2);die;

echo 'Квитанции, <b style="color:red">которых тут быть не должно!</b>:';
	foreach ($att2 as $rowatt2) {?>
		<a style="color:red" href="index.php?nomer_kvitancy=<?=$filter->id2nomer ($rowatt2)?>"><?=$filter->id2nomer ($rowatt2)?></a>
		<?} 
echo '<br><br>';
	}
}		
?>

<!--квитанции 5 дней  кончились!!! -->

<!--квитанции на звонок-->

<?
if ($_SESSION['id_group'] == 2) {				
$sog = $baza->select_soglasovat($_SESSION['user_id']);

//var_dump($sog);die;
							
	if (count($sog) >=1) {
echo '<b>Позвонить</b> клиенту:';
	foreach ($sog as $rowsog) {?>
		&nbsp;<a href="<?=$_SERVER['PHP_SELF']?>?nomer_kvitancy=<?=$rowsog['nomer_kvitancy']?>"><b>&laquo;</b><?=$rowsog['aparat_name']?> <?=$rowsog['name_proizvod']?> <?=$rowsog['model']?><b>&raquo;</b></a>&nbsp;
		<?}
echo '<br><br>';
	}
}
?>
<!--///////// согласование звонок кончились-->


<!--квитанции на звонок-->

<?
if ($_SESSION['id_group'] == 2) {								
$poz = $baza->select_soglasovat2($_SESSION['user_id']);

//var_dump($poz);die;
							
	if (count($poz) >=1) {
echo '<b>Согласовать цену:</b>';
	foreach ($poz as $rowpoz) {?>
		&nbsp;<a href="<?=$_SERVER['PHP_SELF']?>?nomer_kvitancy=<?=$rowpoz['nomer_kvitancy']?>"><b>&laquo;</b><?=$rowpoz['aparat_name']?> <?=$rowpoz['name_proizvod']?> <?=$rowpoz['model']?><b>&raquo;</b></a>&nbsp;
		<?}
echo '<br><br>';
	}
}
?>
<!--///////// согласование звонок кончились-->


<!--мои заявки-->
<?$my_kvit = $baza->select_my_kvitancys_resp($_SESSION['user_id']);
	if (count($my_kvit) >=1) {
		echo 'Мои заявки:';
			foreach ($my_kvit as $row_my_kvit) {
				$span = $baza->get_color ($row_my_kvit['id_sost']); ?>	
	&nbsp;<a href="<?=$_SERVER['PHP_SELF']?>?nomer_kvitancy=<?=$row_my_kvit['nomer_kvitancy']?>"><b>&laquo;</b><?=$row_my_kvit['name_proizvod']?> <?=$row_my_kvit['model']?><b>&raquo;</b></a>&nbsp;
		
			<?}?>
<br><br>
<?}?>
<!--///////// мои заявки кончились-->

<!--мои запчасти-->

<?$my_zap = $baza->select_my_zap_resp($_SESSION['user_id']);
	
if (count($my_zap) >=1) {?>
<b>Мои запчасти :</b>
	<? foreach ($my_zap as $row_my_kvit) {
		$span = '';?>
			&nbsp;&nbsp;<a href="<?=$_SERVER['PHP_SELF']?>?nomer_kvitancy=<?=$row_my_kvit['kuda']?>">
			<span <?=$span?>>
			<?=$row_my_kvit['title']?>/<?=$row_my_kvit['name_proizvod']?> <?=$row_my_kvit['model']?>
			
			
			</span></a>
		<?}
	}?>
<!--///////// мои запчасти кончились-->

		</td>
	</tr>
	
	<tr><td>
	<?if(!empty($_GET['id_aparat'])) {?>
	<!--<img src="http://baza/stat/graf/count_apparat_all.php?id_aparat=<?=$_GET["id_aparat"]?>&aparat_name=<?=$aparat_name?>"><hr>-->
	<?}?>
	</td></tr>
</div>


 


<?

function diff ($date_priemka) {
	return floor((strtotime("now")-strtotime($date_priemka))/86400);
}

$query = $filter->main_select(
					$_GET['date'],
					$_GET['start_date'],
					$_GET['end_date'],
					$_GET['id_mechanic'],
					$_GET['id_aparat'],
					$_GET['id_proizvod'],
					$_GET['id_sost'],
					$_GET['id_sc'],
					$_GET['nomer_kvitancy'],
					$_GET['id_kvitancy'],
					trim($_GET['search']),
					$_GET['id_resp'],
					$_GET['id_where'],
					$_GET['id_vid_remonta'],
					$_SESSION['id_group']
					
					);

if ($query) {

/* Счетчики */


$count = count($query);

$count_load = $filter->select_load ();
$count_today = $filter->select_today_all ();

$count_month_all = $filter->select_month_all ();

$count_month = $count_month_all[0]["cnt_0"];
$count_techno = $count_month_all[0]["cnt_1"];
$count_artema = $count_month_all[0]["cnt_2"];
$count_pirogova = $count_month_all[0]["cnt_3"];

if ($count_month_all AND $count_month > 1) {
$count_techno_pr = round(($count_techno*100)/$count_month);
$count_artema_pr = round(($count_artema*100)/$count_month);
$count_pirogova_pr = round(($count_pirogova*100)/$count_month);
}
/* Счетчики */
		




?>
<div class="table">
<?if (!isset($_GET["id_sost"])) {?>

<tr><td><p>Найдено <b><font color="red"><?=$count?> </font></b> аппарата.<br>

Загрузка по сервисам: 
 (Гончара,79: <b><?=$count_load[0]["gonchara79"]?></b> | Артема,7: <b><?=$count_load[0]["artema7"]?></b> | Пирогова,2: <b><?=$count_load[0]["pirogova2"]?></b>).<br>



За месяц <b><font color="blue"><?=$count_month?></font></b>

(Гончара,79: <span class="gonchara"><b><?=$count_techno?></b></span> (<?=$count_techno_pr?>%) | Артема,7: <span class="artema"><b><?=$count_artema?></b></span> (<?=$count_artema_pr?>%) | Пирогова,2: <span class="pirogova"><b><?=$count_pirogova?></b></span> (<?=$count_pirogova_pr?>%)).

Сегодня <b><span style="color: green; font: 20pt 'Verdana';"><?=$count_today[0]["cnt_0"]?></font></b> приёмок (Гончара,79: <b><?=$count_today[0]["cnt_1"]?></b> | Артема,7: <b><?=$count_today[0]["cnt_2"]?></b> | Пирогова,2: <b><?=$count_today[0]["cnt_3"]?></b>).

 
</p></td></tr>

<?}
else {?>
<tr><td><p>Найдено <b><font color="red"><?=$count?> </font></b> аппаратов. </p></td></tr>
<?}?>
</div>
<div class="table">
	<table align="center" border="1" width="1280">
	<tr>
		<th width="20"><b>№</b></th>
		<th width="80"><b>Дата приемки</b></th>
		<th width="80"><b>Дата выдачи</b></th>
		<th width="250"><b>Ремонт</b></th>
		<th><b>Примечение</b></th>
	</tr>
	
<?
	foreach ($query as $a=>$row) {
	
				$span = $baza->get_color ($row['id_sost']);
	
?>
	<tr>
		<td width="20"><a href="<?=$_SERVER['PHP_SELF']?>?nomer_kvitancy=<?=$row['nomer_kvitancy']?>"><?=$row['nomer_kvitancy']?></a></td>
		<td width="80"><p><span id="app_<?=$row['id_kvitancy']?>" <?=$span?>><font size="1"><?=$row['date_priemka']?></font></span></p></td>
		<td width="80"><p><span id="app_<?=$row['id_kvitancy']?>" <?=$span?>><font size="1"><?if ($row['date_vydachi'] == '0000-00-00') {$row['date_vydachi'] = 'Не выдан';}?><?=$row['date_vydachi']?></font></span></p></td>
		<td width="850">
<div id="save_<?=$row['id_kvitancy']?>" align="left"></div>
<!-- Аппарт, неисправность, клиента вывод данных!-->
<br>




<!-- выбор ответственного-->	


<p>
<!--
-->

<?
/*
switch ($row['id_mechanic']) {

case 2:
    //echo '<img src="images/figa.png">';
    break;
case 13:
    echo '<img src="images/star.png">';
    break;
case 14:
    //echo '<img src="images/figa.png">';
    break;
default:
    echo "";

}
*/
?>

<span class="days"><?=diff($row['date_priemka'])?> days</span>

<span class="<?

switch ($row['id_mechanic']) {

case 2:
    echo 'gonchara';
    break;
case 13:
    echo 'artema';
    break;
case 14:
    echo 'pirogova';
    break;
default:
    echo "gotov";

}

?>"><font>
<?
  foreach ($service as $a=>$rowsc)
   
	{
       if($rowsc['id_mechanic'] == $row['id_mechanic']) echo '['.$rowsc['name_mechanic'].']';
	}
?>
</font></span>
<span id="app_<?=$row['id_kvitancy']?>" <?=$span?>>
<font>
<?if ($row['id_remonta'] == 1 OR $row['id_remonta'] == 5) {echo '<b><font color="red">[гарантийный] </font></b>';}
elseif ($row['id_remonta'] == 4) {echo '<b><font color="red">[выездной] </font></b>';}
?>
	<span id="aparat_name_<?=$row['id_kvitancy']?>"><b>[<?=$row['aparat_name']?>]</span>
	<span id="name_proizvod_<?=$row['id_kvitancy']?>"><?=$row['name_proizvod']?></span>
	<?=$row['model']?></b> - <?=$row['neispravnost']?></br>
	<span id="phone_<?=$row['id_kvitancy']?>"><b><?=$row['phone']?></b></span>
	<?=$row['fam']?> <?=$row['imya']?> <?=$row['otch']?></font>
<?if ($row['whereid'] == 9) echo '<b><font color=#FF0033>[Уже был у нас!]</font></b>';?>

</span></p>
<!--//////////// Аппарт, неисправность, клиента вывод данных!-->

<!-- Замена статуса-->
<select name="<?=$row['id_kvitancy']?>" id="status_<?=$row['id_kvitancy']?>">
	<option value="1" <? if($row['id_sost'] == 1) echo 'selected';?> >В работе</option>
	<option value="18" <? if($row['id_sost'] == 18) echo 'selected';?> >Согласовать цену</option>
	<option value="10" <? if($row['id_sost'] == 10) echo 'selected';?> >Позвонить клиенту</option>
	<option value="17" <? if($row['id_sost'] == 17) echo 'selected';?> >наТЕСТе</option>	
	<option value="3" <? if($row['id_sost'] == 3) echo 'selected';?> >Заказана деталь</option>
	<option value="4" <? if($row['id_sost'] == 4) echo 'selected';?> >Без ремонта</option>
	<option value="6" <? if($row['id_sost'] == 6) echo 'selected';?> >ГОТОВ</option>
	<option value="7" <? if($row['id_sost'] == 7) echo 'selected';?> >Выдан с ремонтом</option>
	<option value="8" <? if($row['id_sost'] == 8) echo 'selected';?> >Выдан без ремонта</option>
	<option value="9" <? if($row['id_sost'] == 9) echo 'selected';?> >Выкуплен(списан)</option>
	
</select>
<!-- ////////Замена статуса кончилась-->


<!-- Замена места нахождения-->
<select name="<?=$row['id_kvitancy']?>" id="id_where_<?=$row['id_kvitancy']?>">
	<option value="">-ГдеТехника-</option>
   <?
   //$where = $filter->select_where_teh ();
	foreach ($where as $a=>$rowwhere)
   {?>
       <option value="<?=$rowwhere['id_where']?>" <?if($rowwhere['id_where'] == $row['id_where']) echo 'selected';?>><?=$rowwhere['name_where']?></option>
   <?}
   ?>
</select>
<!-- ///////Замена места нахождения-->
<!-- выбор ответственного-->
<select name="<?=$row['id_kvitancy']?>" id="resp_<?=$row['id_kvitancy']?>">
			<option value="">--Ответственный--</option>
			<? //$user = $user_filter->select_users (); //var_dump ($user); die();
			//print_r ($user);
			foreach ($users as $a => $rowuser)
			{?>
			<option value="<?=$rowuser['user_id']?>" <?if($row['id_responsible'] == $rowuser['user_id']) echo 'selected';?>>*<?=$rowuser['login']?>* | <?=$rowuser['fam']?> <?=$rowuser['imya']?></option>
			<?}?>
			
</select>

<input id="sds_<?=$row['id_kvitancy']?>" type="button" value="sms">



<!-- Добавление комментариев-->
<br>

<?
$comment = $baza->select_comment ($row['id_kvitancy'], $count=1);
?>



<span style="display:inline-block; width:11px; height:11px; background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAALCAIAAAD0nuopAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAE1JREFUeNpinDlzJgNlgAWI09LScEnPmjWLoAImrHpIAkwMFAMqGMGC6X44GzkIsHoQooAFTTVQKdbAwxOigyMsmIh3MC7ASHnqBAgwAD4CGeOiDhXRAAAAAElFTkSuQmCC');
/*background-position:-11px 0;*/"></span>	
	<a id="show_comments_<?=$row['id_kvitancy']?>" name="<?=$row['id_kvitancy']?>">
	Комментарии<font color="red"><sup><?=$comment[0]["count(id_comment)"]?></sup></font>
	</a>
										
<div style="display:none;" id="new_com_<?=$row['id_kvitancy']?>">

<!--
<div>
<textarea cols="60" rows="3" id="comment_<?=$row['id_kvitancy']?>" name="comment" ></textarea><br>
<input type="button" value="Добавить комментарий" onclick="AddComment('<?=$row['id_kvitancy']?>', 'comment_<?=$row['id_kvitancy']?>', '<?=$_SESSION['user_id']?>', '<?=$row['nomer_kvitancy']?>')">
</div>
-->
</div>



<!-- ///////////Добавление комментариев-->


<!-- Вывод остальных данных, если одна заявка открыта-->

<span style="display:inline-block; width:11px; height:11px; background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAALCAIAAAD0nuopAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAE1JREFUeNpinDlzJgNlgAWI09LScEnPmjWLoAImrHpIAkwMFAMqGMGC6X44GzkIsHoQooAFTTVQKdbAwxOigyMsmIh3MC7ASHnqBAgwAD4CGeOiDhXRAAAAAElFTkSuQmCC');
/*background-position:-11px 0;*/"></span>	
	<a id="show_info_<?=$row['id_kvitancy']?>" name="<?=$row['id_kvitancy']?>">
	Информация
	</a>
										
<div style="display:none;" id="info_<?=$row['nomer_kvitancy']?>" name="<?=$row['user_id']?>">
</div>

<!-- //////Вывод остальных данных, если одна заявка открыта-->


<!--Запчасти-->
<span style="display:inline-block; width:11px; height:11px; background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAALCAIAAAD0nuopAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAE1JREFUeNpinDlzJgNlgAWI09LScEnPmjWLoAImrHpIAkwMFAMqGMGC6X44GzkIsHoQooAFTTVQKdbAwxOigyMsmIh3MC7ASHnqBAgwAD4CGeOiDhXRAAAAAElFTkSuQmCC');
/*background-position:-11px 0;*/"></span>	
	<a id="show_zapchasti_<?=$row['nomer_kvitancy']?>" name="<?=$row['nomer_kvitancy']?>"  title="<?=$row['id_proizvod']?>" lang="<?=$row['id_aparat']?>">
	Запчасти
	</a>
										
<div style="display:none;" id="new_zap_<?=$row['nomer_kvitancy']?>">
123
</div>
<!--//////Запчасти-->

<!-- Склад-->
<span style="display:inline-block; width:11px; height:11px; background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAALCAIAAAD0nuopAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAE1JREFUeNpinDlzJgNlgAWI09LScEnPmjWLoAImrHpIAkwMFAMqGMGC6X44GzkIsHoQooAFTTVQKdbAwxOigyMsmIh3MC7ASHnqBAgwAD4CGeOiDhXRAAAAAElFTkSuQmCC');
/*background-position:-11px 0;*/"></span>	
	<a id="show_store_<?=$row['nomer_kvitancy']?>" name="<?=$row['nomer_kvitancy']?>">
	Склад
	</a>
										
<div style="display:none;" id="store_<?=$row['nomer_kvitancy']?>">
Склад
</div>

		</td>
	<td>

<!--Конец склада-->
<!-- Замена механика-->
<?
	if (!empty($row['update_user']) and !empty($row['update_time'])) {?>
	<div id="update_<?=$row['id_kvitancy']?>" align="left"><p><font size="1"><b><?=$row['update_user']?></b> <?=$row['update_time']?></font></p></div>
<?}
	if (empty($row['update_user']) and empty($row['update_time'])) {?>
	<div id="update_<?=$row['id_kvitancy']?>" align="left"><p><b><font color="red" size="2">Не выбран инженер!</b></font></div>
		<?}?>
		
<select name="<?=$row['id_kvitancy']?>" id="meh_<?=$row['id_kvitancy']?>">
  <option value="">Выбрать механика</option>
  <?
  
	foreach ($meh as $a=>$rowmeh)
   {?>
	   <option value="<?=$rowmeh['id_mechanic']?>" <?if($rowmeh['id_mechanic'] == $row['mehanic']) echo 'selected';?>><?=$rowmeh['name_mechanic']?></option>
   <?}
   ?>
 
</select></br>
<!-- ////////Замена механика-->
	
		

<!-- Добавить примечания-->
<textarea name="primechanie" id="primechanie_<?=$row['id_kvitancy']?>"><?=$row['comments']?></textarea></br>
<input class="" id="primechanie_<?=$row['id_kvitancy']?>" type="button" value="Добавить примечание" onclick="AddPrimechanie('<?=$row['id_kvitancy']?>', 'primechanie_<?=$row['id_kvitancy']?>', 'user_<?=$row['id_kvitancy']?>')">
<!--///////////Добавить примечания-->

		</td>
	</tr>
	
<?}}?>
</table>
</div>
</body>
</html>