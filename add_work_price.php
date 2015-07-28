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

// НАДО ДАРАБОТАТЬ ЭТИ ИФЫ.........



if (!empty($_POST["work_zap"]) AND !empty($_POST["work_price"])) {

	$status = $baza->AddWorkPrice($_POST['name_proizvod'], $_POST['model'], $_POST['work_zap'], $_POST['work_price']);
		
		if ($status) {echo 'yes';}
}

else {
echo 'no';
}



?>