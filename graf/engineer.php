<?php



//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//error_reporting(E_ALL);


/*
// Подключение к БД.
$db1 = mysql_connect('localhost', 'techn157_glafira', 'glafira', 'techn157_glafira');
					mysql_select_db('techn157_glafira', $db1);
					mysql_query("SET NAMES 'utf8'", $db1);
					

// Подключение к БД.
$db1 = mysql_connect('localhost', 'root', '', 'glafira');
					mysql_select_db('glafira', $db1);
					mysql_query("SET NAMES 'utf8'", $db1);
*/
$info = parse_ini_file('../config.ini', true);
		// Подключение к БД.
		$db = mysql_connect($info['main']['localhost'], $info['main']['user'], $info['main']['password']) or die('No connect with data base'); 
		
		mysql_select_db($info['main']['database'], $db) or die(mysql_error());
		
		mysql_query("SET NAMES UTF8");
		mysql_query("SET CHARACTER SET UTF8");		






if (isset($_GET['id'])) $id_resp = $_GET['id'];



					
//SELECT COUNT(`whereid`)FROM `kvitancy` WHERE whereid=1


$result = mysql_query("SELECT name_mechanic, user_id FROM mehanic");

if (!$result) die(mysql_error());
								
							if(($num_rows =  mysql_num_rows($result)) > 0) {
							$n = mysql_num_rows($result);
							$arr = array();
						
							for($i = 0; $i < $n; $i++)
							{
								$row = mysql_fetch_assoc($result);		
								$arr[] = $row;
							}
						}

foreach ($arr as $arr2) {
	//var_dump($arr2);
	//echo $arr2["name_mechanic"] . ' = ' . $arr2["user_id"];
						
$id_resp = $arr2["user_id"];


$a1 = (mysql_fetch_array(mysql_query("SELECT COUNT(`id_kvitancy`)FROM `kvitancy` WHERE id_responsible=$id_resp AND id_sost IN ( '2', '6', '7' )"), MYSQL_NUM));

$a2 = (mysql_fetch_array(mysql_query("SELECT COUNT(`id_kvitancy`)FROM `kvitancy` WHERE id_responsible=$id_resp AND id_sost IN ( '4', '8', '9' )"), MYSQL_NUM));




//echo $a1[0];die;

$data_array = array($a1[0], $a2[0]);


$where_uznal = array (
"С ремонтом " . $a1[0],
"без ремонта ". $a2[0]

);				
					

 // Standard inclusions     
 include("pChart/pData.class");  
 include("pChart/pChart.class");  
  
 // Dataset definition   
 $DataSet = new pData;  
 
 
 
 $DataSet->AddPoint($data_array,"Serie1");  
 $DataSet->AddPoint($where_uznal,"Serie2");  
 $DataSet->AddPoint($arr2["name_mechanic"],"Serie2");
 
 $DataSet->AddAllSeries();  
 $DataSet->SetAbsciseLabelSerie("Serie2");  
  
 // Initialise the graph  
 $Test = new pChart(700,230); 
 $Test->drawFilledRoundedRectangle(7,7,373,193,5,240,240,240);  
 $Test->drawRoundedRectangle(5,5,375,195,5,230,230,230);  
  
 // Draw the pie chart  
 $Test->setFontProperties("Fonts/tahoma.ttf",10);  
 $Test->drawPieGraph($DataSet->GetData(),$DataSet->GetDataDescription(),150,90,110,PIE_PERCENTAGE,TRUE,50,20,5);  
 $Test->drawPieLegend(380,25,$DataSet->GetData(),$DataSet->GetDataDescription(),250,250,250);  
  
$Test->Render("example10.png");
 
 
}
?>  