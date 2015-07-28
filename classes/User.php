<?
// Соединение с базой данных
class User {

	static private $_instance;

	private function __construct(){}

	function __destruct(){}
	
	private function __clone(){} // запрещаем клонирование
	
						static function getInstance(){
							if(self::$_instance == NULL)
								self::$_instance = new User();
							return self::$_instance;
						}
	

// показать пользователей админов и  механиков
						function select_users () {
						$sql = Filter::select("SELECT user_id, fam, imya, login FROM users WHERE id_group IN ('1', '2', '3') AND active = 1");
						return $sql;
						}

// вывести пользователя
						function select_user ($user_id) {
						$sql = Filter::select("SELECT * FROM users WHERE user_id = ".$user_id."");
						return $sql;
						}
// показать группы доступа
						function select_groups_dostupa () {
						$sql = Filter::select("SELECT * FROM groups_dostupa");
						return $sql;
}

// удалить пользователя
						function delete_user ($user_id) {
						$sql = mysql_query("DELETE FROM users WHERE user_id=".$user_id."");
						if ($sql) return true;
}


// показать клиентов id_group =4
						function select_client () {
						$sql = Filter::select("SELECT user_id, fam, imya, login FROM users WHERE id_group=4 ORDER BY user_id DESC LIMIT 20");
						return $sql;
						}


// проверкам логина на занятость
function check_user_login($login) {
$sql = Filter::select("SELECT * FROM `users` WHERE `login`='".mysql_escape_string($login)."'");
	if( count($sql) > 0 ) {return false;}
	else return true;
				
}

function update_user ($user_id, $password, $fam, $imya, $otch, $phone, $mail, $adres, $id_sc, $groups_dostupa) {
$sql = mysql_query ("UPDATE users SET
									user_id=$user_id,
									password='$password',
									fam='$fam',
									imya='$imya',
									otch='$otch',
									phone='$phone',
									mail='$mail',
									adres='$adres',
									id_sc=$id_sc,
									id_group=$groups_dostupa
									
								WHERE
									user_id=$user_id
									") or die(mysql_error());

}


function update_settings ($user_id, $password, $fam, $imya, $otch, $phone, $mail, $adres, $id_sc, $groups_dostupa, $id_portret) {
$sql = mysql_query ("UPDATE users SET
									password='$password',
									fam='$fam',
									imya='$imya',
									otch='$otch',
									phone='$phone',
									mail='$mail',
									adres='$adres',
									id_portret=$id_portret
								WHERE
									user_id=$user_id
									") or die(mysql_error());
									return $sql;

}

function update_client ($user_id, $fam, $imya, $otch, $phone, $mail, $adres) {
$sql = mysql_query ("UPDATE users SET
									
									
									fam='$fam',
									imya='$imya',
									otch='$otch',
									phone='$phone',
									mail='$mail',
									adres='$adres'
									
									
								WHERE
									user_id=$user_id
									") or die(mysql_error());

}



function get_id_portret ($user_id) {
$sql = Filter::select("SELECT id_portret FROM users WHERE user_id = $user_id LIMIT 1");
								
			if (count($sql)>=1) {	
				foreach ($sql as $a) {
					return $a['id_portret'];	
			}
	}
}



			
	
}