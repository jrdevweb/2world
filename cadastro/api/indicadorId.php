<?php
require 'conectar.php';
$output = array();
$data = json_decode(file_get_contents("php://input"));
$ID_INDICADOR = mysqli_real_escape_string($connect, $data->id);
$query = "SELECT id, nome FROM usuario where id = '$ID_INDICADOR' ";
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
