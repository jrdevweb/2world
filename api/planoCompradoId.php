<?php
require 'conectar.php';
$output = array();
session_start();
$data = json_decode(file_get_contents("php://input"));
$ID_PLANO_COMPRADO = mysqli_real_escape_string($connect, $data->id);
$query = "SELECT * FROM planos_comprados cr
            INNER JOIN usuario us on us.id = cr.usuario_id
            INNER JOIN planos p on p.id = cr.plano_id
            WHERE cr.id = '$ID_PLANO_COMPRADO' ";
$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result) > 0)
{
  while($row = mysqli_fetch_array($result))
  {
    $output[] = $row;
  }
  echo json_encode($output);
  $_SESSION['plano_comprado_id'] = $ID_PLANO_COMPRADO;
}
?>
