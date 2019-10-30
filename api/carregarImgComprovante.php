<?php
require 'conectar.php';
$inputs = json_decode(file_get_contents("php://input"));
session_start();
$ID_USUARIO = $_SESSION['id'];
$ID_ROBOCHECKOUT = $_SESSION['robo_checkout_id'];
if(!empty($_FILES))
{
  $path = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
  $image = time().'.'.$path;
  // $path = '../comprovantes/' . $_FILES['file']['name'];
  if(move_uploaded_file($_FILES["file"]["tmp_name"], '../receipt/'.$image))
  {
    $filename = $_FILES['file']['name'];
    $insertQuery = "UPDATE checkout_robo set comprovante = '$image' WHERE id_usuario = '$ID_USUARIO' and id = '$ID_ROBOCHECKOUT'";
    if(mysqli_query($connect, $insertQuery))
    {
      echo 'Comprovante enviado com sucesso!';
    }
    else
    {
      echo 'Foto carregada, porém ocorreu um erro.';
    }
  }
}
else
{
  echo 'Para enviar um comprovante, escolha uma foto e clique em "ENVIAR"';
}
?>
