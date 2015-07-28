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

// Подключение к БД.
$db = Connect::getInstance();

if(!empty($_POST['id_aparat'])){
   
   $id_aparat=$_POST['id_aparat'];
   
   $res = sql("SELECT * FROM aparat_p WHERE id_aparat=$id_aparat ORDER by title");
   echo '<option value="" selected>- выбрать -</option>';
   while($row = mysql_fetch_array($res))
        echo "<option value='" . $row['id_aparat_p'] . "'>" . $row['title'] . "</option>\n";
   exit;    
}


function sql($query) {
    $res=mysql_query ( $query );
    if(!$res) die("Запрос:\n".$query."\n");
    return $res;
}

?>