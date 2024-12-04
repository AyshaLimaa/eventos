<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "GerenciamentoEventos";

// Criar conexão
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar conexão
if (!$conn) {
    die("Conexão falhou: " . mysqli_connect_error());
}
?>