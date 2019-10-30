<?php
$inputs = json_decode(file_get_contents("php://input"));
$data = array();
$error = array();
require 'conectar.php';
session_start();
$ID_USUARIO = $_SESSION['id_usuario'];

if(empty($inputs->nome))
{
  $error["nome"] = "O nome completo é obrigatório *";
}

if(empty($inputs->ativo))
{
  $error["ativo"] = "O campo conta ativa é obrigatório *";
}

if(empty($inputs->robo_ligado))
{
  $error["robo_ligado"] = "O campo Robô ligado é obrigatório *";
}

if(empty($inputs->plano_id))
{
  $error["plano_id"] = "O campo plano robô é obrigatório *";
}

if(empty($inputs->senha))
{
  $error["senha"] = "A senha é obrigatório *";
}

if(!empty($error))
{
  $data["error"] = $error;
}
else
{
  $nome = mysqli_real_escape_string($connect, $inputs->nome);
  $ativo = mysqli_real_escape_string($connect, $inputs->ativo);
  $robo_ligado = mysqli_real_escape_string($connect, $inputs->robo_ligado);
  $plano_id = mysqli_real_escape_string($connect, $inputs->plano_id);
  $senha = mysqli_real_escape_string($connect, md5($inputs->senha));
  $CONSULTA = mysqli_query($connect, " SELECT * FROM planos WHERE id = '$plano_id'");
  $r = mysqli_fetch_assoc($CONSULTA);
  $plano_valor = $r['valor'];


  $query = "UPDATE usuario set nome = '$nome', ativo = '$ativo', robo_ligado = '$robo_ligado', plano_id = '$plano_id', plano_valor = '$plano_valor', senha = '$senha' WHERE id = '$ID_USUARIO'";
  if(mysqli_query($connect, $query))
  {
    $data["message"] = " Os dados do usuário ".$nome." foram atualizados! ";
  }
}

echo json_encode($data);

?>
