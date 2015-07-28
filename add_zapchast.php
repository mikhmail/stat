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
$login = Login::getInstance();

//Подгрузка классов
$baza = Baza::getInstance();
$sklad = Sklad::getInstance();
// НАДО ДАРАБОТАТЬ ЭТИ ИФЫ.........



if (!empty($_POST["name"]))  {

//var_dump($_POST);die;

	$status = $sklad->add_zapchast (
								mysql_real_escape_string(trim(htmlspecialchars($_POST["name"]))),
								$_POST['id_aparat'],
								$_POST['id_proizvod'],
								'',
								'',
								'',
								date('Y-m-d'),
								$_SESSION['user_id'],
								date('Y-m-d'),
								'',
								$_POST['id_where'],
								$_POST['kolvo'],
								$_POST['price'],
								$_POST['id_sost'],
								$_POST['id_aparat_p'],
								$_SESSION['user_id'],
								'from zapchasti #'.$_POST['id_zap'],
								$_POST['model']
								
	);
	
	$sklad->changeStatusZapchast($_POST['id_zap']);
	
if ($status) {echo $status;}
}



if (isset($_POST["name_zap"]) AND !empty($_POST["id_aparat"]) AND !empty($_POST["id_aparat_p"]) AND !empty($_POST["id_proizvod"])) {

$add_zapchast = $baza->add_zapchast (	$_POST["id_sc"],
										mysql_real_escape_string(trim(htmlspecialchars($_POST["name_zap"]))),
										$_POST["kolvo"],
										$_POST["nomer_kvitancy"],
										$_POST["user_id"],
										$_POST["id_aparat"],
										$_POST["id_aparat_p"],
										$_POST["id_proizvod"],
										mysql_real_escape_string(trim(htmlspecialchars($_POST["model"])))
										
									);


if ($add_zapchast) {

$spis = $baza->show_zapchast($_POST['nomer_kvitancy']);

$rez ='
<h3>Заказанные запчасти на эту квитанцию:</h3>
<table>
<tr>
<th><b>Название запчасти</b></th>
<th><b>Кол-во</b></th>
<th><b>Дата заказа</b></th>
<th><b>Заказчик</b></th>
<th><b>Статус</b></th>
</tr>
';
foreach ($spis as $a=>$rows) {
		if ($rows['status'] == '1') {$rows['status'] = '<p><font color=green>Актуально</font></p>';} else $rows['status'] = 'Купили.';
$rez .= '
<tr>
<td>'.$rows['name_zap'].'</td>
<td>'.$rows['kolvo'].'</td>
<td>'.$rows['date_zakaz'].'</td>
<td>'.$baza->user_id2name($rows['user_id']).'</td>
<td>'.$rows['status'].'</td>
</tr>';
				}
$rez .= '</table>';

echo $rez;
	} 
}else {echo 'false';}
if (isset($_POST["id_razdel"]) AND empty($_POST["id_razdel"])) {echo 'Надо выбрать раздел!';} 


?>