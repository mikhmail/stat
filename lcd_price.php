<?
error_reporting(E_ERROR | E_WARNING | E_PARSE);

	$dblocation = "localhost";   
	$dbname = "glafira";   
	$dbuser = "root";   
	$dbpasswd = "";   

  $dbcnx = mysql_connect($dblocation, $dbuser, $dbpasswd);   
  if (!$dbcnx)   
  {   
    echo "<p>К сожалению, не доступен сервер mySQL</p>";   
    exit();   
  }   
  if (!mysql_select_db($dbname,$dbcnx) )   
  {   
    echo "<p>К сожалению, не доступна база данных</p>";   
    exit();   
  }   
  $ver = mysql_query("SELECT VERSION()");   
  if(!$ver)   
  {   
    echo "<p>Ошибка в запросе</p>";   
    exit();   
  }   
  //echo mysql_result($ver, 0);

mysql_select_db ( glafira ) or die ("Невозможно открыть glafira");

mysql_query("SET NAMES UTF8");
mysql_query("SET CHARACTER SET UTF8");
$row=array();
$query = mysql_query("SELECT * FROM lcd_price ORDER BY id");



?>
<table border="0" width="700">
	<tr>
		<th>Название</th>
		<th>Цена</th>
	</tr>
<?

while ( $row = mysql_fetch_assoc($query)) {

if ( preg_match("/^15.6/", $row['name']) OR preg_match("/^10.1/", $row['name']) ) {
	
	
	
    $price = '';
	
} else {
    $price = ($row['price']+30)*11.5;
}

//$price = ($row['price']+20)*11.5;
?>

	<tr>
		<td><?=$row['name']?></td>
		<td><?=$price?></td>
	</tr>

<?}?>

</table>