<?php
$data = json_decode(file_get_contents("php://input"));
require 'conectar.php';
$ID_SAQUE = mysqli_real_escape_string($connect, $data->id);
$sql = "SELECT * FROM saque_usuario su inner join usuario usr on usr.id = su.id_usuario  WHERE su.id = '$ID_SAQUE'";

$CONSULTA = mysqli_query($connect, " SELECT * FROM saque_usuario where id = '$ID_SAQUE'");
$r = mysqli_fetch_assoc($CONSULTA);
$ID_USUARIO = $r['id_usuario'];

$result = $connect->query($sql);
if ($result->num_rows > 0) {

  $data = array() ;
  while($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
} else {
  echo "Base de dados não contém registros.";
}
echo json_encode($data);
session_start();
$_SESSION['id_saque'] = $ID_SAQUE;
$_SESSION['id_usuario_saque'] = $ID_USUARIO;

?>
