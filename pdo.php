<?php
try{
$db=new PDO('mysql:host=localhost;dbname=demodb;charset=utf8','root','');
//var_dump($db);
}
catch(Exception $e){
echo $e->getMessage();
}
?>