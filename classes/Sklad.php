<?php
			class Sklad {
				static private $_instance;
								private function __clone(){} // запрещаем клонирование
									static function getInstance(){
										if(self::$_instance == NULL)
											self::$_instance = new Sklad();
							return self::$_instance;
					}


			private function __construct(){}

			function __destruct(){}
			
			
	public function main_select(
								$name,
								$id_aparat,
								$id_proizvod,
								$serial,
								$vid,
								$nomer_kvitancy,
								$update_time,
								$user_id,
								$date_priemka,
								$date_vydachi,
								$id_where,
								$id_count,
								$price,
								$id_sost,
								$id_aparat_p,
								$search,
								$id=null
							) {
		
		if ($id_where == false) {$sklad = ""; }
	else {$sklad = "AND `store`.`id_where`=".$id_where."";}
		
		if ($id_aparat == false) {$aparat = ""; }
	else {$aparat = "AND `store`.`id_aparat`=".$id_aparat."";}

		if ($id_aparat_p == false) {$aparat_p = ""; }
	else {$aparat_p = "AND `store`.`id_aparat_p`=".$id_aparat_p."";}
	
		if ($user_id == false) {$user = ""; }
	else {$user = "AND `store`.`id_resp`=".$user_id."";}		
	
		if ($id_proizvod == false) {$proizvod = ""; }
	else {$proizvod = "AND `store`.`id_proizvod`=".$id_proizvod."";}
	

	if ($search == false) {$search = ""; }
	else {
	$search = "AND name LIKE '%".strtoupper($search)."%'";
								$aparat = '';
								$aparat_p = '';
								$sklad = '';
								$user = '';
								$proizvod = '';
	}
	
	if ($id == false) {$id = ""; }
	else {
	$id = "AND id = $id";
								$aparat = '';
								$aparat_p = '';
								$sklad = '';
								$user = '';
								$proizvod = '';
								$search = '';
	}
	
	$where = "SELECT * FROM `store`,`aparaty`, `proizvoditel`, `users`, `sost_where`, `aparat_p`
								WHERE `store`.`id_aparat` = `aparaty`.`id_aparat`
								AND `store`.`id_proizvod` = `proizvoditel`.`id_proizvod`
								AND `store`.`user_id` = `users`.`user_id`
								AND `store`.`id_where` = `sost_where`.`id_where`
								AND `store`.`id_aparat_p` = `aparat_p`.`id_aparat_p`
								
								AND `store`.`status` = 1
								
								$aparat
								$aparat_p
								$search
								$sklad
								$user
								$proizvod
								$id
								ORDER BY `aparaty`.`aparat_name`";
								
					//echo $where;die;
	
$sql = $this->select($where);
								return $sql;
	
	}
// Конструктор закончился		

public function select_where () {
$sql = $this->select("SELECT * FROM mechanics ");
return $sql;
}			

public function user_id2name ($user_id) {
	$sql = $this->select("SELECT login FROM `users` WHERE `user_id`='".mysql_escape_string($user_id)."'");
	return $sql;
}
			
// вывод  категорий склада			
public function show_zapchasti () {
$arr = Filter::select("SELECT id, zap_name FROM zapchasti");
return $arr;
}

// вывод склада
public function show_sklad ($vendor, $request) {

if (!empty($request)) {
$request = Filter::clearData($request);
$request = "AND UPPER(name) LIKE '%".strtoupper($request)."%' ";
}
else $request ='';

$vendor = Filter::clearData($vendor);
$vendor = "WHERE vendor='".$vendor."' ";

$arr = Filter::select("SELECT * FROM sklad ".$vendor." ".$request." AND type2 = '0'");
return $arr;
}

// поиск списаного чипа для сохранки
public function search_zapchast ($nomer_kvitancy) {
$arr = Filter::select(
							"SELECT * from `store`, `aparaty`, `proizvoditel`, `users`, `aparat_p`
							 WHERE nomer_kvitancy = ".$nomer_kvitancy."
								AND `store`.`id_aparat` = `aparaty`.`id_aparat`
								AND `store`.`id_proizvod` = `proizvoditel`.`id_proizvod`
								AND `store`.`user_id` = `users`.`user_id`
								AND `store`.`id_aparat_p` = `aparat_p`.`id_aparat_p`
								");
return $arr;
}


public function update_where ( $id, $id_where, $user_id ) {
$time=date("Y-m-d H:i");
$sql = mysql_query ("UPDATE store SET id_where = $id_where, update_time='".$time."', update_user=$user_id WHERE id=$id ") or die(mysql_error());
if($sql) return true;
}

public function spisat ($nomer_kvitancy, $id, $user_id) {
$time=date("Y-m-d H:i");
$sql = mysql_query ("UPDATE store SET nomer_kvitancy=$nomer_kvitancy, update_time='".$time."', update_user=$user_id, date_vydachi='".date("Y-m-d")."', status=0 WHERE id=$id ") or die(mysql_error());
if($sql) return true;
}		


public function delete ($id, $user_id, $reason, $name) {

//echo $name;die;



$time=date("Y-m-d H:i");
$sql = mysql_query ("UPDATE store SET update_time='".$time."', date_vydachi='".date("Y-m-d")."', vid='deleted: ".$reason."', update_user=$user_id, status=0 WHERE id=$id ") or die(mysql_error());

$user_arr = User::select_user ($user_id);
$login = $user_arr[0]['login'];
$fam = $user_arr[0]['fam'];
$imya = $user_arr[0]['imya'];


// Отправляем пароль на mail
		$to = 'mikh.mail@gmail.com,technodoctor@i.ua,leonpro@bigmir.net,4432222@gmail.com,support@tehnodoctor.ua';
		$subject = 'Удалилась запись на складе: ' . $name;
		$message = "
Здравствуйте, админы.

Пользователь: $login => $fam $imya
Удалил запись: '".$name."'
на складе по причине:
'".$reason."'

";
Baza::sendMail('support@technopoisk.com.ua', $to, $subject, $message);


if($sql) return true;
}


// отвецтвенный
public function update_id_responsible ($id_resp, $id, $user_id) {



$time=date("Y-m-d H:i");
$sql = mysql_query ("UPDATE store SET id_resp=$id_resp, update_time='".$time."', update_user=$user_id WHERE id=$id ") or die(mysql_error());

//$subject = 'update_id_responsible: ' . $id;
//$message = "Смена update_id_responsible в складе";
//Baza::sendMail('support@technopoisk.com.ua', 'activex@mail.ru', $subject, $message);

if ($sql) return true;
}

// вернуть на склад
public function vernut ($nomer_kvitancy, $id, $user_id) {
$time=date("Y-m-d H:i");
$sql = mysql_query ("UPDATE store SET nomer_kvitancy=0, update_time='".$time."', update_user=$user_id, date_vydachi='', status=1, id_sost=0 WHERE id=$id ") or die(mysql_error());

if ($sql) return true;
}

// добавить новый чип
public function add_zapchast (
								$name,
								$id_aparat,
								$id_proizvod,
								$serial,
								$vid,
								$nomer_kvitancy,
								$update_time,
								$user_id,
								$date_priemka,
								$date_vydachi,
								$id_where,
								$id_count,
								$price,
								$id_sost,
								$id_aparat_p,
								$id_resp,
								$id_from,
								$model
) {

for ($i=1; $i <= $id_count; $i++) {

$w = "INSERT INTO store (
								name,
								id_aparat,
								id_proizvod,
								serial,
								vid,
								nomer_kvitancy,
								update_time,
								user_id,
								date_priemka,
								date_vydachi,
								id_where,
								id_count,
								price,
								id_sost,
								id_aparat_p,
								id_resp,
								id_from,
								model
										)
								VALUES
								(
								'".mysql_real_escape_string($name)."',
								$id_aparat,
								$id_proizvod,
								'".mysql_real_escape_string($serial)."',
								'".mysql_real_escape_string($vid)."',
								'',
								'".$update_time."',
								$user_id,
								'".$date_priemka."',
								'',
								$id_where,
								1,
								$price,
								$id_sost,
								$id_aparat_p,
								$id_resp,
								'".mysql_real_escape_string($id_from)."',
								'".mysql_real_escape_string($model)."'
								
								)
					";
					//echo $w;die;
 
$rez = mysql_query ($w) or die(mysql_error());
		}

//if($rez) header("Location: www.google.com");exit;	
}


public function update_store ( 	$id,
								$name,
								$id_aparat,
								$id_proizvod,
								$serial,
								$vid,
								
								$update_time,
								$update_user,
								
								
								
								$id_where,
								
								$price,
								$id_sost,
								$id_aparat_p,
								$model
								
								) {
$time=date("Y-m-d H:i");

$w = "UPDATE store SET
								name = '".mysql_real_escape_string($name)."',
								id_aparat = $id_aparat,
								id_proizvod = $id_proizvod,
								serial = '".mysql_real_escape_string($serial)."',
								vid = '".mysql_real_escape_string($vid)."',
								
								update_time = '".$time."',
								update_user = $update_user,
								
								id_where = $id_where,
								
								price = $price,
								id_sost = $id_sost,
								id_aparat_p = $id_aparat_p,
								model = '".mysql_real_escape_string($model)."'
								WHERE id = $id
								
	";
	//echo $w;die;				
	$rez = mysql_query ($w) or die(mysql_error());
	
if($sql) return true;
}


// поменять статус запчасти на неактивный
function changeStatusZapchast ($id_zap) {
$sql1 = mysql_query ("UPDATE zapchast SET status=0, date_poluch='".date("Y-m-d H:i:s")."' WHERE id_zap=".$id_zap." ") or die(mysql_error());


}

public function clearData($data, $type="s"){
		switch($type){
			case "s":
				$a = trim($data);
				return str_replace('\r\n','<br>',$a);
			case "i":
				return (int)$data;
			case "p":
				$data = str_replace(' ','',$data);
				return (int)$data;
			case "r":
				
				return $data;
		}
	}
	

	public function strip_data($text)
	{
    $quotes = array ("\x27", "\x22", "\x60", "\t", "\n", "\r", "*", "%", "<", ">", "?", "!" );
    //$goodquotes = array ("+", "#" );
    //$repquotes = array ("\+", "\#" );
    $text = trim( strip_tags( $text ) );
    $text = str_replace( $quotes, '', $text );
    //$text = str_replace( $goodquotes, $repquotes, $text );
    //$text = ereg_replace(" +", " ", $text);
            
    return $text;
	}
	
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


	function save_store ($id_aparat = NULL, $id_aparat_p = NULL){

		
		$store = $this->main_select(
								'',
								$id_aparat,
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								'',
								$id_aparat_p,
								''
							);
		
		
	//var_dump($store);die;
	
		/*
		// разкомментируйте строки ниже, если файл не будет загружаться
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		*/
		//стандартный заголовок, которого обычно хватает
		header('Content-Type: text/x-csv; charset=utf-8');
		header("Content-Disposition: attachment;filename=".date("d-m-Y")."-store_".$id_aparat.".xls");

		$csv_output ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="author" content="Andrey" />
		<title>deamur zapishi.net</title>
		</head>
		<body>';
		$csv_output .='<table border="1">
	<tr>
		<th>id</th>
		<th>Аппарат</th>
		<th>Бренд</th>
		<th>Название</th>
		<th>Описание</th>
		<th>S/N</th>
		<th>Вид</th>
		<th>Состояние</th>
		<th>Цена,$</th>
		<th>Дата получения</th>
		<th>Обновлено</th>
		<th>Склад</th>
		
	</tr>';
		foreach($store as $seller){
			$csv_output .='
	<tr>
		<td>'.$seller['id'].'</td>
		<td>'.$seller['aparat_name'].'</td>
		<td>'.$seller['name_proizvod'].'</td>
		<td>'.$seller['title'].'</td>
		<td>'.$seller['name'].'</td>
		<td>'.$seller['serial'].'</td>
		<td>'.$seller['vid'].'</td>
		<td>'.$seller['id_sost'].'</td>
		<td>'.$seller['price'].'</td>
		<td>'.$seller['date_priemka'].'</td>
		<td>'.$seller['update_time'].'</td>
		<td>'.$seller['name_where'].'</td>
		
		
	</tr>';
		}
		$csv_output .= '</table>';
		$csv_output .='</body></html>';
		echo $csv_output;
	}						
			
} //end sklad class