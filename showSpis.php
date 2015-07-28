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
$sklad = Sklad::getInstance();
//$filter = Filter::getInstance();

?>

<?if( !empty($_GET['nomer_kvitancy']) ){

$spis = $sklad->search_zapchast($_GET['nomer_kvitancy']);   
?>


<!--списаные запчасти-->

<?
if (count($spis) > 0) {
?>
<h4>Списанные запчасти на эту (№ <?=$_GET['nomer_kvitancy']?>) квитанцию:</h4>

							<table>
									<tr>
									
										<th>Название</th>
										<th>s/n</th>
									
										<th>Дата</th>
										<th>Кол-во</th>
										<th>Цена, $</th>
										<th>Состояние</th>
									
										
										<th>Опции</th>
										
									</tr>

<? foreach ($spis as $a=>$rows) { ?>
									<tr>	
										<td>
										<div style="font-size:x-small; border-bottom: 1px dashed #61B0FF; margin: 1px;">
										Добавлен: <?=$rows["date_priemka"]?> by <? $user=$sklad->user_id2name ($rows["user_id"]); if($user) echo $user[0]["login"];?>
										
										
										<?if ($rows['id_from']) {?>
										<?=$rows['id_from']?>
										<?}?>
										</div>
										<?=$rows['aparat_name']?>/<?=$rows['title']?>/<?=$rows["name"]?>
										<div style="font-size:x-small; border-top: 1px dashed #61B0FF; margin: 1px;">
										Списан: <?=$rows["update_time"]?> by <? $user=$sklad->user_id2name ($rows["update_user"]); if($user) echo $user[0]["login"];?>
										</div>
										</td>
										<td><?=$rows["serial"]?></td>
									
										<td><?=$rows["date_priemka"]?></td>
										<td><?=$rows["id_count"]?></td>
										<td><?=$rows["price"]?></td>
										<td><? if ($rows["id_sost"] == 1) {echo 'New';}else echo 'Used'; ?></td>
									
									
										<td>

<input type="button" value="Вернуть на склад" onclick="vernutSklad('<?=$_GET['nomer_kvitancy']?>','<?=$rows["id"]?>', '<?=$_SESSION['user_id']?>')" />
										</td>
									</tr>


	<?}?>
	</table>
<?} ?>


<a href="store.php" target="_blank">+Поиск запчасти на складе</a>
<!--//////списаные запчасти-->

<?}?>