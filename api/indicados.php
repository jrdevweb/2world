<?php
require 'conectar.php';
$output = array();
session_start();
$ID_USUARIO = $_SESSION['id'];
$query = "SELECT indicou.id, indicou.data_indicacao, user.nome, user.email, indicou.status  FROM indicacao indicou
                   inner join usuario user on user.id = indicou.id_usuario_indicado where id_usuario_indicou = '$ID_USUARIO'";

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
