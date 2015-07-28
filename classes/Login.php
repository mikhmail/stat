<?
// Соединение с базой данных
class Login {

	static private $_instance;

	private function __construct(){}

	function __destruct(){}
	
	private function __clone(){} // запрещаем клонирование
	
	static function getInstance(){
		if(self::$_instance == NULL)
			self::$_instance = new Login();
		return self::$_instance;
	}
	
	function auth () {
	
	if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
	{
    $query = mysql_query("SELECT * FROM users WHERE user_id = '".intval($_COOKIE['id'])."' AND id_group IN ( '1', '2', '3' ) AND active = 1 LIMIT 1");
    $userdata = mysql_fetch_assoc($query);

    if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id']))
    {
        setcookie("id", "", time() - 6000*24*30*12, "/");
        setcookie("hash", "", time() - 6000*24*30*12, "/");
		
		//require_once("login_form.php");
		echo "<script language='JavaScript' type='text/javascript'>window.location.replace('login_form.php')</script>";
        exit();
    }
	
	if(($userdata['user_hash'] == $_COOKIE['hash']) and ($userdata['user_id'] == $_COOKIE['id']))
	{
	$_SESSION['user_id'] = $userdata['user_id'];
	$_SESSION['login'] = $userdata['login'];
	$_SESSION['imya'] = $userdata['imya'];
	$_SESSION['otch'] = $userdata['otch'];
	$_SESSION['id_sc'] = $userdata['id_sc'];
	$_SESSION['id_group'] = $userdata['id_group'];
	$_SESSION['gorod_id'] = $userdata['gorod_id'];
	
	
	
	
	// подгружаем саму базу

		
	return true;
	}
	
	}
	
}
	
	
	
}