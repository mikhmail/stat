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
$filter = Filter::getInstance();
// Авторизация
$login = Login::getInstance();


    // Существует ли строка POST запроса 'queryString'?
    if(isset($_POST['queryString'])) {
        $queryString = $_POST['queryString'];
        // Если длинна строки больше чем 0? Там что то есть
        if(strlen($queryString) > 0) {
        // Запускаем запрос: используем LIKE '$queryString%'
        // Знак процентов(%)это wild-card, в моем примере о странах работает так...
        // $queryString = 'Uni'; если строка запроса начаниется на ...
        // Returned data = 'United States, United Kindom'; должно возвратиться ..
 
        $row = Filter::select( "Select *  From aparaty where aparat_name LIKE UPPER('".$_POST['queryString']."%') order by aparat_name asc" );
        if($row) {
            
		$div = "\r\n<div  style='position:absolute; background:#fff; overflow:auto; height:99px; width:500px; z-index:1; margin-top:7px; margin-left:0px; border:1px solid #5aa8cc; border-radius: 6px; -webkit-border-radius: 6px; -moz-border-radius: 6px; padding:6px; ' id='apparat_box' >\r\n\r\n<div  style='position:relative; cursor:pointer; color:#def0f8; font:bold 16px Arial; height:15px; width:46px; z-index:2; margin:2px 0 -15px 398px; border:0px solid red; text-shadow:#162b35 2px 2px 3px;' onclick=\"document.getElementById('apparat_box').style.display='none';\">закрыть</div>\r\n<ul class='".__FILE__."'>";
        foreach ($row as $a=>$row9)
			{
		
     $div .= '<li style=\'padding:8px 0 0 0; cursor:pointer; height:14px; font-size:12px;\' onclick=\'fill_apparat("'.$row9["id_aparat"].'-'.$row9["aparat_name"].'")\'>
					&nbsp;'.$row9["aparat_name"].' &nbsp;</li>';
        
			}
		$div .= "</ul></div>";
        echo $div;
		
		
        	
        } else {
            echo 'Ничего не найдено...';
        }
    } else {
        // Ничего не делаем.
    } // Это queryString.
} else {
    echo 'There should be no direct access to this script!';
}
 
?>