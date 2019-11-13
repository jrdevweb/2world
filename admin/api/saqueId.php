<?php

$data = json_decode(file_get_contents("php://input"));
require 'conectar.php';
$output = array();
$ID_SAQUE = mysqli_real_escape_string($connect, $data->id);
$query = "SELECT * FROM saque_usuario su inner join usuario usr on usr.id = su.id_usuario  WHERE su.id = '$ID_SAQUE'";

$CONSULTA = mysqli_query($connect, " SELECT * FROM saque_usuario where id = '$ID_SAQUE'");
$r = mysqli_fetch_assoc($CONSULTA);
$ID_USUARIO = $r['id_usuario'];

$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result) > 0)
{
  while($row = mysqli_fetch_array($result))
  {
    $output[] = $row;
  }
  echo json_encode($output);
}
session_start();
$_SESSION['id_saque'] = $ID_SAQUE;
$_SESSION['id_usuario_saque'] = $ID_USUARIO;

?>
