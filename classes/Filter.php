<?php
class Filter {

static private 	$_instance;
		public		$id_group;
		public 		$sc;
		public		$pokaz;



private function __clone(){} // запрещаем клонирование
	static function getInstance(){
		if(self::$_instance == NULL)
			self::$_instance = new Filter();
		return self::$_instance;
	}

	

public function __construct () {}
			
public function main_select($_date,
							$_start_date,
							$_end_date,
							$_id_mechanic,
							$_id_aparat,
							$_id_proizvod,
							$_id_sost,
							$_id_sc,
							$_nomer_kvitancy,
							$_id_kvitancy,
							$_search,
							$_id_resp,
							$_id_where,
							$_id_vid_remonta,
							$_id_group
							) {
		


// условие для выборки механиков, апаратов, состояния

if ($_id_where == false) {$id_where = ""; } // где наход техника, в базе квитансу, столбец id_where
	else {$id_where = "AND `kvitancy`.`id_where`=".$_id_where."";}	


if ($_id_mechanic == false) {$id_mechanic = ""; }
	else {$id_mechanic = "AND `kvitancy`.`mehanic`=".$_id_mechanic."";}
	
if ($_id_aparat == false) {$id_aparat = ""; }
	else {$id_aparat = "AND `kvitancy`.`id_aparat`=".$_id_aparat."";}
	
if ($_id_proizvod == false) {$id_proizvod = ""; }
	else {$id_proizvod = "AND `kvitancy`.`id_proizvod`=".$_id_proizvod."";}
	
if ($_id_vid_remonta == false) {$id_vid_remonta = ""; }
	else {$id_vid_remonta = "AND `kvitancy`.`id_remonta`=".$_id_vid_remonta."";}	
	

// условия для выборки даты
//$m='0'. (date('m') - 2);
//$first_day = date('Y') . '-'. $m . '-01';

$s = strtotime('-2 month');
$first_day = date("Y-m-d", $s);


	if ($_date == 'pr') {
		if ($_start_date == true and $_end_date == true) {
			$date = "AND date_priemka between '".$_start_date."' and '".$_end_date."' ";		
}
		elseif ($_start_date == false and $_end_date == true) {
			$date ="AND date_priemka between '".$first_day."' and '".$_end_date."' ";
}		
		elseif ($_start_date == true and $_end_date == false) {
			$date ="AND date_priemka between '".$_start_date."' and '".date("Y-m-d")."' ";
}		
						}
								
								
	elseif ($_date == 'vd') {
	if ($_start_date == true and $_end_date == true) {
			$date = "AND date_vydachi between '".$_start_date."' and '".$_end_date."' ";		
}
		elseif ($_start_date == false and $_end_date == true) {
			$date ="AND date_vydachi between '".$first_day."' and '".$_end_date."' ";
}		
		elseif ($_start_date == true and $_end_date == false) {
			$date ="AND date_vydachi between '".$_start_date."' and '".date("Y-m-d")."' ";
}		
									}
	elseif ($_date == 'ok') {
	$date = "AND date_okonchan between '".$_start_date."' and '".$_end_date."' ";
	
	
							}
														
else
	//$date ="AND date_priemka between '".$first_day."' and '".date("Y-m-d")."' ";
	$date ="";


// условия для выборки приемки
/*
if ( ($_id_sc == false) AND ($_SESSION['id_group'] == 2) ) {


$id_sc = "";

}
	else {
		$id_sc = "AND `kvitancy`.`id_mechanic`=".$_id_sc." ";
		}
*/

switch ($_id_group) {
	case 1: // админ  
	   if ($_id_sc == false) { $id_sc = ""; }
			else { $id_sc = "AND `kvitancy`.`id_mechanic`=".$_id_sc." "; }
	
		if ($_id_resp == false) {$id_resp = ""; }
			else {$id_resp = "AND `kvitancy`.`id_responsible`=".$_id_resp."";}

				if ($_id_sost == false) { $id_sost = "AND `kvitancy`.`id_sost` IN ( '1', '3', '4', '5', '6', '10', '17', '18' ) ";}


	elseif ($_id_sost == '11') {$id_sost = "AND `kvitancy`.`id_sost` IN ( '1', '3', '10', '17', '18' ) ";} // в работе и заказане деталь
		elseif ($_id_sost == '12') {$id_sost = "AND `kvitancy`.`id_sost` IN ( '4', '5', '6' ) ";} // все что на выдаче лежит
			elseif ($_id_sost == '13') {$id_sost = "AND `kvitancy`.`id_sost` IN ( '7', '8', '9' ) ";} // все выдано
				elseif ($_id_sost == '14') {$id_sost = "AND `kvitancy`.`id_sost` IN ( '1', '3', '4', '5', '6', '10', '17', '18' ) ";} // все что в ремонте - выданых нет.
					elseif ($_id_sost == '15') {$id_sost = "AND `kvitancy`.`id_sost` IN ( '1', '3', '4', '5', '6' ) ";}
				else {$id_sost = "AND `kvitancy`.`id_sost`=".$_id_sost."";}

			
	break;
	
		case 2: // приемщик
		 if ($_id_sc) { $id_sc = "AND `kvitancy`.`id_mechanic`=".$_id_sc." "; }
			else {
			
			$this->sc = $this->select_id_sc ($_SESSION['id_sc']);
			
		   if(($_GET) AND empty($_GET["id_sc"])) { $id_sc = ""; }
				
				else { $id_sc = "AND `kvitancy`.`id_mechanic`=".$this->sc." "; }
				}
			if ($_id_resp == false) {$id_resp = ""; }
				else {$id_resp = "AND `kvitancy`.`id_responsible`=".$_id_resp."";}		
				
					
				if ($_id_sost == false) { $id_sost = "AND `kvitancy`.`id_sost` IN ( '1', '3', '4', '5', '6', '10', '17', '18' ) ";}


	elseif ($_id_sost == '11') {$id_sost = "AND `kvitancy`.`id_sost` IN ( '1', '3', '10', '17', '18' ) ";} // в работе и заказане деталь
		elseif ($_id_sost == '12') {$id_sost = "AND `kvitancy`.`id_sost` IN ( '4', '5', '6' ) ";} // все что на выдаче лежит
			elseif ($_id_sost == '13') {$id_sost = "AND `kvitancy`.`id_sost` IN ( '7', '8', '9' ) ";} // все выдано
				elseif ($_id_sost == '14') {$id_sost = "AND `kvitancy`.`id_sost` IN ( '1', '3', '4', '5', '6', '10', '17', '18' ) ";} // все что в ремонте - выданых нет.
					elseif ($_id_sost == '15') {$id_sost = "AND `kvitancy`.`id_sost` IN ( '1', '3', '4', '5', '6' ) ";}
				else {$id_sost = "AND `kvitancy`.`id_sost`=".$_id_sost."";}

					
		break;
	
				case 3: // инженер  
				   if ($_id_sc == false) { $id_sc = ""; }
						else { $id_sc = "AND `kvitancy`.`id_mechanic`=".$_id_sc." "; }
				
				
				 if ($_id_resp) {$id_resp = "AND `kvitancy`.`id_responsible`=".$_id_resp."";}
					else {
							
							if(($_GET) AND empty($_GET["id_resp"])) { $id_resp = ""; }
				
							else {$id_resp = "AND `kvitancy`.`id_responsible`=".$_SESSION['user_id']." ";}	
							}
							
				 if ($_id_sost == false) { $id_sost = "AND `kvitancy`.`id_sost` IN ( '1', '3', '10', '17', '18' ) ";}
				 
						
						//if ($_id_sost == false) {$id_sost = "AND `kvitancy`.`id_sost` IN ( '1', '3', '4', '5', '6', '10', '17', '18' ) ";} // все что в ремонте - выданых нет.

	elseif ($_id_sost == '11') {$id_sost = "AND `kvitancy`.`id_sost` IN ( '1', '3', '10', '17', '18' ) ";} // в работе и заказане деталь
		elseif ($_id_sost == '12') {$id_sost = "AND `kvitancy`.`id_sost` IN ( '4', '5', '6' ) ";} // все что на выдаче лежит
			elseif ($_id_sost == '13') {$id_sost = "AND `kvitancy`.`id_sost` IN ( '7', '8', '9' ) ";} // все выдано
				elseif ($_id_sost == '14') {$id_sost = "AND `kvitancy`.`id_sost` IN ( '1', '3', '4', '5', '6', '10', '17', '18' ) ";} // все что в ремонте - выданых нет.
					elseif ($_id_sost == '15') {$id_sost = "AND `kvitancy`.`id_sost` IN ( '1', '3', '4', '5', '6' ) ";}
				else {$id_sost = "AND `kvitancy`.`id_sost`=".$_id_sost."";}
				break;
}		
// условие

$limit = 'LIMIT 400 ';

		
// условия для выбора заявки
if ($_nomer_kvitancy == false or $_nomer_kvitancy == 'Номер квитанции') {$nomer_kvitancy = "";}
				else {
				/*
				$id_kvitancy ='';
				$nomer_kvitancy = "AND `kvitancy`.`nomer_kvitancy`=".$_nomer_kvitancy." ";
				$date = '';
				$id_mechanic = '';
				$id_aparat = '';
				$id_proizvod = '';
				$id_sost = '';
				$id_sc = '';
				$id_resp = '';
				$id_where = '';
				$id_vid_remonta = '';
				*/
							$date = '';
							$start_date = '';
							$end_date = '';
							$id_mechanic = '';
							$id_aparat = '';
							$id_proizvod = '';
							$id_sost = '';
							$id_sc = '';
							$nomer_kvitancy = "AND `kvitancy`.`nomer_kvitancy`=".$_nomer_kvitancy." ";
							$id_kvitancy = '';
							$search = '';
							$id_resp = '';
							$id_where = '';
							$id_vid_remonta = '';
							$id_group = '';
							$limit = 'LIMIT 1 ';
						}
						
						

// условия для выбора заявки по ID
if ($_id_kvitancy == false ) {$id_kvitancy = "";}
				else {
				
				/*
				$id_kvitancy = "AND `kvitancy`.`id_kvitancy`=".$_id_kvitancy." ";
				$nomer_kvitancy = ''; 
				$date = '';
				$id_mechanic = '';
				$id_aparat = '';
				$id_proizvod = '';
				$id_sost = '';
				$id_sc = '';
				$id_resp = '';
				$id_where = '';
				$id_vid_remonta = '';
				*/
							$date = '';
							$start_date = '';
							$end_date = '';
							$id_mechanic = '';
							$id_aparat = '';
							$id_proizvod = '';
							$id_sost = '';
							$id_sc = '';
							$nomer_kvitancy = '';
							$id_kvitancy = "AND `kvitancy`.`id_kvitancy`=".$_id_kvitancy." ";
							$search = '';
							$id_resp = '';
							$id_where = '';
							$id_vid_remonta = '';
							$id_group = '';
							$limit = 'LIMIT 1 ';
						}
/*						
if ($_SESSION['id_group'] != 1) {

$this->sc = $this->select_id_sc ($_SESSION['id_sc']);

$this->pokaz = "AND `kvitancy`.`id_mechanic`=".$this->sc." ";

//var_dump($this->pokaz);die;

}
else 
*/

$this->pokaz = '';

if ($_search != false) {
				$id_kvitancy = '';
				$nomer_kvitancy = ''; 
				$date = '';
				$id_mechanic = '';
				$id_aparat = '';
				$id_proizvod = '';
				$id_sost = '';
				$id_sc = '';
				$id_resp = '';
				$this->pokaz = '';
				$id_where = '';
				$id_vid_remonta = '';
				
				

//$search = " AND `users`.`fam` LIKE '%".$_search."%' ";

$search = "AND (`users`.`fam` LIKE '%".$_search."%' OR `users`.`phone` LIKE '%".$_search."%' OR `kvitancy`.`model` LIKE '%".$_search."%' OR `kvitancy`.`ser_nomer` LIKE '%".$_search."%')";
				
} else {$search='';}

$where = "SELECT * FROM `kvitancy`,`aparaty`, `proizvoditel`, `users`, `sost_where`
								WHERE `kvitancy`.`id_aparat` = `aparaty`.`id_aparat`
								AND `kvitancy`.`id_proizvod` = `proizvoditel`.`id_proizvod`
								AND `kvitancy`.`user_id` = `users`.`user_id`
								AND `kvitancy`.`id_where` = `sost_where`.`id_where`
								".$date."
								".$id_mechanic."
								".$id_resp."
								".$id_where."
								".$id_aparat."
								".$id_proizvod."
								".$id_sost."
								".$id_sc."
								".$nomer_kvitancy."
								".$id_kvitancy."
								".$this->pokaz."
								".$search."
								".$id_vid_remonta."
								
								ORDER BY id_kvitancy DESC
								".$limit."
								";
//var_dump($where);die;								


$sql = $this->select($where);
								return $sql;
	
	}
// Конструктор закончился


// Узнать по номеру номеру квитанции - аппарат и модель
function nomer2model ($nomer_kvitancy) {
$sql = $this->select("SELECT nomer_kvitancy, aparat_name, name_proizvod, model FROM `kvitancy`,`aparaty`, `proizvoditel`
								WHERE `kvitancy`.`id_aparat` = `aparaty`.`id_aparat`
								AND `kvitancy`.`id_proizvod` = `proizvoditel`.`id_proizvod`
								AND nomer_kvitancy =".$nomer_kvitancy."
								ORDER BY nomer_kvitancy DESC");
								return $sql;
}

// Узнать по ID квитанции - аппарат и модель
function id2model ($id_kvitancy) {
$sql = $this->select("SELECT nomer_kvitancy, aparat_name, name_proizvod, model FROM `kvitancy`,`aparaty`, `proizvoditel`
								WHERE `kvitancy`.`id_aparat` = `aparaty`.`id_aparat`
								AND `kvitancy`.`id_proizvod` = `proizvoditel`.`id_proizvod`
								AND id_kvitancy =".$id_kvitancy."
								ORDER BY nomer_kvitancy DESC");
								return $sql;
}

// Узнать по ID квитанции - номер квитанции
function id2nomer ($id_kvitancy) {
$sql = $this->select("SELECT nomer_kvitancy FROM `kvitancy` WHERE `id_kvitancy` = ".$id_kvitancy." ");
								
								foreach ($sql as $a) {
			return $a['nomer_kvitancy'];	
			}
}



// печать квитации
function print_kvitancy ($id_kvitancy) {

$query = $this->main_select(
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					$id_kvitancy,
					'',
					'',
					'',
					'',
					''
					);
		//var_dump($query);die;

foreach ($query as $a=>$row) {
	 
	 $sc = $this->select_service_centers ($row['id_mechanic']);
			
			foreach ($sc as $v=>$rowsc) {

//var_dump ($row);
//die();
	
	//if($row['id_remonta'] ==1) {$row['id_remonta'] = 'гарантийный';} else $row['id_remonta'] = 'негарантийный';
	
	$id_remonta = $this->select_vid_remont ();

	foreach ($id_remonta as $a=>$rowidrem)
   
	{
       if($rowidrem['id_remonta'] == $row['id_remonta'])
		{ $row['id_remonta'] = $rowidrem['name_remonta']; }
	}

	
	if(($row['id_aparat'] == 32 OR $row['id_aparat'] == 80) AND ($row['id_remonta'] ==1 OR $row['id_remonta'] ==2)) {$htm = 'print_kvitancy_coffee.htm';}
	

	else $htm = 'print_kvitancy.htm';
	
	
	
// меняем в шаблоне значение переменных
$html  = file_get_contents($htm);
$search = array(
				"[name_sc]",
				"[adres_sc]",
				"[phone_sc]",
				"[rab_sc]",
				"[site]",
				"[mail_sc]",
				"[nomer_kvitancy]",
				"[id_aparat]",
				"[id_proizvod]",
				"[model]",
				"[ser_nomer]",
				"[id_remonta]",
				"[date_priemka]",
				"[neispravnost]",
				"[vid]",
				"[komplektnost]",
				"[phone]",
				"[fam]",
				"[imya]",
				"[otch]",
				"[adres]"
				
				
				);
				
$data   = array(
				$rowsc["name_sc"],
				$rowsc["adres_sc"],
				$rowsc["phone_sc"],
				$rowsc["rab_sc"],
				$rowsc["site"],
				$rowsc["mail_sc"],
				$row["nomer_kvitancy"],
				$row["aparat_name"],
				$row["name_proizvod"],
				$row["model"],
				$row["ser_nomer"],
				$row["id_remonta"],
				$row["date_priemka"],
				$row["neispravnost"],
				$row["vid"],
				$row["komplektnost"],
				$row["phone"],
				$row["fam"],
				$row["imya"],
				$row["otch"],
				$row["adres"]
				
				
				);

$newhtml = str_replace($search, $data, $html);
	
	return $newhtml;
		}
	}
}


// печать чека
function print_check ($id_kvitancy) {

$query = $this->main_select(
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					'',
					$id_kvitancy,
					'',
					'',
					'',
					'',
					''

					);

foreach ($query as $a=>$row) {

//var_dump ($row);
//die();
	 
	 $sc = $this->select_service_centers ($row['id_mechanic']);
			
			foreach ($sc as $v=>$rowsc) {

if(($row['id_aparat'] == 32 OR $row['id_aparat'] == 80) AND ($row['id_remonta'] ==4 OR $row['id_remonta'] ==5)) {$htm = 'print_check_viezd.htm';}
	else $htm = 'print_check.htm';
			
			
$id_remonta = $this->select_vid_remont ();
	foreach ($id_remonta as $a=>$rowidrem)
		{
		   if($rowidrem['id_remonta'] == $row['id_remonta'])
			{ $row['id_remonta'] = $rowidrem['name_remonta']; }
		}

	
	
	
	
	
// меняем в шаблоне значение переменных
$html  = file_get_contents($htm);

$search = array(
				"[name_sc]",
				"[adres_sc]",
				"[phone_sc]",
				"[rab_sc]",
				"[site]",
				"[mail_sc]",
				"[nomer_kvitancy]",
				"[id_aparat]",
				"[id_proizvod]",
				"[model]",
				"[ser_nomer]",
				"[id_remonta]",
				"[date_priemka]",
				"[neispravnost]",
				"[vid]",
				"[komplektnost]",
				"[phone]",
				"[fam]",
				"[imya]",
				"[date]",
				"[otch]",
				"[adres]"
				
				);
				
$data   = array(
				$rowsc["name_sc"],
				$rowsc["adres_sc"],
				$rowsc["phone_sc"],
				$rowsc["rab_sc"],
				$rowsc["site"],
				$rowsc["mail_sc"],
				$row["nomer_kvitancy"],
				$row["aparat_name"],
				$row["name_proizvod"],
				$row["model"],
				$row["ser_nomer"],
				$row["id_remonta"],
				$row["date_priemka"],
				$row["neispravnost"],
				$row["vid"],
				$row["komplektnost"],
				$row["phone"],
				$row["fam"],
				$row["imya"],
				date("d-m-Y"),
				$row["otch"],
				$row["adres"]
				
				);

$newhtml = str_replace($search, $data, $html);
	
	return $newhtml;
		}
	}
}


  // id_sc 2 id_mechanisc
function select_id_sc ($id_sc) {
$sql = $this->select("SELECT * FROM mechanics WHERE id_sc = $id_sc");
if ($sql) {
foreach ($sql as $a) {
			return (int)$a['id_mechanic'];	
				}
			}
		}

// nomer_kvitancy 2 id_meh
function select_kvit2id_meh ($nomer_kvitancy) {
$sql = $this->select("SELECT id_mechanic from kvitancy WHERE nomer_kvitancy = ".$nomer_kvitancy."");
foreach ($sql as $a) {
			return $a['id_mechanic'];	
			}
		}

		
// nomer_kvitancy 2 mehanik
function select_kvit2meh ($nomer_kvitancy) {
$sql = $this->select("SELECT mehanic from kvitancy WHERE nomer_kvitancy = ".$nomer_kvitancy."");
foreach ($sql as $a) {
			return $a['mehanic'];	
			}
		}


		
// выбрать сервис
function select_service_centers ($id_sc) {
$sql = $this->select("SELECT * FROM service_centers WHERE id_mechanic = ".$id_sc."");
return $sql;
}


// выбрать вид ремонта
function select_vid_remonta () {
$sql = $this->select("SELECT * FROM vid_remonta");
return $sql;
}



// показать все сервисы
function select_all_service_centers () {
$sql = $this->select("SELECT * FROM service_centers");
return $sql;
}

											
// выбрать приёмку
function select_service () {
$sql = $this->select("SELECT name_mechanic, id_mechanic FROM mechanics ");
return $sql;
		}

// выбрать где наход техника сейчас
function select_where_teh () {
$sql = $this->select("SELECT * FROM sost_where");
return $sql;
		}		
		
// выбрать приёмку - новая заявка
function select_service_new ($id) {
$sql = $this->select("SELECT name_mechanic, id_mechanic FROM mechanics WHERE id_sc = $id");
return $sql;
		}

		
		
// выбрать всех механиков.
function select_mechanic () {
$sql = $this->select("SELECT name_mechanic, id_mechanic FROM mehanic ");
return $sql;
		}

// выбрать аппараты.
function select_aparat () {
$sql = $this->select("SELECT id_aparat, aparat_name FROM aparaty ORDER BY aparat_name ");
return $sql;
}

// выбрать производителя.
function select_proizvoditel () {
$sql = $this->select("SELECT id_proizvod, name_proizvod FROM proizvoditel ORDER BY name_proizvod ");
return $sql;
}

// выбрать производителя.
function select_vid_remont () {
$sql = $this->select("SELECT * FROM vid_remonta ORDER BY id_remonta ");
return $sql;
}


// выбрать состояние.
function select_sost () {
$sql = $this->select("SELECT * FROM sost_remonta ");
return $sql;
}

// выбрать города
function select_city () {
$sql = $this->select("SELECT * FROM goroda ");
return $sql;
		}
		
 // выбрать один город в котором приемщик
function select_gorod_name ($gorod_id) {
$sql = $this->select("SELECT * FROM goroda WHERE gorod_id = ".$gorod_id."");
return $sql;
		}

 // выбрать один город в котором приемщик
function select_where () {
$sql = $this->select("SELECT * FROM where_uznal ORDER by id DESC");
return $sql;
		}

		
// показать нагрузку на все приемки 
function select_load () {
$sql = $this->select("

SELECT COUNT(*) AS cnt,
(SELECT COUNT(*) FROM kvitancy WHERE id_where=1 AND id_sost IN ( '1', '3', '10', '17', '18' )) AS gonchara79,

(SELECT COUNT(*) FROM kvitancy WHERE id_where=9 AND id_sost IN ( '1', '3', '10', '17', '18' )) AS artema7,

(SELECT COUNT(*) FROM kvitancy WHERE id_where=10 AND id_sost IN ( '1', '3', '10', '17', '18' )) AS pirogova2

FROM kvitancy

");
return $sql;
		}		

		
// показать число приемок за сегодня
function select_today () {
$sql = $this->select("SELECT id_kvitancy FROM kvitancy WHERE date_priemka='".date("Y-m-d")."'");
return count($sql);
		}

// показать число приемок за сегодня у всех
function select_today_all () {
$sql = $this->select("

SELECT COUNT(*) AS cnt,
(SELECT COUNT(*) FROM kvitancy WHERE date_priemka='".date("Y-m-d")."') AS cnt_0,
(SELECT COUNT(*) FROM kvitancy WHERE id_mechanic=2 AND date_priemka='".date("Y-m-d")."') AS cnt_1,
(SELECT COUNT(*) FROM kvitancy WHERE id_mechanic=13 AND date_priemka='".date("Y-m-d")."') AS cnt_2,
(SELECT COUNT(*) FROM kvitancy WHERE id_mechanic=14 AND date_priemka='".date("Y-m-d")."') AS cnt_3
FROM kvitancy

");
return $sql;
		}
		

// показать число приемок за сегодня artema7
function select_today_artema () {
$sql = $this->select("SELECT id_kvitancy FROM kvitancy WHERE id_mechanic=13 AND date_priemka='".date("Y-m-d")."'");
return count($sql);
		}		


// показать число приемок за сегодня gonchara79
function select_today_gonchara () {
$sql = $this->select("SELECT id_kvitancy FROM kvitancy WHERE id_mechanic=2 AND date_priemka='".date("Y-m-d")."'");
return count($sql);
		}


// показать число приемок за сегодня pirogova2
function select_today_pirogova () {
$sql = $this->select("SELECT id_kvitancy FROM kvitancy WHERE id_mechanic=14 AND date_priemka='".date("Y-m-d")."'");
return count($sql);
		}		
		
// показать число приемок за месяц
function select_month () {
$first_day = date('Y') . '-'. date('m') . '-1';
$sql = $this->select("SELECT id_kvitancy FROM kvitancy WHERE date_priemka between '".$first_day."' and '".date("Y-m-d")."'");
return count($sql);
		}


// показать число приемок за месяц у всех
function select_month_all () {
$first_day = date('Y') . '-'. date('m') . '-1';

$sql = $this->select("
SELECT COUNT(*) AS cnt,
(SELECT COUNT(*) FROM kvitancy WHERE date_priemka between '".$first_day."' and '".date("Y-m-d")."') AS cnt_0,
(SELECT COUNT(*) FROM kvitancy WHERE id_mechanic=2 AND date_priemka between '".$first_day."' and '".date("Y-m-d")."') AS cnt_1,
(SELECT COUNT(*) FROM kvitancy WHERE id_mechanic=13 AND date_priemka between '".$first_day."' and '".date("Y-m-d")."') AS cnt_2,
(SELECT COUNT(*) FROM kvitancy WHERE id_mechanic=14 AND date_priemka between '".$first_day."' and '".date("Y-m-d")."') AS cnt_3
FROM kvitancy
");


return $sql;
		}

		
// показать число приемок за месяц технодоктор
function select_techno() {
$first_day = date('Y') . '-'. date('m') . '-1';
$sql = $this->select("SELECT id_kvitancy FROM kvitancy WHERE id_mechanic = 2 AND date_priemka between '".$first_day."' and '".date("Y-m-d")."'");
return count($sql);
		}

		
// показать число приемок за месяц артема7
function select_artema() {
$first_day = date('Y') . '-'. date('m') . '-1';
$sql = $this->select("SELECT id_kvitancy FROM kvitancy WHERE id_mechanic = 13 AND date_priemka between '".$first_day."' and '".date("Y-m-d")."'");
return count($sql);
		}

		
		
// показать число приемок за месяц пирогова2
function select_pirogova() {
$first_day = date('Y') . '-'. date('m') . '-1';
$sql = $this->select("SELECT id_kvitancy FROM kvitancy WHERE id_mechanic = 14 AND date_priemka between '".$first_day."' and '".date("Y-m-d")."'");
return count($sql);
		}


// показать число приемок сегодня технодоктор
function select_today_techno() {

$sql = $this->select("SELECT id_kvitancy FROM kvitancy WHERE id_mechanic = 2 AND date_priemka between '".$first_day."' and '".date("Y-m-d")."'");
return count($sql);
		}

		


	
	

/*
// показать пользователей админов и менеджеров и механиков
function select_users () {
$sql = $this->select("SELECT user_id, fam, imya, login FROM users WHERE id_group IN ('1', '2')");
return $sql;
}

// вывести пользователя
function select_user ($user_id) {
$sql = $this->select("SELECT * FROM users WHERE user_id = ".$user_id."");
return $sql;
}
*/

		
// помощник работы с базой
					public static function Select($query) {
							$result = mysql_query($query);
							
							if (!$result)
								die(mysql_error());
							if(($num_rows =  mysql_num_rows($result)) > 0) {
							$n = mysql_num_rows($result);
							$arr = array();
						
							for($i = 0; $i < $n; $i++)
							{
								$row = mysql_fetch_assoc($result);		
								$arr[] = $row;
							}

							return $arr;				
						} 
						}
// Фильтрация данных

				function clearData($data, $type="s"){
					switch($type){
						case "s":
							$a = mysql_real_escape_string(trim(htmlspecialchars($data)));
							return str_replace('\r\n','<br>',$a);
						case "i":
							return (int)$data;
						case "p":
							$data = str_replace(' ','',$data);
							return (int)$data;
					}
				}

	// Функция для генерации случайной строки
	function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];  
    }
    return $code;
	}
	
	// функция превода текста с кириллицы в траскрипт
  function translit($st)
  {
    // Сначала заменяем "односимвольные" фонемы.
    $st=strtr($st,"абвгдеёзийклмнопрстуфхъыэ_",
    "abvgdeeziyklmnoprstufh'iei");
    $st=strtr($st,"АБВГДЕЁЗИЙКЛМНОПРСТУФХЪЫЭ_",
    "ABVGDEEZIYKLMNOPRSTUFH'IEI");
    // Затем - "многосимвольные".
    $st=strtr($st, 
                    array(
                        "ж"=>"zh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", 
                        "щ"=>"shch","ь"=>"", "ю"=>"yu", "я"=>"ya",
                        "Ж"=>"ZH", "Ц"=>"TS", "Ч"=>"CH", "Ш"=>"SH", 
                        "Щ"=>"SHCH","Ь"=>"", "Ю"=>"YU", "Я"=>"YA",
                        "ї"=>"i", "Ї"=>"Yi", "є"=>"ie", "Є"=>"Ye"
                        )
             );
    // Возвращаем результат.
    return $st;
  }

	
}
