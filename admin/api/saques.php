<?php
require 'conectar.php';
$output = array();
$query = "SELECT su.id, su.carteira, u.nome, su.status, su.data_solicitacao FROM saque_usuario su inner join usuario u on u.id = su.id_usuario";

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
