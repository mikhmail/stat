<?
// Установка кодировки
header("Content-type:text/html; charset=utf-8");

// Определение путей
set_include_path(get_include_path()
					.PATH_SEPARATOR.'classes');
					
// Автозагрузка классов					
function __autoload($class){
	require_once $class.'.php';
}


# Открытие сессии.
	session_start();

// Подключение к БД.
$db = Connect::getInstance();

//Подгрузка классов
$baza = Baza::getInstance();
$filter = Filter::getInstance();

?>

<?if(!empty($_GET['nomer_kvitancy'])){?>


<!--Запчасти-->

<?
$zp = $baza->show_zapchast($_GET['nomer_kvitancy']);
$zp_count = count($zp);
?>


<a href="parts.php?nomer_kvitancy=<?=$_GET['nomer_kvitancy']?>&id_proizvod=<?=$_GET['id_proizvod']?>&id_aparat=<?=$_GET['id_aparat']?>" target="_blank">+ Заказать новую запчасть</a>


<div id="zakazannie_<?=$_GET['nomer_kvitancy']?>" name="zakazannie__zapchasti">
<?if (count($zp) > 0) {?>
<h3>Заказанные запчасти на эту квитанцию:</h3>
<table>
<tr>
<th><b>Название запчасти</b></th>
<th><b>Кол-во</b></th>
<th><b>Дата заказа</b></th>
<th><b>Ответственный</b></th>
<th><b>Статус</b></th>
</tr>

<?foreach ($zp as $a=>$rowzp) {?>
<tr>
<td><?=$rowzp['aparat_name']?>/<?=$rowzp['title']?>/<?=$rowzp['name_zap']?></td>
<td><?=$rowzp['kolvo']?></td>
<td>
<div style="font-size:x-small; border-bottom: 1px dashed #61B0FF; margin: 1px;">Заказал: <?=$baza->user_id2name($rowzp['user_id'])?></div>
<?=$rowzp['date_zakaz']?>
</td>

<td><? if ($rowzp['id_resp']) echo $baza->user_id2name($rowzp['id_resp']);?></td>
<td>
<?if ($rowzp['status'] == 1) {echo '<p><font color="green">Актуально</font></p>';} else {echo 'Дата покупки: '. $rowzp['date_poluch'] ;}?>
</td>
</tr>
<?}?>
</table>
<?}?>
</div>

<!--//////Запчасти-->

<?}?>