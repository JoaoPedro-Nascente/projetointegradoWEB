<?php

$con = "dbname=dnr02p5q74q6l host=ec2-3-214-136-47.compute-1.amazonaws.com port=5432 user=tjxnnuuhpgksja password=10cc0b0a01ded4bdb130393ab3a1fd4959e43a7f95b2cc352989a4aca1d475eb sslmode=require";


if (!$con) 
{
  echo "Database connection failed.";
}
else 
{
  echo "Database connection success.";
}

/*$host = 'ec2-3-214-136-47.compute-1.amazonaws.com';
$username = 'tjxnnuuhpgksja';
$pass = '10cc0b0a01ded4bdb130393ab3a1fd4959e43a7f95b2cc352989a4aca1d475eb';
$db = 'dnr02p5q74q6l';

$con = mysqli_connect("host=$host dbname=$db user=$username password=$pass")
or die ("Could not connect to server\n");

$connect = mysqli_connect($servername, $username, $pass, $db);

if(mysqli_connect_error()):
    echo "Falha na conexao: ".mysqli_connect_error();
endif;*/
?>