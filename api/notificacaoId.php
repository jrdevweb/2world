<?php
require 'conectar.php';
$output = array();
$data = json_decode(file_get_contents("php://input"));
$ID_NOTIFICACAO= mysqli_real_escape_string($connect, $data->id);
$query = "SELECT ntf_us.id, ntf.titulo, ntf.mensagem, ntf.data_notificacao, ntf.status, ntf_us.status as status_notificacao FROM notificacao ntf
                    inner join notificacao_usuario ntf_us on ntf_us.id_notificacao = ntf.id
                    inner join usuario us on us.id = ntf_us.id_usuario
                    where ntf_us.id = '$ID_NOTIFICACAO'";

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
