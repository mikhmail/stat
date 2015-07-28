<?php
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

//списуем чип.
if (!empty($_POST['nomer'])) {


$spisat = $sklad->spisat ($_POST['nomer'], $_POST['id'], $_POST['user_id']);



// если чип списался, то выводим его в сохранке..
if ($spisat) { $spis = $sklad->search_zapchast($_POST['nomer']);
?>
								<table>
									<tr>
									
										<th>Название</th>
										<th>s/n</th>
									
										<th>Дата</th>
										<th>Кол-во</th>
										<th>Цена</th>
										<th>Состояние</th>
									
										
										<th>Опции</th>
										
									</tr>
<? foreach ($spis as $a=>$row) { ?>
									<tr>	

										<td><?=$row["name"]?></td>
										<td><?=$row["serial"]?></td>
									
										<td><?=$row["date_priemka"]?></td>
										<td><?=$row["id_count"]?></td>
										<td><?=$row["price"]?></td>
										<td><? if ($row["id_sost"] == 1) {echo 'New';}else echo 'Used'; ?></td>
									
										
										<td>

<input type="button" value="Вернуть на склад" onclick="vernutSklad('<?=$_POST['nomer_kvitancy']?>','<?=$rows["id"]?>')" />					
										</td>
										
									
									</tr>
<?	} ?>
</table>
<?}
}

if (!empty($_POST['delete_it'])) {
//echo $_POST['text'];die;
	echo $delete = $sklad->delete ($_POST['id'], $_POST['user_id'], $_POST['reason'], $_POST['text']);
}
?>