<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
		Кофе-прайс 1.0
	</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link href='http://fonts.googleapis.com/css?family=Istok+Web' rel='stylesheet' type='text/css'>
	
	<style type="text/css">
body {
background-color:fff; /* Фон */
margin:0; 	/* Внешний отступ 0 */
padding:0; 	/* Внутренний отступ 0 */
}

td, th {
padding:5px; /* Внутренний отступ */
background-color:#fff;	/* Фон */
font:8pt 'Verdana';	/* Размер, семейство шрифта */
}

table, tr, td, th {
border:1px solid #EFF1E2; /* Обводка */
border-collapse:collapse; /* Убираем двойные линии */
}

.table {
-webkit-border-radius: 3px; /* Округления */
-moz-border-radius: 3px;	/* Округления */
border-radius:3px;			/* Округления */
display:inline-block;	/* Делаем так, что бы блок обтягивал таблицу */
overflow:hidden; 	/* Убираем все, что не поместилось в блок */
}

table td:nth-child(odd) {
background-color:#fff; /* Цвет фона */
}

td:hover {
background-color:#fff; /* Цвет фона */
}

	</style>
	
	
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>

	
	
	
	<span style="border: 0px none; font-family: LenovoDoBold, 'Arial Black', Gadget, sans-serif; font-style: inherit; font-variant: inherit; font-weight: normal; line-height: 1.28571em; font-size: 1em; vertical-align: baseline; color: #009dd9; outline: none; text-decoration: none; display: block; text-transform: uppercase; margin-left: 0px; margin-right: 0px; margin-top: 0px; margin-bottom: 10px; padding: 0px;">
<img src="http://www.coffee-service.kiev.ua/images/coffee-repair-logo.png">
	СЕРВИСНЫЙ ЦЕНТР <BR> РЕМОНТ, УСТАНОВКА, НАСТРОЙКА, ОБСЛУЖИВАНИЕ КОФЕЙНОГО ОБОРУДОВАНИЯ
	</span>

	
	<img src="http://www.coffee-service.kiev.ua/images/logo.png" width="840" height="16">
	<img src="http://www.coffee-service.kiev.ua/images/logo2.png" width="840" height="16">
<br>
<img src="http://www.coffee-service.kiev.ua/images/address.png" alt="адрес сервисного центра">&emsp;
ул. Артёма 7, оф. 6. &emsp;&bull;&emsp; О.Гончара, 79, оф. 3 &emsp;&bull;&emsp; Пирогова, 2, оф. 96.
<br>		
<img src="http://www.coffee-service.kiev.ua/images/telefon.png" alt="телефон сервисного центра">&emsp;
(044) 360-98-43 &emsp;&bull;&emsp; (050) 96-71-999 &emsp;&bull;&emsp; (067) 90-71-999 &emsp;&bull;&emsp; (063) 33-61-999
	

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
$login = Login::getInstance();

// проверка авторизации
$auth = $login->auth();
if ($auth == true) {?>



<table class="table" border="1">
	<tr>
		<th colspan="2"><b>Услуги</b></th>
		<th colspan="5"><b>Цены</b></th>
		
	</tr>
	<tr>
		<th>Раздел</th>
		<th>Название</th>
		<th>Ремонт домашних-<br> ручных рожковых кофеварок</th>
		<th>Ремонт домашних автомати-<br>ческих эспрессо кофемашин</th>
		<th>Ремонт профе-<br>ссиональных рожковых кофеварок</th>
		<th>Ремонт профе-<br>ссиональных супер-<br>автоматических кофемашин</th>
		<th>При-<br>мечание</th>
		
	</tr>
	

<?
// запрос к базе
$com = mysql_query("SELECT * FROM coffee_price ORDER by id");

	while ( $rowcom = mysql_fetch_array($com)) {?> 
		
	<tr>
		<td><b><?=$rowcom["cat"]?></b></td>
		<td><?=$rowcom["name"]?></td>		
		<td><?=$rowcom["price1"]?></td>
		<td><?=$rowcom["price2"]?></td>
		<td><?=$rowcom["price3"]?></td>
		<td><?=$rowcom["price4"]?></td>
		<td></td>
		
	</tr>


<?}}

else { 
echo "<script language='JavaScript' type='text/javascript'>window.location.replace('login_form.php')</script>";
}

?>
		

