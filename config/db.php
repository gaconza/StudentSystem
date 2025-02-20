<?php

$servername = "localhost";
$db_username = "root";    
$db_password = "";        
$dbname = "studentsystem";

// Cria a conexão
$conn = mysqli_connect($servername, $db_username, $db_password, $dbname);

// Verifica a conexão
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
