<?php

class Language {

static private $_instance;
public $word = array();
public $UserLng;

private function __clone(){} // запрещаем клонирование
	static function getInstance($key){
		if(self::$_instance == NULL)
			self::$_instance = new Language($key);
		return self::$_instance;
	}

public function __construct($userLanguage){


    $this->UserLng = $userLanguage;
    //construct lang file
    $langFile = 'lng/'. $this->UserLng . '.ini';
		if(!file_exists($langFile)){
			 $langFile = 'english.ini';
		}

    $this->word = parse_ini_file($langFile);
}


}

?>