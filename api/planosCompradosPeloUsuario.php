<?php
require 'conectar.php';
$output = array();
session_start();
$ID_USUARIO = $_SESSION['id'];
$query = "SELECT cr.id, cr.status, cr.data_compra, p.valor_plano, p.descricao, p.porcentagem_total, p.taxa_saque, p.meses_rentabilidade, p.nivel_indicacao FROM planos_comprados cr
            INNER JOIN usuario us on us.id = cr.usuario_id
            INNER JOIN planos p on p.id = cr.plano_id
            WHERE cr.usuario_id = '$ID_USUARIO'";

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
