<?php

$servername = 'motty.db.elephantsql.com';
$username = 'gshqrvpq';
$pass = 'AQ36xYHbCASn7K_zm2JmWuMavIwirFN4';
$db = 'gshqrvpq';

$con = pg_connect("host=$servername dbname=$db user=$username password=$pass")
or die ("Could not connect to server\n");

/*$connect = mysqli_connect($servername, $username, $pass, $db);

if(mysqli_connect_error()):
    echo "Falha na conexao: ".mysqli_connect_error();
endif;*/
?>