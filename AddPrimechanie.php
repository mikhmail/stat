<?php
// ��������� ���������
header("Content-type:text/html; charset=utf-8");

// ����������� �����
set_include_path(get_include_path()
					.PATH_SEPARATOR.'classes');
					
// ������������ �������					
function __autoload($class){
	require_once $class.'.php';
}


# �������� ������.
	session_start();

// ����������� � ��.
$db = Connect::getInstance();

// �����������
$login = Login::getInstance();

//��������� �������
$baza = Baza::getInstance();



$baza->add_primechaniya ($_POST['primechanie_id'], $_POST['id_kvitancy']);
echo $_POST['primechanie_id'] . ' ' . $_POST['id_kvitancy'];
?>