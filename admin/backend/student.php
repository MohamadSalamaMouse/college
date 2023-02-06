<?php 
require_once "connection.php";
$q="SELECT students.name,email,code,departments.name as 'department' FROM students LEFT JOIN departments ON students.dept_num=departments.number";
$result=$conect->query($q);
$students=$result->fetchAll(PDO::FETCH_ASSOC);
