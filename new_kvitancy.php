<?php

error_reporting(E_ALL);

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
$baza = Baza::getInstance();
// проверка авторизации
$auth = $login->auth();
if ($auth == true AND ($_SESSION['id_group'] == 1 or $_SESSION['id_group'] == 2)) {



# Открытие сессии.
		session_start();
?>

<html>
<head>
	<title>
		ФИЛЬТР ЗАЯВОК | НОВАЯ КВАТАНЦИЯ
	</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link href='http://fonts.googleapis.com/css?family=Istok+Web' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" type="text/css" />
	<link rel="stylesheet" href="css/style2.css" type="text/css" />
	
	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/jquery.autocomplete.js"></script>


<script type="text/javascript">
  function go(addr) {
    window.open(addr,"add", "menubar=yes,width=640,height=480");
  }
</script>


</head>
<h1>Новая квитанция</h1>
<body>
<form name="main" id="main" action="<?=$_SERVER['PHP_SELF']?>" method="POST" autocomplete="off">

<div class="table" id="table">

<table align="center" border="1" width="1024">
<tr><td align="right">Вы: <b><?=$_SESSION['login']?></b> <a href="exit.php">Выход</a>      <a href=javascript:window.close()>ЗАКРЫТЬ ОКНО</a></td></tr>

</table>

<table align="center" border="1" width="1024">

<tr>
<td><b>Выберите аппарат из списка:</b></td>
<td>
<div id="apparat_div">
<!-- новый фильттр аппараторв -->
						<div align="left">
                                <b>Поиск аппаратов (русский)</b>
                                <br />
                                <input class="new_kvitancy" type="text" size="30" value="" id="inputApparat" onkeyup="look_apparat(this.value);" />
                        </div>
                        <div align="left" class="suggestionsBox" id="apparat_box" style="display: none;">
                                
                                <div class="suggestionList" id="apparat_list">
                                         
                                </div>
                        </div>
<!-- новый фильттр аппараторв -->


<!--/фильтр аппаратов -->
<select name="id_aparat" id="id_aparat">
	<option value="">--Название аппарата--</option>
	<?
	$apparati = $filter->select_aparat ();
	//var_dump($apparati);die;
	foreach ($apparati as $a=>$rowap)
   {?>
	   <option value="<?=$rowap['id_aparat']?>"><?=$rowap['aparat_name']?></option>
   <?}
	?>
   </select>
<a href="" class="btn-slide">+</a>
<span id="panel">
<input class="new_kvitancy" name="add_aparat_name" id="add_aparat_name" type="text">
<input class="new_kvitancy" name="submit" id="add_aparat" type="button" value="Добавить аппарат">
</span>
<br>
<!--/////////фильтр аппаратов кончился -->
<br>
</div>
<div id="proizvod_div">
<!-- новый фильттр производ -->
						<div align="left">
                                <b>Поиск бренда (анг.)</b>
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
	<option value="">--Производитель--</option>
	<?
	$proizvoditel = $filter->select_proizvoditel ();
	//var_dump($proizvoditel);die;
	foreach ($proizvoditel as $a=>$rowpr)
   {?>
	   <option value="<?=$rowpr['id_proizvod']?>"><?=$rowpr['name_proizvod']?></option>
   <?}
	?>
   </select>
<a href="" class="btn-slide">+</a>
<span id="panel">
<input class="new_kvitancy" name="add_proizvod_name" id="add_proizvod_name" type="text">
<input class="new_kvitancy" name="submit" id="add_proizvod" type="button" value="Добавить бренд">
</span>
<!--/////////фильтр производителя кончился -->
</div>

</td>
</tr>

<tr>
<td><b>Введите модель аппарата:</b></td>
<td><input class="new_kvitancy" name="model" type="text" size="65" placeholder="Например: me301 k001" autocomplete="off"></td>
</tr>

<tr>
<td><b>Введите серийный номер аппарата:</b></td>
<td><input class="new_kvitancy" name="ser_nomer" type="text" size="65" placeholder="Ищите на аппарате номер с пометкой sn s/n" autocomplete="off"></td>
</tr>

<tr>
<!--фильтр ремонта -->
<td><b>Выберите вид ремонта:</b></td>
<td>
<!--
<select name="id_remonta">
	<option value="">--Вид ремонта--</option>
	<option value="2" selected>Не гарантийный</option>
	<option value="1">Гарантийный</option>
</select>
-->
<select name="id_remonta" id="id_remonta">
	<option value="">--Вид ремонта--</option>
	<?
	$id_remonta = $filter->select_vid_remont ();
	//var_dump($id_remonta);die;
	foreach ($id_remonta as $a=>$rowidrem)
   {?>
	   <option value="<?=$rowidrem['id_remonta']?>"><?=$rowidrem['name_remonta']?></option>
   <?}
	?>
   </select>

</td>
<!--/////////фильтр ремонта кончился -->
</tr>

<tr>
<td><b>Заявленная клиентом неисправность:</b></td>
<td>
<textarea rows="3" cols="65" name="neispravnost" id="neispravnost" placeholder="Выясните у клиента поточнее что у него сломалось. ПИШИТЕ ГРАМОТНО И ЛОГИЧНО[СТАВЬТЕ ЗНАКИ ПРЕПИНАНИЯ]" autocomplete="off"></textarea>
</td>
</tr>

<tr>
<td><b>Опишите внешний вид аппарата, видимые дефекты:</b></td>
<td>
<textarea rows="2" cols="65" name="vid">Следы эксплуатации (б.у.): царапины, потертости</textarea>
</td>
</tr>

<tr>
<td><b>Укажите комплектность:</b></td>
<td>
<textarea rows="3" cols="65" name="komplektnost">
Без упаковки (без заводского комплекта), без блока питания, без сетевых (соединительных) кабелей, без SIM карт и съемных носителей.
</textarea>
</td>
</tr>

<tr>
<!--/ фильтра механиков -->
<td><b>СЦ, выполняющий ремонт:</b></td>
<td>
<select name="id_mechanic">
	<option value="">--Выбрать приемку--</option>
   <?
if ($_SESSION['id_group'] != 1)
	{
	
	
	//var_dump($id_m);die;
	
    $service = $filter->select_service_new ($_SESSION['id_sc']);
	}
else
	{
	$service = $filter->select_service ();
	}
	
	foreach ($service as $a=>$rowsc)
   {?>
       <option value="<?=$rowsc['id_mechanic']?>" <?if ($_SESSION['id_group'] != 1) echo 'selected';?>><?=$rowsc['name_mechanic']?></option>
   <?}
   ?>
</select>
</tr>

<tr>
<!--/////////// фильтра механиков кончился:) -->
<td><b>П</b>римечание:</td>
<td>
<textarea rows="1" cols="65" name="primechaniya"></textarea>
</td>
</tr>

</table>
<br>
<table align="center" border="1" width="1024">
<tr>

						<div align="left">
                                <b>Поиск клиентов</b>
                                <br />
                                <input class="new_kvitancy" type="text" size="30" value="" id="inputString" onkeyup="lookup(this.value);" />
                        </div>
                        <div align="left" class="suggestionsBox" id="suggestions" style="display: none;">
                                
                                <div class="suggestionList" id="autoSuggestionsList">
                                         
                                </div>
                        </div>
						
<input class="new_kvitancy" name="user_id" id="user_id" type="hidden" size="30">
<td><b>Фамилия:</b>
<input class="new_kvitancy" name="fam" id="fam" type="text" autocomplete="off" size="30">

<b>Имя:</b>
<input class="new_kvitancy" name="imya" id="imya" type="text" autocomplete="off" size="30">

<b>Отчество:</b>
<input class="new_kvitancy" name="otch" id="otch" type="text" autocomplete="off" size="40">

</td>
</tr>

<tr>
<td>

<b>Номер телефона клиента:</b>
<input class="new_kvitancy" type="tel" required pattern="[0-9]{10}" title="Формат: 0967775522 без пробелов и дефисов" id="phone" name="phone" maxlength="10"/>

<b>E-mail:</b>
<input class="new_kvitancy" name="mail" id="mail" type="text" size="50">

</td>
</tr>

<tr>
<td>
<b>Адрес клиента:</b>
<input class="new_kvitancy" name="adres" id="adres" type="text" size="65">
</td>
</tr>

<!--// город-->
<tr>
<td>
<b>Выберите город:</b>
<select name="gorod_id" id="gorod_id" >
  <option value="">--Выбрать город--</option>
   <?
   $service = $filter->select_gorod_name ($_SESSION['gorod_id']);
  
	foreach ($service as $a=>$rowsc)
   {?>
       <option value="<?=$rowsc['gorod_id']?>" selected><?=$rowsc['gorod']?></option>
   <?}
   ?>
</select>
<!--/////// город-->
</td>
</tr>

<tr>
<td>
<b>Откуда узнали?:</b>
<select name="where_id" id="where_id" >
  <option value="">--Выбрать--</option>
   <?
   $wh = $filter->select_where ();
  
	foreach ($wh as $a=>$rowwh)
   {?>
       <option value="<?=$rowwh['id']?>"><?=$rowwh['where']?></option>
   <?}
   ?>
</select>

<b>Был ли аппарат в другом СЦ?:</b>
<select name="another_sc" id="another_sc" >
  <option value="">--Выбрать--</option>

       <option value="1">Да, был</option>
	   <option value="0">Нет, не был</option>
	   

</select>

</td>
</tr>

<tr><td>

<input name="submit" type="submit" class="rc-button rc-button-submit" value="Добавить">


</td></tr>

</form>
</table>
</html>

<?php





//var_dump($_POST);die;

$password = $filter->generateCode();
$login = $filter->generateCode();

if (!empty($_POST['gorod_id'])) {
	
	if (empty($_POST['user_id'])) {
	
$new_user = $new->add_user(
							  $new->clearData($_SESSION['id_sc'], $type="i"),
							  $new->clearData($_POST["fam"]),
							  $new->clearData($_POST["imya"]),
							  $new->clearData($_POST["otch"]),
							  $new->clearData($login),
							  $new->clearData($password),
							  $new->clearData($_POST["mail"]),
							  $new->clearData($_POST["phone"]),
							  $new->clearData($_POST["adres"]),
							  $new->clearData($_POST["id_sc"], $type="i"),
							  $new->clearData($_POST["gorod_id"], $type="i"),
							  $new->clearData(4)
							  );


if ($new_user) {
$max_user = $new->maxid(1);
				}
			}
			else {
			$max_user = $_POST['user_id'];
			
			$new->update_otch ($_POST['user_id'], $_POST['otch']);
			$new->update_tel ($_POST['user_id'], $_POST['phone']);
			$new->update_adres ($_POST['user_id'], $_POST['adres']);
			
			
				}			
$max_kvit = $new->maxid(2);

$new_kvit = $new->add_kvitancy(
								$new->clearData($max_user, $type="i"),
								$new->clearData(++$max_kvit, $type="i"),
								$new->clearData($_POST["id_aparat"], $type="i"),
								$new->clearData($_POST["id_proizvod"], $type="i"),
								$new->clearData($_POST["model"]),
								$new->clearData($_POST["ser_nomer"]),
								'',
								$new->clearData($_POST["id_remonta"], $type="i"),
								$new->clearData($_POST["neispravnost"]),
								$new->clearData($_POST["vid"]),
								$new->clearData($_POST["komplektnost"]),
								'',
								'',
								'',
								'',
								$new->clearData($_POST["id_mechanic"], $type="i"),
								'',
								'',
								'',
								'',
								'',
								'',
								$new->clearData($_POST["primechaniya"]),
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								$new->clearData($_POST["where_id"], $type="i"),
								$new->clearData($_SESSION['id_sc'], $type="i"),
								$new->clearData($_POST['another_sc'], $type="i")
								
								);
					
					
					
					//
					$aparat = $new->id_aparat_to_name2 ($_POST["id_aparat"]);
					$proizvod = $new->id_proizvod_to_name ($_POST["id_proizvod"]);
					$nomer_kvit = $new->clearData($max_kvit, $type="i");
					$model = $_POST["model"];
					$neispravnost = $_POST["neispravnost"];
					
					
					$params = array(
									'aparat' => $aparat,
									'proizvod' => $proizvod,
									'nomer_kvit' => $nomer_kvit,
									'model' => $model,
									'neispravnost' => $neispravnost,
									'blog' => 'true'
									);
$query = http_build_query($params);
$response = file_get_contents('http://technodoctor.kiev.ua/add2blog/index.php?' . $query);
					
					/*
					$pieces_neispravnost = explode(" ",$neispravnost);
					
					$title = 'Ремонт '.$aparat .' '. $proizvod .' '. $model .' '. $pieces_neispravnost[0] .' '. $pieces_neispravnost[1] .' '. $pieces_neispravnost[2];
					
					
					$pic = '<p><img src="/images/blog/'.$nomer_kvit.'.jpg" alt="'.$title.'" /></p>';
					
					//$full_text = $neispravnost . $pic;
					$full_text = $neispravnost;
					
					///
					
					
					
					$db1 = mysql_connect('localhost', 'techn157_tech8', 'chFCs5Yg', 'techn157_tech9');
					mysql_select_db('techn157_tech9', $db1);
					mysql_query("SET NAMES 'utf8'", $db1);
					
			
					
					$res = mysql_query("INSERT INTO jos_content 
(title, introtext, state, sectionid, mask, catid, created,
 created_by, modified, modified_by, checked_out, checked_out_time, publish_up,
 publish_down, version, parentid, ordering, metakey, metadesc, access)
										VALUES
(
 '".$title."',
 '".$full_text."',
 '0',
 '8',
 '0',
 '54',
 '".date("Y-m-d H:i:s")."',
 '109',
 '0000-00-00 00:00:00',
 '0',
 '0',
 '0000-00-00 00:00:00',
 '0000-00-00 00:00:00',
 '0000-00-00 00:00:00',
 '1',
 '0',
 '124',
 'Ремонт ".$aparat.", Сервисный Центр ".$proizvod."',
 'Ремонт ".$proizvod." ".$model." в сервисном центре ТехноДоктор в Киеве. Сервисный Центр ".$proizvod.".',
 '0'
 )", $db1)
 or die(mysql_error());
 
		
			
					
					/// permalink blog

	$max_id = mysql_query ("Select MAX(id) from jos_content", $db1) or die(mysql_error());
	$max_id =	mysql_fetch_row($max_id);
	

	$link = mysql_query ("SELECT permalink from jos_myblog_permalinks WHERE contentid=".$max_id[0]."", $db1) or die(mysql_error());
	$link = mysql_fetch_row($link);
	$link = $link[0];
	
	if (!$link OR empty($link))
	{
		// The permalink might be empty. We need to delete it
		mysql_query("DELETE FROM jos_myblog_permalinks WHERE contentid=".$max_id[0]."", $db1)
 or die(mysql_error());
	
		
		// remove unwatned chars from permalink
			
$link = translit(trim($title));
$link = preg_replace(array('/\'/', '/[^a-zA-Z0-9\-.+]+/', '/(^_|_$)/'), array('', '-', ''), $link);
$link = preg_replace('{-(-)*}', '-', $link);
$link = preg_replace('{^-}', '', $link);
$link = preg_replace('/\s/', '-', $link);
$link	.= '-' . $max_kvit;
$link	.= '.html';
		

			mysql_query("INSERT INTO jos_myblog_permalinks SET permalink='".$link."', contentid=".$max_id[0]."", $db1)
 or die(mysql_error());
		
		}
		
	

///	--.//permalink

// add tags
$select_tag	= mysql_query("SELECT `id` FROM `jos_myblog_categories` WHERE `name`='".$proizvod."'", $db1) or die(mysql_error());
$select_tag = mysql_fetch_row($select_tag);
$select_tag = $select_tag[0];

if ($select_tag !== FALSE) {
mysql_query("INSERT INTO jos_myblog_content_categories SET contentid=".$max_id[0].", category=".$select_tag."", $db1) or die(mysql_error());
}
else {
$tag = $proizvod;
$tag = trim(preg_replace('/[`~!@#$%\^&*\(\)\+=\{\}\[\]|\\<">,\\/\^\*;:\?\'\\\]/', '', $tag));
mysql_query("INSERT INTO jos_myblog_categories SET name=".$tag.", slug=".$tag."", $db1) or die(mysql_error());

$select_tag	= mysql_query("SELECT `id` FROM `jos_myblog_categories` WHERE `name`='".$proizvod."'", $db1) or die(mysql_error());
$select_tag = mysql_fetch_row($select_tag);
$select_tag = $select_tag[0];

if ($select_tag !== FALSE) {
mysql_query("INSERT INTO jos_myblog_content_categories SET contentid=".$max_id[0].", category=".$select_tag."", $db1) or die(mysql_error());
}

}
// --//add tags			
*/	

if ($new_kvit) {
echo "<script language='JavaScript' type='text/javascript'>window.open('print_kvitancy.php?id_kvitancy=".$new_kvit."', 'popup');</script>";	

//echo "<script language='JavaScript' type='text/javascript'>window.location.replace('print_kvitancy.php?nomer_kvitancy=".$max_kvit."')</script>";	
	}
	
}
			
			


	}


else { 
echo "<script language='JavaScript' type='text/javascript'>window.location.replace('login_form.php')</script>";
}


function translit($str) {
    $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
  }


?>