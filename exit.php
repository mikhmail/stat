<?
		session_start();
		$_SESSION = array();
		session_destroy();
		

if (isset($_SERVER['HTTP_COOKIE'])) {
		$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}
		
		header('Location: index.php');
		//echo "<script language='JavaScript' type='text/javascript'>window.location.replace('index.php')</script>";
        //exit();
    
?>