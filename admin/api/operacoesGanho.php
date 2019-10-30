<?php

require 'conectar.php';
$output = array();
date_default_timezone_set('America/Sao_Paulo');
$DATA_RENDIMENTO = date("d/m/Y H:i:s");
$PLANO = 500.00 * 0.0000174;
$CALCULO_RENDIMENTO = ($PLANO/100);
$USUARIO_ID = '5';

$CONSULTA = "INSERT INTO rendimento_diario (valor_rendimento, data_rendimento, usuario_id) VALUES ('$CALCULO_RENDIMENTO','$DATA_RENDIMENTO','$USUARIO_ID')";
if(mysqli_query($connect, $CONSULTA))

$query = "SELECT SUM(valor_rendimento) as valor FROM rendimento_diario WHERE usuario_id = '$USUARIO_ID' ";

$result = mysqli_query($connect, $query);

if(mysqli_num_rows($result) > 0)
{
  while($row = mysqli_fetch_array($result))
  {
    $output[] = $row;
  }
}

echo json_encode($output);

?>
