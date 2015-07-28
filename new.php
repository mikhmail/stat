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
if ($auth == true) {

# Открытие сессии.
		session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Login Box HTML Code - www.PSDGraphics.com</title>

<link href="login-box.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/searchClient.js"></script>


<script type="text/javascript">
  function go(addr) {
    window.open(addr,"add", "menubar=yes,width=640,height=480");
  }
</script>


</head>

<body>


<div style="padding: 0px 0 0 250px;">
Вы: <b><?=$_SESSION['login']?></b> <a href="exit.php">Выход</a>      <a href=javascript:window.close()>ЗАКРЫТЬ ОКНО</a>

<div id="login-box">

<H2>НОВАЯ КВИТАНЦИЯ</H2>

<form name="main" id="main" action="<?=$_SERVER['PHP_SELF']?>" method="POST" autocomplete="off">

<br />
<br />
<div id="login-box-name" style="margin-top:20px;">Выберите аппарат из списка:</div>



<!--/фильтр аппаратов -->
<select name="id_aparat" id="id_aparat">
	<option value="">--Название аппарата--</option>
	<?
	$apparati = $filter->select_aparat ();
	foreach ($apparati as $a=>$rowap)
   {?>
	   <option value="<?=$rowap['id_aparat']?>" <?if($rowap['id_aparat'] == $_GET['id_aparat']) echo 'selected';?>><?=$rowap['aparat_name']?></option>
   <?}
	?>
   </select>
<a href="" class="btn-slide">+</a>
<span id="panel">
<input name="add_aparat_name" id="add_aparat_name" type="text">
<input name="submit" id="add_aparat" type="button" value="Добавить аппарат">
</span>
<br>
<!--/////////фильтр аппаратов кончился -->

<!--/фильтр производителя -->
<select name="id_proizvod" id="id_proizvod">
	<option value="">--Производитель--</option>
	<?
	$apparati = $filter->select_proizvoditel ();
	foreach ($apparati as $a=>$rowap)
   {?>
	   <option value="<?=$rowap['id_proizvod']?>"><?=$rowap['name_proizvod']?></option>
   <?}
	?>
   </select>
<a href="" class="btn-slide">+</a>
<span id="panel">
<input name="add_proizvod_name" id="add_proizvod_name" type="text">
<input name="submit" id="add_proizvod" type="button" value="Добавить бренд">
</span>
<!--/////////фильтр производителя кончился -->


<tr>
<td><b>Введите модель аппарата:</b></td>
<td><input name="model" type="text" size="65"></td>
</tr>

<tr>
<td><b>Введите серийный номер аппарата:</b></td>
<td><input name="ser_nomer" type="text" size="65"></td>
</tr>

<tr>
<!--фильтр ремонта -->
<td><b>Выберите вид ремонта:</b></td>
<td>
<select name="id_remonta">
	<option value="">--Вид ремонта--</option>
	<option value="2" selected>Не гарантийный</option>
	<option value="1">Гарантийный</option>
</select>
</td>
<!--/////////фильтр ремонта кончился -->
</tr>

<tr>
<td><b>Заявленная клиентом неисправность:</b></td>
<td>
<textarea rows="2" cols="65" name="neispravnost">Не работает...</textarea>
</td>
</tr>

<tr>
<td><b>Опишите внешний вид аппарата, видимые дефекты:</b></td>
<td>
<textarea rows="2" cols="65" name="vid">Следы эксплуатации: царапины, потёртости, б/у</textarea>
</td>
</tr>

<tr>
<td><b>Укажите комплектность:</b></td>
<td>
<textarea rows="1" cols="65" name="komplektnost">Без упаковки, без блока питания</textarea>
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
	$id_m = $filter->select_id_sc ($_SESSION['id_sc']);
    $service = $filter->select_service_new ($id_m);
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
<td><b>Есть что добавить? Напишите примечание:</b></td>
<td>
<textarea rows="1" cols="65" name="primechaniya"></textarea>
</td>
</tr>

</table>
<br>
<table align="center" border="1" width="1024">
<tr>

<td><b>Фамилия:</b>
<input name="fam1" type="text" id="search_box" autocomplete="off" size="30">

<b>Имя:</b>
<input name="imya" type="text" autocomplete="off" size="30">

<b>Отчество:</b>
<input name="otch" type="text" autocomplete="off" size="40">

</td>
</tr>

<tr>
<td>

<b>Номер телефона клиента:</b>
<input name="phone" type="text" size="50">

<b>E-mail:</b>
<input name="mail" type="text" size="50">

</td>
</tr>

<tr>
<td>
<b>Адрес клиента:</b>
<input name="adres" type="text" size="65">
</td>
</tr>

<!--// город-->
<tr>
<td>
<b>Выберите город:</b>
<select name="gorod_id">
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

<tr><td><input name="submit" type="submit" value="Добавить"></td></tr>

</form>






<!--



<input name="q" class="form-login" title="Username" value="" size="30" maxlength="2048" /></div>
<div id="login-box-name">Password:</div><div id="login-box-field"><input name="q" type="password" class="form-login" title="Password" value="" size="30" maxlength="2048" /></div>
<br />



<span class="login-box-options"><input type="checkbox" name="1" value="1"> Remember Me <a href="#" style="margin-left:30px;">Forgot password?</a></span>



<br />
<br />




<a href="#"><img src="images/login-btn.png" width="103" height="42" style="margin-left:90px;" /></a>






</div>

</div>
-->












</body>
</html>
</table>
</html>
<div id="search_advice_wrapper"></div>

<?php

if ( isset( $_GET['fam'] )  )
{
    $sql = $db->query( "Select *  From users u INNER JOIN goroda g ON u.gorod_id=g.gorod_id where fam like '".$_GET['fam']."%' order by fam asc" );
    $count = $db->num_rows( $sql );
    if ( $count != 0 )
    {
        $div = "\r\n<div  style='position:absolute; background:#fff; overflow:auto; height:99px; width:688px; z-index:1; margin-top:-21px; margin-left:160px; border:1px solid #5aa8cc; border-radius: 6px; -webkit-border-radius: 6px; -moz-border-radius: 6px; padding:6px; ' id='divUser' >\r\n\r\n<div  style='position:relative; cursor:pointer; color:#def0f8; font:bold 16px Arial; height:15px; width:46px; z-index:2; margin:2px 0 -15px 598px; border:0px solid red; text-shadow:#162b35 2px 2px 3px;' onclick=\"document.getElementById('divUser').style.display='none';\">закрыть</div>\r\n<ul class='".__FILE__."'>";
        while ( $row9 = $db->get_row( $sql ) )
        {
            $div .= "<li style='padding:8px 0 0 0; cursor:pointer; height:14px; font-size:12px;' onclick='zapisat(".$row9['user_id'].")' >&nbsp;".$row9['fam']." ".$row9['imya']." ".$row9['otch'].", г.".$row9['gorod'].", ".$row9['adres'].", тел.".$row9['phone']."&nbsp;</li>";
        }
        $div .= "</ul></div>";
        echo $div;
    }
}

$password = $filter->generateCode();
$login = $filter->generateCode();

if (!empty($_POST['gorod_id'])) {
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
								''
								);
					}
				}
			
if ($new_kvit) {
echo "<script language='JavaScript' type='text/javascript'>window.open('print_kvitancy.php?nomer_kvitancy=".$max_kvit."', 'popup');</script>";	

//echo "<script language='JavaScript' type='text/javascript'>window.location.replace('print_kvitancy.php?nomer_kvitancy=".$max_kvit."')</script>";	
	}
	
}
else { 
echo "<script language='JavaScript' type='text/javascript'>window.location.replace('login_form.php')</script>";
}
?>