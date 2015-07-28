<?
// Соединение с базой данных
class Connect{
	private $_info;
	static private $_instance;
	private function __construct(){
		$this->_info = parse_ini_file('config.ini', true);
		// Подключение к БД.
		$db = mysql_connect($this->_info['main']['localhost'], $this->_info['main']['user'], $this->_info['main']['password']) or die('No connect with data base'); 
		//$db = mysql_connect(localhost, techn157_glafira, glafira) or die('No connect with data base'); 
		
		mysql_select_db($this->_info['main']['database'], $db) or die(mysql_error());
		//mysql_select_db(techn157_glafira, $db) or die(mysql_error());
		
		mysql_query("SET NAMES UTF8");
		mysql_query("SET CHARACTER SET UTF8");

	}
	function __destruct(){
		mysql_close();
	}
	private function __clone(){} // запрещаем клонирование
	static function getInstance(){
		if(self::$_instance == NULL)
			self::$_instance = new Connect();
		return self::$_instance;
	}
}