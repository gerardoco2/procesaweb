<?php

$cedula = isset($_POST['cedula']) ? $_POST['cedula'] : null;
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
$banco = isset($_POST['banco']) ? $_POST['banco'] : null;
$token = isset($_POST['token']) ? $_POST['token'] : null;
/*
if (empty($cedula) || empty($telefono) || empty($banco) || empty($token) ) {
  die('Por favor ingresa todos los datos');
}*/


$apiUrl = 'http://190.202.9.207:8080/RestTesoro_C2P/com/services/botonDePago/pago'; 
$postData = [
  "canal"=>"06",
  "celular"=>"04241234128",
  "banco"=>"0128",
  "RIF"=>"J301578970",
  "cedula"=>"V1234567",
  "monto"=>"5000.00",
  "token"=>"20191231",
  "concepto"=> " paga",
  "codAfiliado"=>"104663",
  "comercio"=>""
];

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);


if (curl_errno($ch)) {
  die('API Error: ' . curl_error($ch));
}


$data = json_decode($response, true);
echo var_dump($data);
foreach ($data as $key => $value) {
  echo "Key: $key; Value: $value\n";
}

if (isset($data['error'])) {
  $result = 'API Error: ' . $data['error'];
} else {
  $status = $data['status'] ? 'Active' : 'Inactive';
  $result = "Respuesta del banco: {$data['codres']}, resultado: {$data['descRes']}, Referencia: {$data['fecha']},
   Monto operacion {$data['monto']} ";
}



echo <<<HTML
<!DOCTYPE html>
<html>
<head>
  <title>Resultado del pago</title>
</head>
<body>
  <div id="result">
    $result
  </div>
</body>
</html>
HTML;

?>


