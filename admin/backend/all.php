<?php
require_once "connection.php";
$code=$_GET['code'];
$q="SELECT students.name,email,age,phone,image,code,departments.name as 'department' FROM students LEFT JOIN departments ON students.dept_num=departments.number where code=$code";
$result=$conect->query($q);
$students=$result->fetchAll(PDO::FETCH_ASSOC);
$s = $conect->query("SELECT *FROM skills");
$skills = $s->fetchAll(PDO::FETCH_ASSOC);
