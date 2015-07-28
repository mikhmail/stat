<?php
		class Baza {
		
		static private $_instance;
		
		private function __clone(){} // запрещаем клонирование
		static function getInstance(){
			if(self::$_instance == NULL)
				self::$_instance = new Baza();
		return self::$_instance;
	}
		

function user_id2id_mechanic ($user_id) {
$sql = Filter::select("SELECT id_mechanic FROM mehanic WHERE `user_id` = ".$user_id." LIMIT 1 ");
								
			if (count($sql)>=1) {	
			foreach ($sql as $a) {
			return $a['id_mechanic'];	
			}
	}
}	



function count_kvitancys ($user_id, $id_group) {

$id_mechanic = $this->user_id2mechanic ($user_id);


switch ($id_group) {
	case 1: // админ  
	  
	break;
	
			case 2: // приемщик
								
			break;
		
						case 3: // инженер  
						  
						break;
}


	switch ($id_mechanic) {

	case 2:
		//echo '<img src="images/figa.png">';
		break;
	case 13:
		echo '<img src="images/star.png">';
		break;
	case 14:
		//echo '<img src="images/figa.png">';
		break;
	default:
		echo "";

	}

}

// гарантийные заяки!!!
function select_warranty_kvitancys() {

$time1 = strtotime("-1 day");
$last_day = date("Y-m-d", $time1);


$time2 = strtotime("-4 week");
$first_day = date("Y-m-d", $time2);

$sql = Filter::select("select nomer_kvitancy, aparat_name, name_proizvod, model
								FROM `kvitancy`,`aparaty`, `proizvoditel`
								WHERE id_remonta = 1
								
								AND `kvitancy`.`id_proizvod` = `proizvoditel`.`id_proizvod`
								AND `kvitancy`.`id_aparat` = `aparaty`.`id_aparat`
								AND date_priemka >='".$first_day."'
								AND date_priemka <= '".$last_day."'
								AND `kvitancy`.`id_sost` IN ( '1', '3', '10', '17' )
								ORDER by nomer_kvitancy DESC
		             ");
		return $sql;
	
}


function get_color ($id_sost) {

	switch ($id_sost) {

	case 1:
		$span = "class=\"vrabote\"";
		break;
	
	
	case 3:
		$span = "class=\"detal\"";
		break;
	
	case 4:
		$span = "class=\"aktspisaniya\"";
		break;
	
	case 5:
		$span = "class=\"bezremonta\"";
		break;
	
	case 6:
		$span = "class=\"gotov\"";
		break;
		
	case 7:
		$span = "class=\"vidansremontom\"";
		break;
		
	case 8:
		$span = "class=\"vidanbezremonta\"";
		break;
	
	case 9:
		$span = "class=\"vikuplen\"";
		break;
	
	
	case 10:
		$span = "class=\"soglasovat\"";
		break;
	
	case 17:
		$span = "class=\"test\"";
		break;
	
	case 18:
		$span = "class=\"soglasovat2\"";
		break;
	
	
	
	default:
		$span = '';

	}
		return $span;

}
		
// показать мои заявки (те что в работу у конкретного инженера который залогин сейчас)
function select_my_kvitancys($user_id) {

$mehanic = $this->user_id2id_mechanic ($user_id);

if ($mehanic) {


$sql = Filter::select("select nomer_kvitancy from kvitancy where mehanic = '".$mehanic."' AND `kvitancy`.`id_sost` IN ( '1', '3', '10', '17', '18' )
		             ");
		return $sql;
	}else return false;
}		

// показать мои заявки (отвецтвенный)
function select_my_kvitancys_resp($user_id) {


if ($user_id) {


//$sql = Filter::select("select nomer_kvitancy, id_sost from kvitancy where id_responsible = '".$user_id."' AND `kvitancy`.`id_sost` IN ( '1', '3', '10', '17', '18' )");

$sql = Filter::select("
					SELECT nomer_kvitancy, id_sost, aparat_name, name_proizvod, model
					FROM
					`kvitancy`,`aparaty`, `proizvoditel`
							  WHERE `kvitancy`.`id_responsible` = $user_id
								AND `kvitancy`.`id_aparat` = `aparaty`.`id_aparat`
								AND `kvitancy`.`id_proizvod` = `proizvoditel`.`id_proizvod`
								AND `kvitancy`.`id_sost` IN ( '1', '3', '10', '17', '18' )
								
						");

		return $sql;
	}else return false;
}		


// показать мои запчачти (отвецтвенный)
function select_my_zap_resp($user_id) {


if ($user_id) {


//$sql = Filter::select("select kuda, name_zap from zapchast where id_resp = $user_id AND status=1");

$sql = Filter::select(
					"SELECT
					*
					FROM
					zapchast, aparaty, aparat_p, proizvoditel 
					WHERE
					id_resp = $user_id
					
					
					
					AND
					zapchast.id_aparat = aparaty.id_aparat
					AND
					zapchast.id_aparat_p = aparat_p.id_aparat_p
					AND
					zapchast.id_proizvod = proizvoditel.id_proizvod
					AND
					zapchast.status=1

					ORDER BY name_zap"
					);

		return $sql;
	}else return false;
}


// показать согласовать
function select_soglasovat($user_id) {


if ($user_id) {

$id_mechanic = $this->user_id2mechanic ($user_id);

//$sql = Filter::select("select nomer_kvitancy from kvitancy where id_mechanic = '".$id_mechanic."' AND `kvitancy`.`id_sost` = 10");

	$sql = Filter::select("
					SELECT nomer_kvitancy, aparat_name, name_proizvod, model
					FROM
					`kvitancy`,`aparaty`, `proizvoditel`
								WHERE `kvitancy`.`id_aparat` = `aparaty`.`id_aparat`
								AND `kvitancy`.`id_proizvod` = `proizvoditel`.`id_proizvod`
								AND id_mechanic = '".$id_mechanic."'
								AND `kvitancy`.`id_sost` = 10
						");
		return $sql;
	}else return false;
}

// показать позвонить
function select_soglasovat2($user_id) {


if ($user_id) {

$id_mechanic = $this->user_id2mechanic ($user_id);

$sql = Filter::select("
					SELECT nomer_kvitancy, aparat_name, name_proizvod, model
					FROM
					`kvitancy`,`aparaty`, `proizvoditel`
								WHERE `kvitancy`.`id_aparat` = `aparaty`.`id_aparat`
								AND `kvitancy`.`id_proizvod` = `proizvoditel`.`id_proizvod`
								AND id_mechanic = '".$id_mechanic."'
								AND `kvitancy`.`id_sost` = 18
						");
		return $sql;
	}else return false;
}

// показать те квиташки в которые никто не писал 3 дня

function select_kvit_3days() {

$time1 = strtotime("-4 day");
$last_day = date("Y-m-d", $time1);


$time2 = strtotime("-8 week");
$first_day = date("Y-m-d", $time2);
/*
$sql1 = Filter::select ("SELECT id_kvitancy
							   FROM
							   kvitancy k
							   WHERE
							   k.date_priemka >=
							'".$first_day."'
							and k.date_priemka <= '".$last_day."'
								and `id_sost` IN ( '1', '3', '4', '5', '6' )
							ORDER by id_kvitancy
							
						");
*/

$sql1 = Filter::select ("SELECT id_kvitancy
							   FROM
							   kvitancy k
							   WHERE
							   k.date_priemka >=
							'".$first_day."'
							and k.date_priemka <= '".$last_day."'
								and `id_sost` IN ( '1', '3', '4', '5', '6' )
							ORDER by id_kvitancy
							
						");

						
$arr1 = array();

if (count($sql1)>=1) {
						
foreach ($sql1 as $rowatt) {
	
	
	
		$sql2 = Filter::select ("SELECT MAX(date) from comments WHERE id_kvitancy = '".$rowatt['id_kvitancy']."'");
	
				foreach ($sql2 as $row7) {
				$maxdate = $row7['MAX(date)'];
				}
	
						if ($maxdate <= $last_day)  {
						$arr1[] = $rowatt['id_kvitancy'];
						}
						
}
	
	
	}
	return $arr1;
	//return $sql2;
	
}//end


// показать те квиташки в которые никто не писал 5 дня

function select_kvit_5days($user_id) {

$id_mechanic = $this->user_id2mechanic ($user_id);

$time1 = strtotime("-3 day");
$last_day = date("Y-m-d", $time1);


$time2 = strtotime("-3 week");
$first_day = date("Y-m-d", $time2);

$sql1 = Filter::select ("SELECT id_kvitancy
							   FROM
							   kvitancy k
							   WHERE
							   k.date_priemka >=
							'".$first_day."'
							and k.date_priemka <= '".$last_day."'
								and `id_sost` IN ( '1', '3', '17' )
								AND id_mechanic = '".$id_mechanic."'
							ORDER by id_kvitancy
							
						");

						
$arr1 = array();

if (count($sql1)>=1) {
						
foreach ($sql1 as $rowatt) {
	
	
	
		$sql2 = Filter::select ("SELECT MAX(date) from comments WHERE id_kvitancy = '".$rowatt['id_kvitancy']."'");
	
				foreach ($sql2 as $row7) {
				$maxdate = $row7['MAX(date)'];
				}
	
						if ($maxdate <= $last_day)  {
						$arr1[] = $rowatt['id_kvitancy'];
						}
						
}
	
	
	}
	return $arr1;
	//return $sql2;
	
}//end


		
// показать тех сохранки в которых нет комментов 3х дневные.
function select_k() {

$time1 = strtotime("-3 day");
$last_day = date("Y-m-d", $time1);


$time2 = strtotime("-3 week");
$first_day = date("Y-m-d", $time2);

$sql1 = Filter::select ("SELECT id_kvitancy
							   FROM
							   kvitancy k
							   WHERE
							   k.date_priemka >=
							'".$first_day."'
							and k.date_priemka <= '".$last_day."'
								and `id_sost` IN ( '1', '3', '4', '5', '6' )
							ORDER by id_kvitancy
							
						");
$arr1 = array();

if(count($sql1) > 0) {

foreach ($sql1 as $rowatt) {
	$data = $rowatt['id_kvitancy'];
	$arr1[] = $data;
	}
	
$max = min($arr1);


$sql2 = Filter::select ("SELECT distinct id_kvitancy
							   FROM
							   comments
							   WHERE
							   id_kvitancy >= ".$max."
							
						ORDER by id_kvitancy");
$arr2 = array();

if(count($sql2) > 0) {

	foreach ($sql2 as $rowatt) {
		$data = $rowatt['id_kvitancy'];
			$arr2[] = $data;
	}
	
	
$arr3 = array_unique($arr2);
	
$new = array_diff($arr1, $arr3);
	


return $new;
}
else return false;
}
else return false;
							
/*
	$sql = Filter::select ("SELECT nomer_kvitancy
							FROM kvitancy k
							WHERE NOT 
							EXISTS
							(
							SELECT id_kvitancy
							FROM comments
							WHERE id_kvitancy = k.id_kvitancy LIMIT 50
							)
							AND k.date_priemka
							BETWEEN  '".$first_day."'
							AND  '".$last_day."' 
							AND `k`.`id_sost` IN ( '1', '3', '4', '5', '6' )
							LIMIT 50
							");
		
		return $sql;

*/

/*
SELECT nomer_kvitancy FROM kvitancy k
LEFT JOIN comments c
ON k.id_kvitancy = c.id_kvitancy
WHERE c.id_kvitancy IS NULL
AND k.date_priemka >=  '".$first_day."'
AND k.date_priemka <= '".$last_day."' 
AND `k`.`id_sost` IN ( '1', '3', '4', '5', '6' )
*/
}

// вывести где нас нашли.
function select_where () {
$sql = Filter::select("SELECT * FROM whereid
		             ");
		return $sql;
}

// Узнать по ID квитанции - номер квитанции
function id2nomer ($id_kvitancy) {
$sql = $this->select("SELECT nomer_kvitancy FROM `kvitancy` WHERE `id_kvitancy` = ".$id_kvitancy." ");
								
								foreach ($sql as $a) {
			return $a['nomer_kvitancy'];	
			}
}


// Добавление устройства в общий прайс
function AddWorkPrice ($name_proizvod, $model, $work_zap, $work_price) {
$sql = mysql_query ("INSERT INTO work_zap VALUES
('', '".date("Y-m-d H:i:s")."', '".$name_proizvod."', '".$model."', '".$work_zap."', '".$work_price."') ") or die(mysql_error());
}

// номера квитанций на согласование.

function soglasovat () {
/*
	$time = strtotime("-8 week");
	$last_day = date("Y-m-d");
	$first_day = date("Y-m-d", $time);

$sql = Filter::select("SELECT nomer_kvitancy FROM kvitancy
						WHERE
						id_sost = 10
						AND
						date_priemka >=  '".$first_day."'
						AND
						date_priemka <= '".$last_day."' 
					") or die(mysql_error());

*/					
	$sql = Filter::select("SELECT nomer_kvitancy FROM kvitancy
						WHERE
						id_sost = 10
					") or die(mysql_error());
				
					
	return $sql;
    }

	
// удалить комментарий

function dell_comment ($id_comment) {
$sql = mysql_query("DELETE from comments WHERE id_comment = ".$id_comment."");
if ($sql) return true;
}

		
// вывестим коментарии...
function select_comment ($id_kvitancy, $count=NULL) {

if ($count) {

$sql = Filter::select("SELECT count(id_comment)
					FROM
					comments
					WHERE
					`comments`.`id_kvitancy` =  ".$id_kvitancy."
					
					ORDER BY DATE DESC ");
		
		
		
		return $sql;

} else {

$sql = Filter::select("SELECT
					`comments`.`id_kvitancy`,
					`comments`.`id_comment`,					
					`comments`.`date`,
					`users`.`user_id`,
					`users`.`fam`,
					`users`.`imya`,
					`users`.`login`,
					`comments`.`comment`
					FROM
					`users` ,  `comments` 
					WHERE
					`comments`.`id_kvitancy` =  ".$id_kvitancy."
					AND
					`comments`.`id_user` =  `users`.`user_id` 
					ORDER BY DATE DESC ");
		return $sql;
}	
}

// поиск в коментарии...
function search_comment ($search) {

$time = strtotime("-12 week");
$day = date("Y-m-d", $time);

$sql = Filter::select("SELECT
					`comments`.`id_kvitancy`,
					`comments`.`date`,
					`users`.`fam`,
					`users`.`imya`,
					`users`.`login`,
					`comments`.`comment`
					FROM
					`users` ,  `comments` 
					WHERE
					upper(`comments`.`comment`) LIKE '%".$search."%'
					AND
					`comments`.`id_user` =  `users`.`user_id` 
					AND `comments`.`date` >=  '".$day."'
					ORDER BY DATE DESC ");
		return $sql;
	
}

// последние коментарии...
function last_comment () {

$time = strtotime("-1 day");
$day = date("Y-m-d", $time);

$sql = Filter::select("SELECT
					`comments`.`id_kvitancy`,
					`comments`.`date`,
					`users`.`fam`,
					`users`.`imya`,
					`users`.`login`,
					`comments`.`comment`
					FROM
					`users` ,  `comments` 
					WHERE
					
					`comments`.`id_user` =  `users`.`user_id` 
					AND `comments`.`date` >  '".$day."'
					ORDER BY DATE DESC ");
		return $sql;
	
}

// вывести последний комментарий
function lastComm($id_kvitancy){
$sql = Filter::select("SELECT
					`comments`.`id_kvitancy`,
					`comments`.`date`,
					`users`.`fam`,
					`users`.`imya`,
					`users`.`login`,
					`comments`.`comment`
					FROM
					`users` ,  `comments` 
					WHERE
					`comments`.`id_kvitancy` =  ".$id_kvitancy."
					AND
					`comments`.`id_user` =  `users`.`user_id` 
					ORDER BY DATE DESC LIMIT 1");
		
foreach ($sql as $a=>$rowc ) {
$rez = "<p><li>".$rowc['date']." ".$rowc['fam']." ".$rowc['imya']." aka ".$rowc['login']." пишет:<br><font color=\"#0066CC\"><b>".$rowc['comment']."</b></font></li></p>";
//$rez = "<p>".$rowc['date']." ".$rowc['fam']." ".$rowc['imya']." aka ".$rowc['login']." пишет:<br><b>".$rowc['comment']."</b></p>";

}
		return $rez;
}


// Добавить примечание
function add_primechaniya ($primechaniya, $id_kvitancy) {
$sql = mysql_query ("UPDATE kvitancy SET
									comments='".$primechaniya."',
									update_time='".date("j-m-Y, H:i:s")."', update_user='".$_SESSION['login']."'
									WHERE
									id_kvitancy=".$id_kvitancy." ")
									or die(mysql_error());
}

// поменять механика
function update_mehanic ($id_meh, $id_kvitancy, $update_user) {
$sql = mysql_query ("UPDATE kvitancy SET mehanic=".$id_meh.", update_time='".date("j-m-Y, H:i:s")."', update_user='".$update_user."' WHERE id_kvitancy=".$id_kvitancy." ") or die(mysql_error());
}

// поменять механика
function update_id_responsible ($id_resp, $id_kvitancy, $update_user) {
$sql = mysql_query ("UPDATE kvitancy SET
									id_responsible='".$id_resp."',
									update_time='".date("j-m-Y, H:i:s")."',
									update_user='".$update_user."'
									WHERE
									id_kvitancy='".$id_kvitancy."'
									") or die(mysql_error());
}



// поменять место нахождения аппарата
function update_where ($id_where, $id_kvitancy) {
$sql = mysql_query ("UPDATE kvitancy SET id_where=".$id_where.", update_time='".date("j-m-Y, H:i:s")."', update_user='".$_SESSION['login']."' WHERE id_kvitancy=".$id_kvitancy." ") or die(mysql_error());
}


// установить время изменения заявки
function update_time ($id_kvitancy) {
$sql = mysql_query ("UPDATE kvitancy SET update_time='".date("j-m-Y, H:i:s")."' WHERE id_kvitancy=".$id_kvitancy." ") or die(mysql_error());
}

// поменять пользователя что поменял значение в заявке
function update_user ($update_user, $id_kvitancy) {
$sql = mysql_query ("UPDATE kvitancy SET update_user='".$update_user."' WHERE id_kvitancy=".$id_kvitancy." ") or die(mysql_error());
}

// добавить комментарий
function add_comment ($comment, $user_id, $id_kvitancy) {
$sql = mysql_query ("INSERT INTO comments VALUES
('', '".date("Y-m-d H:i:s")."', '".$comment."', '".$user_id."', '".$id_kvitancy."', '1', '1', '1', '1') ") or die(mysql_error());
}


function add_sost_remonta ($new_sost) {
$sql = mysql_query ("INSERT INTO sost_remonta VALUES
													('',
													'".$new_sost."'
													) ") or die(mysql_error());
return $sql;
}

// поменять состояние, еще нужно дорабатывать....
function update_sost ($id_sost, $id_kvitancy) {
//$sql = mysql_query ("UPDATE kvitancy SET id_sost=".$id_sost.", date_okonchan='".date("Y-m-j")."' WHERE id_kvitancy=".$id_kvitancy." ") or die(mysql_error()); 

	if ($id_sost == 1) { // в работе
$rezgotov = mysql_query ("UPDATE kvitancy SET update_time='".date("j-m-Y, H:i:s")."', update_user='".$_SESSION['login']."', id_sost=".$id_sost.", date_okonchan='', date_vydachi='' WHERE id_kvitancy=".$id_kvitancy." ") or die(mysql_error()); 
							}
	elseif ($id_sost == 3) { //заказана деталь
$rezgotov = mysql_query ("UPDATE kvitancy SET update_time='".date("j-m-Y, H:i:s")."', update_user='".$_SESSION['login']."', id_sost=".$id_sost.", date_vydachi='', date_okonchan='' WHERE id_kvitancy=".$id_kvitancy." ") or die(mysql_error()); 
							}
	elseif ($id_sost == 4) { //акт списания - голубой (без ремонта)
$rezgotov = mysql_query ("UPDATE kvitancy SET update_time='".date("j-m-Y, H:i:s")."', update_user='".$_SESSION['login']."', id_sost=".$id_sost.", date_okonchan='".date("Y-m-j")."', date_vydachi='' WHERE id_kvitancy=".$id_kvitancy." ") or die(mysql_error()); 
							}
	elseif ($id_sost == 6) { //готов date_vydachi
$rezgotov = mysql_query ("UPDATE kvitancy SET update_time='".date("j-m-Y, H:i:s")."', update_user='".$_SESSION['login']."', id_sost=".$id_sost.", date_okonchan='".date("Y-m-j")."', date_vydachi='' WHERE id_kvitancy=".$id_kvitancy." ") or die(mysql_error()); 
							}
	elseif ($id_sost == 7 or $id_sost == 8 or $id_sost == 9) { //выдан
$rezgotov = mysql_query ("UPDATE kvitancy SET update_time='".date("j-m-Y, H:i:s")."', update_user='".$_SESSION['login']."', id_sost=".$id_sost.", date_vydachi='".date("Y-m-j")."' WHERE id_kvitancy=".$id_kvitancy." ") or die(mysql_error()); 
							}						
elseif ($id_sost == 10) { //ПОЗВОНИТЬ КЛИЕНТУ..!
$rezgotov = mysql_query ("UPDATE kvitancy SET update_time='".date("j-m-Y, H:i:s")."', update_user='".$_SESSION['login']."', id_sost=".$id_sost.", date_vydachi='', date_okonchan='' WHERE id_kvitancy=".$id_kvitancy." ") or die(mysql_error()); 
							}
elseif ($id_sost == 18) { //СОГЛАСОВАТЬ..!
$rezgotov = mysql_query ("UPDATE kvitancy SET update_time='".date("j-m-Y, H:i:s")."', update_user='".$_SESSION['login']."', id_sost=".$id_sost.", date_vydachi='', date_okonchan='' WHERE id_kvitancy=".$id_kvitancy." ") or die(mysql_error()); 
							}

							
elseif ($id_sost == 17) { //наТЕСТе
$rezgotov = mysql_query ("UPDATE kvitancy SET update_time='".date("j-m-Y, H:i:s")."', update_user='".$_SESSION['login']."', id_sost=".$id_sost.", date_vydachi='', date_okonchan='' WHERE id_kvitancy=".$id_kvitancy." ") or die(mysql_error()); 
							}							


}

// добавить запчасть на сохранку
function add_zapchast ($id_sc, $name_zap, $kolvo, $kuda, $user_id, $id_aparat, $id_aparat_p, $id_proizvod, $model) {
$sql = mysql_query ("INSERT INTO zapchast (id_sc, name_zap, kolvo, kuda, status, date_zakaz, user_id, id_aparat, id_aparat_p, id_proizvod, model)
VALUES
($id_sc, '".$name_zap."', $kolvo, $kuda, 1, '".date("Y-m-d H:i:s")."', $user_id, $id_aparat, $id_aparat_p, $id_proizvod, '".$model."') ") or die(mysql_error());
return $sql;
}

// удалить запчасть 
function delete_zapchast ($id_zap) {
//$sql = mysql_query("DELETE from zapchast WHERE id_zap = ".$id_zap."");
$sql = mysql_query("UPDATE zapchast SET status=0, date_poluch='".date("Y-m-d H:i:s")."', istoch='deleted by ".$_SESSION['login']."' WHERE id_zap = ".$id_zap." ");

if ($sql) return true;
}

// показать запчасти заказанные на 1 сохранку
function show_zapchast ($nomer_kvitancy) {
$sql = Filter::select("SELECT * from `zapchast`, `aparaty`, `proizvoditel`, `users`, `aparat_p`
							 WHERE kuda = ".$nomer_kvitancy."
								AND `zapchast`.`id_aparat` = `aparaty`.`id_aparat`
								AND `zapchast`.`id_proizvod` = `proizvoditel`.`id_proizvod`
								AND `zapchast`.`user_id` = `users`.`user_id`
								AND `zapchast`.`id_aparat_p` = `aparat_p`.`id_aparat_p`
								");
return $sql;
}

// показать Все запчасти
function show_zapchasti () {
$sql = Filter::select("SELECT * from zapchast WHERE status=1");
return $sql;
}

// показать Все запчасти новое
function show_zapchasti_new ($id_zakazchik=null, $id_aparat=null, $id_aparat_p=null, $id_proizvod=null) {

if($id_zakazchik) {$id_zakazchik = 'AND zapchast.id_resp = '.$id_zakazchik.'';}
if($id_aparat) {$id_aparat = 'AND aparaty.id_aparat = '.$id_aparat.'';}
if($id_aparat_p) {$id_aparat_p = 'AND aparat_p.id_aparat_p = '.$id_aparat_p.'';}
if($id_proizvod) {$id_proizvod = 'AND proizvoditel.id_proizvod = '.$id_proizvod.'';}




$sql = Filter::select(
					"SELECT
					*
					FROM
					zapchast, aparaty, aparat_p, proizvoditel 
					WHERE
					
					zapchast.status=1
					
					AND
					zapchast.id_aparat = aparaty.id_aparat
					AND
					zapchast.id_aparat_p = aparat_p.id_aparat_p
					AND
					zapchast.id_proizvod = proizvoditel.id_proizvod
					
					
					$id_zakazchik
					$id_aparat
					$id_aparat_p
					$id_proizvod
					ORDER BY name_zap"
					);
return $sql;
}



// показать общий прайс
function show_price ($search) {
$sql = Filter::select("
					SELECT * from work_zap
					WHERE
					upper(`model`) LIKE '%".$search."%'
					");
return $sql;
}




// user_id to login
function user_id2name ($user_id) {
$sql = Filter::select("SELECT login from users WHERE user_id = ".$user_id."");
foreach ($sql as $name) {
$login = $name;
	}
	return $login["login"];
}


// nomer_kvit to id_sost
function nomer_kvit2id_sost ($nomer_kvitancy) {
$sql = Filter::select("SELECT id_sost from kvitancy WHERE nomer_kvitancy = ".$nomer_kvitancy." LIMIT 1");
	foreach ($sql as $name) {
$login = $name;
	}
	return $login["id_sost"];
}


// user_id to id_mechanic real
function user_id2mechanic ($user_id) {

$sql =Filter::select("SELECT id_mechanic from mechanics INNER JOIN users WHERE mechanics.id_sc = users.id_sc AND users.user_id = ".$user_id."");

foreach ($sql as $name) {
$login = $name;
	}
	return $login["id_mechanic"];
}


// поменять статус запчасти на неактивный
function changeStatusZapchast ($id_zap, $price) {
$sql1 = mysql_query ("UPDATE zapchast SET status=0, date_poluch='".date("Y-m-d H:i:s")."' WHERE id_zap=".$id_zap." ") or die(mysql_error());

$sql2 = Filter::select("SELECT * from zapchast WHERE id_zap=$id_zap");
foreach ($sql2 as $a=>$rowzp) {

$rez = mysql_query ("INSERT INTO sklad (name, vendor, type, cost, type2, sost, date, primechanie)
					VALUES
					('".$rowzp['name_zap']."', '".$rowzp['id_razdel']."', '', '".$price."', '0', '1', '".date("Y-m-d H:i:s")."', '') ") or die(mysql_error());
	}
}

	public function sendMail($mailot, $to, $subject, $message, $replyto=''){
					//smtp_mail($to, $subject, $message, $headers = '')
	$headers = "Content-Type: text/plain; charset=utf-8\r\n";
	//$headers='';
	#Адрес сервера
$SmtpServer="ssl://smtp.gmail.com";
#Адрес порта
$SmtpPort="465";
#Логин авторизации на сервера SMTP
$SmtpUser="support@technopoisk.com.ua";
#Пароль авторизации на сервера SMTP
$SmtpPass="technopoisk";

    $recipients = explode(',', $to);
    $user = $SmtpUser;
    $pass = $SmtpPass;
    // The server details that worked for you in the above step
    $smtp_host = $SmtpServer;
    //The port that worked for you in the above step
    $smtp_port = $SmtpPort;
 
    if (!($socket = @fsockopen($smtp_host, $smtp_port, $errno, $errstr, 15)))
    {
      $err = "Не могу соединиться с '$smtp_host' - номер ошибки: ($errno), расшифровка: ($errstr) \r\n \r\n
	  Не смог отправить письмо:\r\n \r\n
	  Кому:($to) \r\n \r\n Тема:($subject) \r\n \r\n Письмо:($message) \r\n \r\n";
	  
	  
	  mail("mikh.mail@gmail.com","Не работает gmail почта на ТехноПоиске","sent from lib.php function sendMail \r\n \r\n $err");
	  mail("technodoctor@i.ua","Не работает gmail почта на ТехноПоиске","sent from lib.php function sendMail \r\n \r\n $err");
	  mail("support@technopoisk.com.ua","Не работает gmail почта на ТехноПоиске","sent from lib.php function sendMail \r\n \r\n $err");
	  
	  $filename = 'email_log';
	  
	  if (is_writable($filename)) {
		$handle = fopen($filename, 'a');
			fwrite($handle, $err);
			}
    
	//echo "<script language='JavaScript' type='text/javascript'>window.open('".$_SERVER['SERVER_NAME']."', 'popup');</script>";
	return false;
	
	}
	else
	{
 
    $this->server_parse($socket, '220');
 
    fwrite($socket, 'EHLO '.$smtp_host."\r\n");
    $this->server_parse($socket, '250');
 
    fwrite($socket, 'AUTH LOGIN'."\r\n");
    $this->server_parse($socket, '334');
 
    fwrite($socket, base64_encode($user)."\r\n");
    $this->server_parse($socket, '334');
 
    fwrite($socket, base64_encode($pass)."\r\n");
    $this->server_parse($socket, '235');
 
    fwrite($socket, 'MAIL FROM: <'.$user.'>'."\r\n");
    $this->server_parse($socket, '250');
 
 
    foreach ($recipients as $email)
    {
        fwrite($socket, 'RCPT TO: <'.$email.'>'."\r\n");
        $this->server_parse($socket, '250');
    }
	

    fwrite($socket, 'DATA'."\r\n");
    $this->server_parse($socket, '354');
	
	if ($replyto) {
	
	$to = 'To: ' .$email;
	
	fwrite($socket, 'Subject: '
      .$subject."\r\n".$to."\r\n".'Return-Path: <'.$replyto.'>'."\r\n".$headers."\r\n\r\n".$message."\r\n");
	  
	}else{
	
	$to = 'To: ' .$email;
	
    fwrite($socket, 'Subject: '
      .$subject."\r\n".$to."\r\n".$headers."\r\n\r\n".$message."\r\n");
	}
	
    fwrite($socket, '.'."\r\n");
    $this->server_parse($socket, '250');
 
    fwrite($socket, 'QUIT'."\r\n");

    fclose($socket);
 
    return true;
	}
}


	//Functin to Processes Server Response Codes
public function server_parse($socket, $expected_response)
{
	$filename = 'email_log';
	
    $server_response = '';
    while (substr($server_response, 3, 1) != ' ')
    {
        if (!($server_response = fgets($socket, 256)))
        {
		if (is_writable($filename)) {
		$handle = fopen($filename, 'a');
			$somecontent = 'Error while fetching server response codes.';
				fwrite($handle, $somecontent);
			}
        }            
    }
 
    if (!(substr($server_response, 0, 3) == $expected_response))
    {
	if (is_writable($filename)) {
		$handle = fopen($filename, 'a');
			$somecontent = 'Unable to send e-mail."'.$server_response.'"';
				fwrite($handle, $somecontent);
			}
	
    }
}


// отвецтвенный
public function update_id_responsible_zap ($id_resp, $id, $user_id) {



$time=date("Y-m-d H:i");
$sql = mysql_query ("UPDATE zapchast SET id_resp=$id_resp, update_time='".$time."', update_user=$user_id WHERE id_zap=$id ") or die(mysql_error());


if ($sql) return true;
}

} //end class baza
?>