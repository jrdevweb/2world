<?php
require 'conectar.php';
$output = array();
session_start();
$ID_USUARIO = $_SESSION['id'];
$query = "SELECT ntf_us.id, ntf.titulo, ntf.mensagem, ntf.data_notificacao, ntf.status, ntf_us.status as status_notificacao FROM notificacao ntf
                    inner join notificacao_usuario ntf_us on ntf_us.id_notificacao = ntf.id
                    inner join usuario us on us.id = ntf_us.id_usuario
                    where us.id = '$ID_USUARIO'";

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
