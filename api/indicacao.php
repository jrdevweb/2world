<?php
require 'conectar.php';
$output = array();
session_start();
$ID_USUARIO = $_SESSION['id'];
$query = "SELECT * FROM indicacao ind inner join usuario us on us.id = ind.id_usuario_indicado where ind.id_usuario = '$ID_USUARIO' ";

$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result) > 0)
{
  while($row = mysqli_fetch_array($result))
  {
    $output[] = $row;
  }
  echo json_encode($output);
}
?>
