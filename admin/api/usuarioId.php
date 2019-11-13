<?php
$data = json_decode(file_get_contents("php://input"));
require 'conectar.php';
$output = array();
$ID_USUARIO = mysqli_real_escape_string($connect, $data->id);
$query = "SELECT * FROM usuario WHERE id = '$ID_USUARIO'";

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
$_SESSION['id_usuario'] = $ID_USUARIO;

?>
