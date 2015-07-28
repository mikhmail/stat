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

/*
//icq отправяем сообщения по аське.
 include('classes/WebIcqLite.class.php');

    define('UIN', 10355);

    define('PASSWORD', 'vbyxbr17');

    $icq = new WebIcqLite();
	
	
    if($icq->connect(UIN, PASSWORD)){

        $icq->send_message('699699', $me);
		$icq->send_message('472080554', $me);
		$icq->send_message('123459', $me);
		
		
		if ($filter->select_kvit2meh($_POST['nomer_kvitancy']) == 7) {
		$icq->send_message('296021991', $me); // вова
		}
		
		if ($filter->select_kvit2id_meh($_POST['nomer_kvitancy']) == 13) {
		$icq->send_message('171071', $me); // артема 7
		}
		
        $icq->disconnect();
    }
// //icq
*/

}
if (empty($_POST['comment_id']) AND empty($_POST['id_comment'])) {
echo '
<script type="text/javascript">
alert("Нужно написать что-то!!!");
</script>
';
}

if (!empty($_POST['id_comment'])) {
// удаляем коммент..
$dell = $baza->dell_comment ($_POST['id_comment']);
if ($dell) echo 'Удалил! Надо обновить страничку.';
}

?>