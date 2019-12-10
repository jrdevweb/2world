<?php
require 'conectar.php';
$output = array();
session_start();
$data = json_decode(file_get_contents("php://input"));
$ID_PLANO = mysqli_real_escape_string($connect, $data->id);

$query = "SELECT cr.id, cr.status, cr.data_compra, p.valor_plano, p.descricao, p.porcentagem_total, p.taxa_saque, p.meses_rentabilidade, p.nivel_indicacao FROM planos_comprados cr
            INNER JOIN usuario us on us.id = cr.usuario_id
            INNER JOIN planos p on p.id = cr.plano_id
            WHERE cr.id = '$ID_PLANO'";

$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result) > 0)
{
  while($row = mysqli_fetch_array($result))
  {
    $output[] = $row;
  }
  echo json_encode($output);

  $_SESSION['plano_comprado_id'] = $ID_PLANO;
}
?>
