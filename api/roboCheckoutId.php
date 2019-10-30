<?php
require 'conectar.php';
$output = array();
session_start();
$ID_USUARIO = $_SESSION['id'];
$query = "SELECT cr.id, cr.status, cr.data_compra, cr.comprovante, p.valor, p.descricao, p.porcentagem_ganho, p.imagem_acao FROM checkout_robo cr
            INNER JOIN usuario us on us.id = cr.id_usuario
            INNER JOIN planos p on p.id = cr.id_plano
            WHERE cr.id_usuario = '$ID_USUARIO'";

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
