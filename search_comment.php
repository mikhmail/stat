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
//$new = NewKvit::getInstance();
$baza = Baza::getInstance();
$login = Login::getInstance();
$filter = Filter::getInstance();

// проверка авторизации
$auth = $login->auth();
if ($auth == true) {

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
	
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/searchClient.js"></script>

</head>
<h1>Поиск по комментариям</h1>
<body>
<form name="main" id="main" action="<?=$_SERVER['PHP_SELF']?>" method="GET" autocomplete="off">

<div class="table" id="table">

<table align="center" border="1" width="1024">
<tr><td align="right">Вы: <b><?=$_SESSION['login']?></b> <a href="exit.php">Выход</a>      <a href=javascript:window.close()>ЗАКРЫТЬ ОКНО</a></td></tr>

<tr><td>
<input type="text" name="search_comment">
<input type="submit" value="Искать">
Введите что-то для поиска. Вводить можно и слово и число, если ищете чип, то можно вводить, например 001
</td></tr>


<tr><td>
Результаты поиска

<?
if (isset($_GET['search_comment']) and !empty($_GET['search_comment'])) {
//echo $_GET['search_comment'];

$comment = $baza->search_comment ($_GET['search_comment']);
//var_dump($comment);
?>

<ul>
<?
foreach ($comment as $a=>$rowc)
{
echo '<li>' . '<b>';
?><a href="index.php?nomer_kvitancy=<?=$filter->id2nomer($rowc['id_kvitancy'])?>"><?=$filter->id2nomer($rowc['id_kvitancy'])?></a><?

echo  '</b>' . ' ' . $rowc['date'] . ' ' . $rowc['fam'] . ' ' . $rowc['imya'] . ' aka ' . $rowc['login'] . ' пишет: ' . '<font color="#0066CC"><b>' . $rowc['comment'] . '</b></font>' . '</li><br>' ;
}
?>
</ul>

<?}?>
</td></tr>


</table>

</div>
<?}
?>