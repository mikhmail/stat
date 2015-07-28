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
$filter = Filter::getInstance();

if (!empty($_POST['comment_id'])) {

$me = str_replace("smile", "<img src=\"/images/smile.png\" alt=\"smile\"/>", $_POST['comment_id']);
$me = str_replace("angry", "<img src=\"/images/angry.png\" alt=\"smile\"/>", $_POST['comment_id']);

$me = nl2br($me);

// Добавляем коммент..
$baza->add_comment ($me, $_POST['user_id'], $_POST['id_kvitancy']);



// выводим последний коммент в браузере - через аджакс.
echo $baza->lastComm($_POST['id_kvitancy']);

// узнаем имя пользователя по его айди
$user = $baza->user_id2name($_POST['user_id']);

$aparat_name;
$name_proizvod;
$model;

// узнаем аппарат и модель по айди_квитанции
$app_arr = $filter->id2model($_POST['id_kvitancy']);
foreach ($app_arr as $a=>$rowapp) {

$aparat_name = $rowapp['aparat_name'];
$name_proizvod = $rowapp['name_proizvod'];
$model = $rowapp['model'];
}
$text = $user.' | '.$_POST['nomer_kvitancy'] .' | '.$aparat_name .' '. $name_proizvod .' '. $model .' | '. $_POST['comment_id'];

$me = iconv("UTF-8", "CP1251", $text);


}

if (!empty($_POST['id_comment'])) {
// удаляем коммент..
$dell = $baza->dell_comment ($_POST['id_comment']);
if ($dell) echo 'Удалил! Надо обновить страничку.';
}


if(!empty($_POST['show_comments'])){
   
   $comment = $baza->select_comment ($_POST['id_kvitancy']);
	   
	   $ret = '<ul>';
	   
		if (count($comment) > 0) {
			foreach ($comment as $a=>$rowc)
			{
				 $ret .= '<li id=li_' . $rowc['id_comment'] . '>' . $rowc['date'] . ' ' . $rowc['fam'] . ' ' . $rowc['imya'] . ' aka ' . $rowc['login'] . ' пишет: ' . '<br><font color="#0066CC"><b>' . $rowc['comment'] . '</b></font>';
					if ($rowc['user_id'] == $_SESSION['user_id'])
	
						{
						$ret .= '<input type="button" value="Удалить" onclick="destroy('.$rowc['id_comment'].')">';
						}
	
			$ret .= '</li>' ;
			}
	}
	
	$ret .= '</ul>';
	
	$ret .= '<textarea cols="60" rows="3" id="comment_'.$_POST['id_kvitancy'].'" name="comment" ></textarea><br>';
	$ret .= '<input type="button" value="Добавить комментарий" onclick="AddComment('.trim($_POST['id_kvitancy']).', '.$_POST['id_kvitancy'].', '.trim($_SESSION['user_id']).', '.$_POST['id_kvitancy'].')">';

	
	echo $ret;   
	   
   exit;    
}

?>