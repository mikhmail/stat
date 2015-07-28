<?php

		class NewKvit {
			
			static private $_instance;
				private function __clone(){} // запрещаем клонирование
					static function getInstance(){
						if(self::$_instance == NULL)
							self::$_instance = new NewKvit();
			return self::$_instance;
	}


private function __construct(){}

function __destruct(){}

	
	
	// Фильтрация данных

			public function clearData($data, $type="s"){
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

// Select MAX(ID) from user
public function maxid ($what){
	if ($what == 1) {
		$rez = mysql_query ("Select MAX(user_id) from users") or die(mysql_error());
						}
	else
		$rez = mysql_query ("Select MAX(nomer_kvitancy) from kvitancy") or die(mysql_error());

			$rez =	mysql_fetch_row($rez);
return $rez[0];
}


// из id_apparat 2 apparat_name
public function id_aparat_to_name ($id_aparat) {
$sql = Filter::select("SELECT aparat_name FROM aparaty WHERE id_aparat='".mysql_escape_string($id_aparat)."' LIMIT 1" );
 foreach ($sql as $arr) {
 return $arr["aparat_name"];
 }
}

// из id_apparat 2 apparat_name2
public function id_aparat_to_name2 ($id_aparat) {
$sql = Filter::select("SELECT aparat_name2 FROM aparaty WHERE id_aparat=$id_aparat LIMIT 1" );
 foreach ($sql as $arr) {
 return $arr["aparat_name2"];
 }
}


// из id_proizvod 2 name_proizvod
public function id_proizvod_to_name ($id_proizvod) {
$sql = Filter::select("SELECT name_proizvod FROM proizvoditel WHERE id_proizvod=$id_proizvod LIMIT 1");
 foreach ($sql as $arr) {
 return $arr["name_proizvod"];
 }
}

// обновить отчество клиента

function update_otch ($user_id, $otch) {
$sql = mysql_query ("UPDATE users SET otch='".$otch."' WHERE user_id=$user_id") or die(mysql_error());

}


// обновить телефон клиента
function update_tel ($user_id, $phone) {
$sql = mysql_query ("UPDATE users SET phone='".$phone."' WHERE user_id=$user_id") or die(mysql_error());

}

// обновить адрес клиента
function update_adres ($user_id, $adres) {
$sql = mysql_query ("UPDATE users SET adres='".$adres."' WHERE user_id=$user_id") or die(mysql_error());

}

	
// добавить пользователя
public function add_user (
							$id_sc,
							$fam,
							$imya,
							$otch,
							$login,
							$password,
							$mail,
							$phone,
							$adres,
							$zavod,
							$gorod_id,
							$id_group
						)
						{
$rez = mysql_query("INSERT INTO users (
							id_sc,
							fam,
							imya,
							otch,
							login,
							password,
							mail,
							phone,
							adres,
							zavod,
							gorod_id,
							id_group,
							active)
							
							VALUES (
							   $id_sc,
							'".$fam."',
							'".$imya."',
							'".$otch."',
							'".$login."',
							'".$password."',
							'".$mail."',
							'".$phone."',
							'".$adres."',
							'".$zavod."',
							   $gorod_id,
							   $id_group,
							   1
							)") or die(mysql_error());
				if ($rez) return true;
}


// добавить квитанцию
public function add_kvitancy (
								$user_id,
								$nomer_kvitancy,
								$id_aparat,
								$id_proizvod,
								$model,
								$ser_nomer,
								$date_prodag,
								$id_remonta,
								$neispravnost,
								$vid,
								$komplektnost,
								$date_priemka,
								$date_okonchan,
								$date_vydachi,
								$id_sost,
								$id_mechanic,
								$show_main_admin,
								$show_main_manag,
								$date_zakaza,
								$date_poluch,
								$full_cost,
								$id_kurs,
								$primechaniya,
								$id_avtoriz_price,
								$ind_price,
								$wprice,
								$mehanic,
								$comments,
								$update_time,
								$update_user,
								$remont,
								$whereid,
								$where_id,
								$another_sc
								)
{

if ($another_sc == 1) $primechaniya .= ' __Аппарат был в другом СЦ';

$sql = mysql_query("INSERT INTO kvitancy (
								user_id,
								nomer_kvitancy,
								id_aparat,
								id_proizvod,
								model,
								ser_nomer,
								date_prodag,
								id_remonta,
								neispravnost,
								vid,
								komplektnost,
								date_priemka,
								date_okonchan,
								date_vydachi,
								id_sost,
								id_mechanic,
								show_main_admin,
								show_main_manag,
								date_zakaza,
								date_poluch,
								full_cost,
								id_kurs,
								primechaniya,
								id_avtoriz_price,
								ind_price,
								wprice,
								mehanic,
								comments,
								update_time,
								update_user,
								remont,
								whereid,
								id_where
										)
							
							VALUES (
							    $user_id,
								$nomer_kvitancy,
								$id_aparat,
								$id_proizvod,
								'".$model."',
								'".$ser_nomer."',
								'".date("Y-m-d")."',
								$id_remonta,
								'".$neispravnost."',
								'".$vid."',
								'".$komplektnost."',
								'".date("Y-m-d")."',
								'0000-00-00',
								'0000-00-00',
								'1',
								$id_mechanic,
								'0',
								'0',
								'0000-00-00',
								'0000-00-00',
								'0.00',
								'1',
								'".$primechaniya."',
								'1',
								'0.00',
								'',
								'0',
								'',
								'',
								'',
								'0',
								$whereid,
								$where_id
							)") or die(mysql_error());
if ($sql) return mysql_insert_id();
}


// редактировать квитанцию
public function edit_kvitancy (
								$id_kvitancy,
								$id_aparat,
								$id_proizvod,
								$model,
								$ser_nomer,
								$id_remonta,
								$neispravnost,
								$vid,
								$komplektnost,
								$primechaniya,
								$id_mechanic
								)
{
$sql = mysql_query("UPDATE kvitancy SET
								id_aparat=		$id_aparat,
								id_proizvod=	$id_proizvod,
								model=			'".$model."',
								ser_nomer=		'".$ser_nomer."',
								id_remonta=		$id_remonta,
								neispravnost=	'".$neispravnost."',
								vid=			'".$vid."',
								komplektnost=	'".$komplektnost."',
								primechaniya=	'".$primechaniya."',
								id_mechanic=	$id_mechanic
					WHERE
								id_kvitancy=$id_kvitancy
										")
or die(mysql_error());

}

// проверкам аппарат на занятость
function check_app($app) {
$sql = Filter::select("SELECT aparat_name FROM aparaty WHERE aparat_name='".mysql_escape_string($app)."'");
	if( count($sql) > 0 ) {return false;}
	else return true;
				
}

// добавить аппарат
public function add_apparat ($aparat_name) {
$add = mysql_query("INSERT INTO aparaty (aparat_name) VALUES ('".$aparat_name."')") or die(mysql_error());
	if ($add) {
		if ($add) return mysql_insert_id();
		}
}

// проверкам аппарат_p на занятость
function check_aparat_p($app, $id_aparat) {
$sql = Filter::select("SELECT title FROM aparat_p WHERE id_aparat=$id_aparat AND title LIKE '%".mysql_escape_string($app)."%'");
	if( count($sql) > 0 ) {return false;}
	else return true;
				
}

// добавить аппарат_p
public function add_aparat_p ($aparat_name, $id_aparat) {
$add = mysql_query("INSERT INTO aparat_p (title, id_aparat) VALUES ('".$aparat_name."', $id_aparat)") or die(mysql_error());
	if ($add) return mysql_insert_id();
		/*
		{
		$rez = mysql_query ("Select MAX(id_aparat_p) from aparat_p") or die(mysql_error());
			$rez =	mysql_fetch_row($rez);
				return $rez[0];
		}
		*/
}


// проверка производителя на занятость
function check_proizvod($app) {
$sql = Filter::select("SELECT name_proizvod FROM proizvoditel WHERE name_proizvod='".mysql_escape_string($app)."'");
	if( count($sql) > 0 ) {return false;}
	else return true;
}

			
// добавить производителя
public function add_proizvod ($aparat_name) {
$add = mysql_query("INSERT INTO proizvoditel (name_proizvod) VALUES ('".$aparat_name."')") or die(mysql_error());
	if ($add) {
		if ($add) return mysql_insert_id();
		}
}



}

?>