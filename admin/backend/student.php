<?php 
require_once "connection.php";
$q="SELECT concat (fname,' ', lname)as 'name',address,gender,code,name as 'department' FROM students LEFT JOIN departments ON students.dept_num=departments.number";
$result=$conect->query($q);
$students=$result->fetchAll(PDO::FETCH_ASSOC);

?>