<?php
// Iniciar a sessão
session_start();
if (!isset($_SESSION['organizador'])) {
    header('Location: login.php');
    exit;
}

// Conectar ao banco de dados
include('../includes/db_connect.php');

// Verificar se o ID do evento foi enviado
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    // Realizar a exclusão do evento
    $query = "DELETE FROM Evento WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "success"; // Retorna sucesso para o AJAX
    } else {
        echo "error"; // Retorna erro se a exclusão falhar
    }

    $stmt->close();
}

// Fecha a conexão com o banco de dados
mysqli_close($conn);
?>
