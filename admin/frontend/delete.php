<?php
define("Root", dirname(__DIR__));
require  Root. "\backend\connection.php";
session_start();
if(! isset($_SESSION['id'])){
    header("location:login.php");
}
if(isset($_GET['code'])){
    $code=$_GET['code'];
}else{
    echo "<h1 align='center'>wrong page !!!!</h1>";
    exit();
}
$std=$conect->query("SELECT image from students where code=$code");
$path=$std->fetch(PDO::FETCH_ASSOC);
$filePath= $path['image'];
if (file_exists($filePath))
{
    unlink($filePath);

}
$result=$conect->query("delete from students where code=$code");
header("location: index.php");