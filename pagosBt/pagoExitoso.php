<?php 
   if(isset($_POST)){
    $data = file_get_contents("php://input");
    $update = json_decode($data,true);
    echo $update;

   }
?>