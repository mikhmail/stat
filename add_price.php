<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
		Вбивала v.1.0
	</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link href='http://fonts.googleapis.com/css?family=Istok+Web' rel='stylesheet' type='text/css'>
	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/functions.js"></script>

<script language="javascript">



function checkedForm(form){
// проверка полей формы
if(sklad.name.value==""){
alert('Не выбран имя!');
sklad.vendor.focus();
return false;
	};
	
if(sklad.cat.value==""){
alert('Не заполнено раздел!');
sklad.name.focus();
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
<form name="sklad" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
				

				<table border="1">
				<tr><h2>Добавить запись</h2></tr>
					<tr>
						<td>Название</td>
						<td><input type="text" name="name" size="100"></td>
					</tr>
					
						<td>Раздел</td>
					
						<td><input type="text" name="cat" size="60"></td>
					
					</tr>
					<tr>
						<td>цена1</td>
						<td><input type="text" name="price1"></td>
					</tr>
					
					<tr>
						<td>цена2</td>
						<td><input type="text" name="price2"></td>
						
					</tr>
					
					<tr>
						<td>цена2</td>
						<td><input type="text" name="price3"></td>
						
					</tr>
					
					<tr>
						<td>цена2</td>
						<td><input type="text" name="price4"></td>
						
					</tr>
					
							
					</tr>
					
				</table>
				<input type="submit" name="new" value="Добавить">
			</form>



<table border="1">
<tr>
		<td><b>Тип</td>
		<td><b>Название</td>
		<td><b>домашних ручных рожковых кофеварок</td>
		<td><b>домашних автоматических эспрессо кофемашин</td>
		<td><b>профессиональных рожковых кофеварок</td>
		<td><b>профессиональных суперавтоматических кофемашин</td>
	
</tr>
<?



//var_dump($_POST);die;

// запрос к базе
$com = mysql_query("SELECT * FROM coffee_price ORDER BY id");


list($tot) = mysql_fetch_row(mysql_query('SELECT FOUND_ROWS()'));
echo "
<tr>
<td>
Найдено: <b>$tot</b> записей
</td>
</tr>
"
;

			
			while ( $rowcom = mysql_fetch_array($com)) {?>
		
		
	
	<tr>
		<td><b><?=$rowcom["cat"]?></b></td>
		<td><?=$rowcom["name"]?></td>
		
		<td><?=$rowcom["price1"]?></td>
		<td><?=$rowcom["price2"]?></td>
		<td><?=$rowcom["price3"]?></td>
		<td><?=$rowcom["price4"]?></td>
	</tr>
	
		<? 
	
		}?>
</table>		
<?php
$time=date("Y-m-d");



// добавить новый чип
if($_POST['name'] AND $_POST['cat']) { 
$rez = mysql_query ("INSERT INTO coffee_price (cat, name, price1, price2, price3, price4) VALUES ('".trim($_POST['cat'])."', '".trim($_POST['name'])."', '".trim($_POST['price1'])."', '".trim($_POST['price2'])."', '".trim($_POST['price3'])."', '".trim($_POST['price4'])."') ") or die(mysql_error());

//var_dump($_POST);die;
}





if($rez or $rez2 or $rez3 or $rez4 or $rez5 == true or $rez6 == true) {
echo "<script language='JavaScript' type='text/javascript'>window.location.replace('".$_SERVER['PHP_SELF']."')</script>";
}

}

else { 
echo "<script language='JavaScript' type='text/javascript'>window.location.replace('login_form.php')</script>";
}

?>
		

