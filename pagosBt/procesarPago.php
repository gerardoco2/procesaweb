<?php

$cedula = isset($_POST['cedula']) ? $_POST['cedula'] : null;
$telefono = isset($_POST['telefono']) ? $_POST['telefono'] : null;
$banco = isset($_POST['banco']) ? $_POST['banco'] : null;
$token = isset($_POST['token']) ? $_POST['token'] : null;


if (empty($cedula) || empty($telefono) || empty($banco) || empty($token) ) {
  die('Por favor ingresa todos los datos');
}


$apiUrl = 'api_url'; 
$postData = [
  'cedula' => $name,
  'telefono' => $id,
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


if (isset($data['error'])) {
  $result = 'API Error: ' . $data['error'];
} else {
  $status = $data['status'] ? 'Active' : 'Inactive';
  $result = "Name: {$data['name']}, ID: {$data['id']}, Status: {$status}";
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