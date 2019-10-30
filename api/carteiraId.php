<?php
$data = json_decode(file_get_contents("php://input"));
require 'conectar.php';
session_start();
$ID_USUARIO = $_SESSION['id'];
$sql = "SELECT * FROM usuario WHERE id = '$ID_USUARIO'";

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
?>
