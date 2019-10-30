<?php
require 'conectar.php';
$output = array();
session_start();
$data = json_decode(file_get_contents("php://input"));
$ID_ROBOCHECKOUT = mysqli_real_escape_string($connect, $data->id);
$query = "SELECT cr.id, cr.status, cr.data_compra, cr.comprovante, p.valor, p.descricao, p.porcentagem_ganho, us.nome FROM checkout_robo cr
            INNER JOIN usuario us on us.id = cr.id_usuario
            INNER JOIN planos p on p.id = cr.id_plano
            WHERE cr.id = '$ID_ROBOCHECKOUT' ";
$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result) > 0)
{
  while($row = mysqli_fetch_array($result))
  {
    $output[] = $row;
  }
  echo json_encode($output);
  $_SESSION['robo_venda_id'] = $ID_ROBOCHECKOUT;
}
?>
