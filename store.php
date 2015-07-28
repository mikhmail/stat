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
if ($auth == true AND isset($_SESSION['user_id']) AND ($_SESSION['id_group'] == 1 or $_SESSION['id_group'] == 2 or $_SESSION['id_group'] == 3)) {

//$where = $filter->select_where_teh ();
$where = $sklad->select_where ();

$users = $user_filter->select_users (); //var_dump ($user); die();
$proizvoditel = $filter->select_proizvoditel ();
$apparati = $filter->select_aparat ();
$brand = $filter->select_proizvoditel ();

# Открытие сессии.
		session_start();
		
if (!empty($_POST["id_aparat"])) {

//var_dump($_POST);die;

	$new_kvit = $sklad->add_zapchast (
								$_POST['name'],
								$_POST['id_aparat'],
								$_POST['id_proizvod'],
								$_POST['serial'],
								$_POST['vid'],
								'',
								date('Y-m-d'),
								$_SESSION['user_id'],
								date('Y-m-d'),
								'',
								$_POST['id_where'],
								$_POST['id_count'],
								$_POST['price'],
								$_POST['id_sost'],
								$_POST['id_aparat_p'],
								$_SESSION['user_id'],
								'from store',
								$_POST['model']
								);
								
								$self = $_SERVER['PHP_SELF'];
								$id_aparat = $_POST['id_aparat'];
								$id_proizvod = $_POST['id_proizvod'];
								$id_aparat_p = $_POST['id_aparat_p'];
								$id_where = $_POST['id_where'];
								
								header("Location: $self?id_aparat=$id_aparat&id_proizvod=$id_proizvod&id_aparat_p=$id_aparat_p&id_where=$id_where");exit;
	}
}
		
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


<table>

<tr>
<td align="right"><? print 'Вы: <b>' . $_SESSION['login']; ?></b> <a href="exit.php">Выход</a> <a href=javascript:window.close()>Закрыть окно</a></td>
<tr>
</table>


<a href="#" onclick="anichange(this); return false">+ Добавить новую запчасть на склад</a>

<div class="cat" style="display:none;">
<input class="rc-button-red rc-button-submit" type="button" value="Reset" onclick="window.location.replace('<?=$_SERVER['PHP_SELF']?>')">	


<form name="store" id="store" action="<?=$_SERVER['PHP_SELF']?>" method="POST" autocomplete="off">
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
<select name="id_proizvod" id="id_proizvod">
	<option value="0">--Производитель--</option>
	<?
	
	//var_dump($proizvoditel);die;
	foreach ($proizvoditel as $a=>$rowpr)
   {?>
	   <option value="<?=$rowpr['id_proizvod']?>"><?=$rowpr['name_proizvod']?></option>
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
<select name="id_aparat" id="id_aparat" required>
	<option value="">--Название аппарата--</option>
	<?
	
	//var_dump($apparati);die;
	foreach ($apparati as $a=>$rowap)
   {?>
	   <option value="<?=$rowap['id_aparat']?>"><?=$rowap['aparat_name']?></option>
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
<td><b>Модель:</b></td>
<td><input class="new_kvitancy" name="model" type="text" size="65" placeholder="Например: me301 k001" autocomplete="off" required></td>
</tr>
					

<tr>
<td><b>Выбрать состояние:</b></td>
<td>
<select name="id_sost">
						
						<option value="1" selected="">Новый</option>
						<option value="0">Б.У.</option>
					</select>

</td>
</tr>


<tr>
<td>Введите серийный номер:</td>
<td><input class="new_kvitancy" name="serial" type="text" size="65" placeholder="Ищите номер с пометкой sn или pn" autocomplete="off"></td>
</tr>


<tr>
<td>Опишите внешний вид, видимые дефекты:</td>
<td>
<textarea rows="2" cols="65" name="vid" placeholder="Следы эксплуатации (б.у.): царапины, потертости"></textarea>
</td>
</tr>

<tr>
<td><b>Цена</b></td>
						<td><input required maxlength="5" size="5" name="price" type="number" placeholder="Число в $" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"></td>
						
					</tr>
					
<tr>
<td><b>Количество</b></td>
						<td><input type="text" name="id_count" value="1" required></td>
						
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
       <option value="<?=$rowwhere['id_sc']?>"><?=$rowwhere['name_mechanic']?></option>
   <?}
   ?>
</select>
<!-- ///////Замена места нахождения-->
</td>
</tr>

<tr>
<td><b>Описание запчасти:</b></td>
<td><input id="new_zapchast" name="name" type="text" size="65" placeholder="Тип, цвет, размер, и тд и тп" autocomplete="off" required/></td>
</tr>

<tr><td>

<input name="submit" type="submit" id="submit_store" class="rc-button rc-button-submit" value="Добавить">

</td>
<td></td>
</tr>




</table>
</form>
</div>

<h1>Склад</h1>
<table style="width:100%;">
<form name="search_store" action="<?=$_SERVER['PHP_SELF']?>" method="GET" autocomplete="off">

<input name="search" type="search" value="" placeholder="Поиск по названию запчасти">

<!-- выбор ответственного-->
<select name="user_id" id="">
			<option value="">--ответственный--</option>
			<?
			foreach ($users as $a => $rowuser)
			{?>
			<option value="<?=$rowuser['user_id']?>" <?if($_GET['user_id'] == $rowuser['user_id']) echo 'selected';?>>*<?=$rowuser['login']?>* | <?=$rowuser['fam']?> <?=$rowuser['imya']?></option>
			<?}?>
			
</select>										
<!--////// выбор ответственного-->		

<!-- Замена места нахождения-->
<select name="id_where">
	<option value="">--склад--</option>
   <?
   
  
	foreach ($where as $a=>$rowwhere)
   {?>
       <option value="<?=$rowwhere['id_sc']?>" <? if($_GET["id_where"]==$rowwhere['id_sc']) {echo 'selected';} ?>><?=$rowwhere['name_mechanic']?></option>
   <?}
   ?>
</select>
<!-- ///////Замена места нахождения-->


<!--/фильтр производителя -->
<select name="id_proizvod">
	<option value="">--бренд--</option>
	<?
	
	foreach ($brand as $a=>$rowbr)
   {?>
	   <option value="<?=$rowbr['id_proizvod']?>" <?if($rowbr['id_proizvod'] == $_GET['id_proizvod']) echo 'selected';?>><?=$rowbr['name_proizvod']?></option>
   <?}
	?>
   </select>
<!--/////////фильтр производителя кончился -->



<select name="store_id_aparat" id="store_id_aparat">
	<option value="">--аппарат--</option>
	<?
	
	//var_dump($apparati);die;
	foreach ($apparati as $a=>$rowap)
   {?>
	   <option value="<?=$rowap['id_aparat']?>" <? if($_GET["store_id_aparat"]==$rowap['id_aparat']) {echo 'selected';} ?>><?=$rowap['aparat_name']?></option>
   <?}
	?>
   </select>
   
   <select name="store_id_aparat_p" id="store_id_aparat_p"> 
								<option value="" ></option> 
							</select>
<input name="submit" type="submit" class="rc-button rc-button-submit" value="Показать">
<input class="rc-button-red rc-button-submit" type="button" value="Reset" onclick="window.location.replace('<?=$_SERVER['PHP_SELF']?>')">				
<br>
<?if ($_SESSION['id_group'] == 1) {?>
<a href="save_store.php?save=1&id_aparat=<?=$_GET["store_id_aparat"]?>&id_aparat_p=<?=$_GET["store_id_aparat_p"]?>">Скачать xls</a>
<?}?>
</form>
</table>

<?


			


$query = $sklad->main_select(
								$_GET['name'],
								$_GET['store_id_aparat'],
								$_GET['id_proizvod'],
								$_GET['serial'],
								$_GET['vid'],
								$_GET['nomer_kvitancy'],
								$_GET['update_time'],
								$_GET['user_id'],
								$_GET['date_priemka'],
								$_GET['date_vydachi'],
								$_GET['id_where'],
								$_GET['id_count'],
								$_GET['price'],
								$_GET['id_sost'],
								$_GET['store_id_aparat_p'],
								$_GET['search']
								
);

if ($query) {

//var_dump($query);die;


/* Сортировка масива по аппаратам */	
$row_global = array ();
	foreach ($query as $a=>$row) { //arr63
				$row_global[$row["aparat_name"]][] = $row;
		}
/* Сортировка масива по аппаратам */







} //if ($query)

//var_dump($row_global);die;

?>



<tr> 
		<td>

		<h3 style="color: #3079ed;">Найдено запчастей: <?=count($query)?></h3>
		
<?
if (count($row_global)>=1) {
foreach ($row_global as $aparat_name => $value) { $aparat = $value;
	
/* Сортировка масива по запчастям id_apatat_p */	
$row_zap = array ();

	foreach ($value as $a=>$row45) { //arr45

			$row_zap[$row45["title"]][] = $row45;

	}
/* Сортировка масива по запчастям id_apatat_p */

//var_dump($row_zap);die;

?> 



<div style="width:100%; text-align: left; float: left; margin-left: 100px;">	
	<a href="#" onclick="anichange(this); return false"><h3><span>+</span><?=$aparat_name?><font color="red"><sup><?=count($value)?></sup></font></h3></a>
										
			<div class="cat" style="display:none;">
				<? foreach ($row_zap as $title => $value2) { ?>
					<ul>
						<li style="list-style-type: none;">
					<a href="#" onclick="anichange(this); return false"><span>+</span><b><?=$title?></b><font color="red"><sup><?=count($value2)?></sup></font></a>
						<div class="cat" style="display:none;">
									<table>
									<tr>
										<th>Название</th>
										<!--<th>Аппарат</th>
										<th>Бренд</th>-->
										<th>Описание</th>
										
										<th>s/n</th>
										<th>Состояние</th>
										<th>НаВид</th>
										
										<th>Дата приема</th>
										
										<th>Кол-во</th>
										<th>Цена, $</th>
										
									
										<th>Склад</th>
										<th>Кто ответственный</th>
										<th>Опции</th>
										
									</tr>
						
						<? foreach ($value2 as $key => $row) { //var_dump($row);die;?>
									<tr id="tr_<?=$row['id']?>">	
										
										<td><?=$aparat_name?>/<?=$row["name_proizvod"]?>/<?=$row["model"]?>/<b><?=$title?></b></td>
										<!--
										<td><?=$aparat_name?></td>
										<td><?=$row["name_proizvod"]?></td>
										-->
										<td><?=$row["name"]?></td>
										
										<td><?=$row["serial"]?></td>
										<td><? if ($row["id_sost"] == 1) {echo 'New';}else echo 'Used'; ?></td>
										<td><?=$row["vid"]?></td>
										
										<td>
										
										<div style="font-size:x-small; border-bottom: 1px dashed #61B0FF; margin: 1px;">Заказал: <?=$baza->user_id2name($row['user_id'])?></div>
										<?=$row["date_priemka"]?>
										<?if ($row['id_from']) {?>
										<div style="font-size:x-small; border-top: 1px dashed #61B0FF; margin: 1px;">Откуда: <?=$row['id_from']?></div>
										<?}?>
										</td>
										<td><?=$row["id_count"]?></td>
										<td><?=$row["price"]?></td>
										
									
										<!--<td><?=$row["name_where"]?></td>-->
										<td>
<!-- Замена места нахождения-->
<select id="store_id_where_<?=$row['id']?>" name="<?=$row['id']?>" title="<?=$_SESSION['user_id']?>">
	<option value="">--выбрать склад--</option>
   <?
   
  
	foreach ($where as $a=>$rowwhere)
   {?>
       <option value="<?=$rowwhere['id_sc']?>" <? if($row["id_where"]==$rowwhere['id_sc']) {echo 'selected';} ?>><?=$rowwhere['name_mechanic']?></option>
   <?}
   ?>
</select>
<!-- ///////Замена места нахождения-->										
										</td>
										<!--<td>by <?=$row ["login"]?></td>-->
										<td>
<!-- выбор ответственного-->
<select name="<?=$row['id']?>" id="id_resp_store_<?=$row['id']?>" title="<?=$_SESSION['user_id']?>" <?if ($_SESSION['id_group'] != 1) {echo 'disabled';}?>>
			<option value="">--Ответственный--</option>
			<?
			foreach ($users as $a => $rowuser)
			{?>
			<option value="<?=$rowuser['user_id']?>" <?if($row['id_resp'] == $rowuser['user_id']) echo 'selected';?>>*<?=$rowuser['login']?>* | <?=$rowuser['fam']?> <?=$rowuser['imya']?></option>
			<?}?>
			
</select>										
<!--////// выбор ответственного-->


										</td>
										<td>
<input id="id_kvit_<?=$row['id']?>" type="text" placeholder="под что списать?"/>
<input class="" type="button" value="Списать" onclick="spisatStore('<?=$row['id']?>', '<?=$_SESSION['user_id']?>')" /><br>
<input class="" type="button" value="Удалить" onclick="DeleteFromStore('<?=$row['id']?>', '<?=$_SESSION['user_id']?>', '<?=$row["name_proizvod"]?>/<?=$aparat_name?>/<?=$title?>/<?=$row["name"]?>')" <?if ($_SESSION['id_group'] != 1) {echo 'disabled';}?>/>
<input class="" type="button" value="Редактировать" onclick="window.open('edit_store.php?id=<?=$row['id']?>')" <?if ($_SESSION['id_group'] != 1) {echo 'disabled';}?>/>

<? if(!empty($row['update_user'])) {?>
<div style="font-size:x-small; border-top: 1px dashed #61B0FF; margin: 1px;">
						Обновлено: <?=$row["update_time"]?> by

			<?foreach ($users as $a => $rowuser)
			{?>
			<?if($row['update_user'] == $rowuser['user_id']) echo  $rowuser['login'];
			}?>
						
									</div>
<?}?>									

							
										</td>
										
									
									</tr>
							<?}?></table></div>
						</li>
					</ul>
			<?}?></div>
		</div>
	<?}?>
<?}?>

					
</body>
</html>