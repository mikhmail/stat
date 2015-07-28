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

// Авторизация
//$login = Login::getInstance();

//Подгрузка классов
$sklad = Sklad::getInstance();

if (isset($_POST)) {
$rowsklad = $sklad->main_select (
								$_POST['name'],
								$_POST['$id_aparat'],
								$_POST['$id_proizvod'],
								$_POST['$serial'],
								$_POST['$vid'],
								$_POST['nomer_kvitancy'],
								$_POST['update_time'],
								$_POST['user_id'],
								$_POST['date_priemka'],
								$_POST['date_vydachi'],
								$_POST['id_where'],
								$_POST['id_count'],
								$_POST['price'],
								$_POST['id_sost'],
								$_POST['id_aparat_p'],
								$_POST['search_value']
);


if(count($rowsklad) > 0) { ?>

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
			
<?		foreach ($rowsklad as $a=>$row) { ?>

								<tr id="tr_<?=$row['id']?>">	
										
										
										<td><?=$row["name"]?></td>
										<td><?=$row["serial"]?></td>
									
										<td><?=$row["date_priemka"]?></td>
										<td><?=$row["id_count"]?></td>
										<td><?=$row["price"]?></td>
										<td><? if ($row["id_sost"] == 1) {echo 'New';}else echo 'Used'; ?></td>
									
										
										<td>

<input class="" type="button" value="Списать" onclick="spisatSklad('<?=$_POST['nomer_kvitancy']?>','<?=$row['id']?>')" />						
										</td>
										
									
									</tr>
		

<? } ?>
</table>
<?} 
}
else {echo '<p><font color=red>Нет данных</font></p>';}



?>