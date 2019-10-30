<?php
require 'conectar.php';
$data = array();
$error = array();
session_start();
$ID_USUARIO = $_SESSION['id'];

if(!empty($error))
{
  $data["error"] = $error;
}
else
{
  $status = 'LIDO';
  $query = "UPDATE notificacao_usuario set status = '$status' WHERE id_usuario = '$ID_USUARIO'";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "Todas as notificações marcadas como lidas.";
  }
}

echo json_encode($data);

?>
