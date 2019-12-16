<?php
date_default_timezone_set('America/Sao_Paulo');
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
require 'conectar.php';
session_start();
$ID_PLANO_COMPRADO = $_SESSION['plano_comprado_id'];

if(!empty($error))
{
  $data["error"] = $error;
}
else
{
  $status = 'PAGO';
  $statusUsuario = 'SIM';

  //PEGANDO ID DO USUÁRIO

  $CONSULTA = mysqli_query($connect, " SELECT * FROM planos_comprados where id = '$ID_PLANO_COMPRADO'");
  $r = mysqli_fetch_assoc($CONSULTA);
  $ID_USUARIO = $r['usuario_id'];

  //ATUALIZANDO STATUS DO PLANO COMPRADO PARA PAGO

  $query = "UPDATE planos_comprados set status = '$status' WHERE id = '$ID_PLANO_COMPRADO'";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = "Fatura paga com sucesso.";
  }


  //ATUALIZANDO USUARIO COMO ATIVO, ATUALIZANDO SALDO COM O PLANO

  $CONSULTAINDICACAO = mysqli_query($connect, " SELECT * FROM usuario where id = '$ID_USUARIO'");
  $r = mysqli_fetch_assoc($CONSULTAINDICACAO);
  $ID_USUARIO_INDICADOR = $r['id_usuario_indicador'];
  $PLANO_VALOR = $r['plano_valor'];

  $queryUsuario = "UPDATE usuario set ativo = '$statusUsuario', saldo_conta = saldo_conta + '$PLANO_VALOR' WHERE id = '$ID_USUARIO'";
  if(mysqli_query($connect, $queryUsuario))
  {

  }

  //PEGANDO VALOR DO PLANO E PORCENTAGEM DIARIO DO PLANO

  $CONSULTAVALOR = mysqli_query($connect, " SELECT * FROM planos p
                                                    inner join usuario u on u.plano_id = p.id where u.id = '$ID_USUARIO'");
  $r = mysqli_fetch_assoc($CONSULTAVALOR);

  $valor_plano = $r['valor_plano'];
  $porcentagem = $r['porcentagem_diario'];
  $cem = 100;

  $valor = ($valor_plano * $porcentagem) / $cem;

  //ATUALIZANDO SALDO DA PESSOA QUE INDICOU

  $query = "UPDATE usuario set saldo_conta = saldo_conta + $valor WHERE id = '$ID_USUARIO_INDICADOR'";
  if(mysqli_query($connect, $query))
  {

  }

  //ATUALIZANDO INDICAÇÃO PARA PAGA

  $query = "UPDATE indicacao set status = 'PAGO' WHERE id_usuario_indicou = '$ID_USUARIO_INDICADOR' and id_usuario_indicado = '$ID_USUARIO'";
  if(mysqli_query($connect, $query))
  {

  }

}

echo json_encode($data);

?>
