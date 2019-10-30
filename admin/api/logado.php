<?php
session_start();
require 'conectar.php';
$output = array();
$output['uid_user_admin'] = $_SESSION['uid_user_admin'];
$output['id'] = $_SESSION['id'];
$output['nome'] = $_SESSION['nome'];
$output['email'] = $_SESSION['email'];
echo json_encode($output);


?>
