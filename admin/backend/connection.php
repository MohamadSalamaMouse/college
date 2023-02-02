<?php 
try{
$conect=new PDO('mysql:host=localhost;dbname=college','root','');
}catch (PDOException $e) {
    echo "connection failed" . $e->getMessage();
    die();
}

?>