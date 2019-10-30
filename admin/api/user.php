<?php

$user=json_decode(file_get_contents("php://input"));

require 'conectar.php';
$emailLogin = mysqli_real_escape_string($connect, $user->email);
$senhaLogin = mysqli_real_escape_string($connect,$user->senha);

$senhaMD5 = md5($senhaLogin);

$query =("SELECT id FROM usuario_admin WHERE email= '$emailLogin' and senha= '$senhaMD5' LIMIT 1");
$query2 =("SELECT * FROM usuario_admin WHERE email= '$emailLogin' and senha= '$senhaMD5' LIMIT 1");

$que = mysqli_query($connect, $query);
$que2 = mysqli_query($connect, $query2);
$count = mysqli_num_rows($que);
$resultado = mysqli_fetch_assoc($que2);

if($count == 1){
	session_start();
	$_SESSION['uid_user_admin'] = uniqid('ang_');
	$_SESSION['id'] = $resultado['id'];
	$_SESSION['nome'] = $resultado['nome'];
	$_SESSION['email'] = $resultado['email'];
	print $_SESSION['uid_user_admin'];
}
?>
