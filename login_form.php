<?
error_reporting(E_ERROR | E_WARNING | E_PARSE);
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

if(isset($_POST['submit']))

{
//var_dump($_POST);
    # Вытаскиваем из БД запись, у которой логин равняеться введенному

    $query = mysql_query("SELECT user_id, login, password FROM users WHERE login='".mysql_real_escape_string($_POST['login'])."' AND id_group IN ( '1', '2', '3' ) LIMIT 1");

    $data = mysql_fetch_assoc($query);

    

    # Соавниваем пароли

    if($data['password'] === ($_POST['password']))

    {

        # Генерируем случайное число и шифруем его

        $hash = md5(generateCode(10));

            

      

        

        # Записываем в БД новый хеш авторизации и IP

        mysql_query("UPDATE users SET user_hash='".$hash."' WHERE user_id='".$data['user_id']."'") or die(mysql_error());
        

        # Ставим куки

        setcookie("id", $data['user_id'], time() + 60 * 60 * 24 * 30 * 12);

        setcookie("hash", $hash, time() + 60 * 60 * 24 * 30 * 12);

        

        # Переадресовываем браузер на страницу проверки нашего скрипта
		echo "<script language='JavaScript' type='text/javascript'>window.location.replace('index.php')</script>";
        //header("Location: index.php");
	
    }

    else

    {

        print "Вы ввели неправильный логин или пароль";

    }

}

	
	// Функция для генерации случайной строки
	function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;  
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];  
    }
    return $code;
	}

?>

<!DOCTYPE html>
<html lang="ru">
  <head>
  <meta charset="utf-8">
  <meta content="width=300, initial-scale=1" name="viewport">
  <meta name="google" value="notranslate">
  <link rel="stylesheet" href="css/login-box.css" type="text/css" />
  <title>Вход – ТД</title>
  
<div class="card signin-card">
  <div id="cc_iframe_parent"></div>
<img id="profile-img" class="profile-img" src="images/logo.png" alt="">

  <form method="post">


<label  class="not-hidden-label">Логин</label>
<input  id="login" name="login" type="text"
       placeholder="Логин"
       class="">

		 
<label  class="hidden-label">Пароль</label>
<input  id="password" name="password" type="password"
       placeholder="Пароль"
       class="">
  <hr>
  <input id="submit" name="submit" class="rc-button rc-button-submit" type="submit" value="Войти">
  </form>
  <a id="link-forgot-passwd" href="mailto:technodoctor@i.ua">
  Нужна помощь?
  </a>
</div>
</html>