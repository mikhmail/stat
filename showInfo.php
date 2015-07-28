<?
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

//Подгрузка классов
$baza = Baza::getInstance();
$filter = Filter::getInstance();

?>

<?if(!empty($_GET['id_kvitancy']) AND !empty($_GET['user_id'])){

   $vid_remonta = $filter->select_vid_remonta ();
   $service = $filter->select_service ();
   
							
							
   
   $kvitancy = $filter->main_select(
							$date = '',
							$start_date = '',
							$end_date = '',
							$id_mechanic = '',
							$id_aparat = '',
							$id_proizvod = '',
							$id_sost = '',
							$id_sc = '',
							$nomer_kvitancy = '',
							$id_kvitancy = $_GET['id_kvitancy'],
							$search = '',
							$id_resp = '',
							$id_where = '',
							$id_vid_remonta = '',
							$id_group = ''
							);
							
	//var_dump($kvitancy);die;						
   
?>


<!--инфо-->

<ul>
<li>
<INPUT type="button" value="Печать квитанции" onClick="window.open('print_kvitancy.php?id_kvitancy=<?=$_GET['id_kvitancy']?>','Печать квитации №<?=$_GET['id_kvitancy']?>','width=600,left=0,top=100,screenX=0,screenY=100')">
<INPUT type="button" value="Печать чека" onClick="window.open('print_check.php?id_kvitancy=<?=$_GET['id_kvitancy']?>','Печать чека №<?=$_GET['id_kvitancy']?>','width=600,left=0,top=100,screenX=0,screenY=100')">
<INPUT type="button" value="Редактировать квитанцию" onClick="window.open('edit_kvitancy.php?id_kvitancy=<?=$_GET['id_kvitancy']?>','Редактировать квитацию №<?=$_GET['id_kvitancy']?>','width=835,left=0,top=100,screenX=0,screenY=100')">
<INPUT type="button" value="Редактировать клиента <?=$kvitancy[0]['fam']?>" onClick="window.open('edit_client.php?user_id=<?=$_GET['user_id']?>&pokaz','Редактировать клиента №<?=$_GET['user_id']?>','width=835,left=0,top=100,screenX=0,screenY=100')">

</li>
<li><b>Адрес клиента:</b> <?=$kvitancy[0]['adres']?></li>
<li><b>Вид ремонта:</b>
<? //if($kvitancy[0]['id_remonta'] ==1) {echo 'гарантийный';} else echo 'негарантийный';?></li>

<?
//$id_remonta = $filter->select_vid_remont ();

foreach ( $vid_remonta as $a=>$rowidrem)
   
	{
       if($rowidrem['id_remonta'] == $kvitancy[0]['id_remonta']) echo $rowidrem['name_remonta'];
	}

?>
<li><b>Внешний вид аппарата:</b> <?=$kvitancy[0]['vid']?></li>
<li><b>Серийный номер аппарата:</b> <?=$kvitancy[0]['ser_nomer']?></li>
<li><b>Комплектность:</b> <?=$kvitancy[0]['komplektnost']?></li>
<li><b>Приёмка:</b>

<?
  foreach ($service as $a=>$rowsc)
   
	{
       if($rowsc['id_mechanic'] == $kvitancy[0]['id_mechanic']) echo $rowsc['name_mechanic'];
	}
?>
</li>
<li><b>Примечания:</b> <?=$kvitancy[0]['primechaniya']?></li>
<li><b>ID квитанции:</b> <?=$kvitancy[0]['id_kvitancy']?></li>
</ul>

<!--//////инфо-->

<?}?>