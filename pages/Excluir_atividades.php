<?php
session_start();
if (!isset($_SESSION['organizador'])) {
    header('Location: login.php');
    exit;
}

// Conectar ao banco de dados
include('../includes/db_connect.php');

// Verificar se o ID da atividade foi enviado
if (isset($_POST['delete_id'])) {
    $activityId = $_POST['delete_id'];

    // Preparar a query para excluir a atividade com base no ID
    $query = "DELETE FROM Atividade WHERE ID = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind do parâmetro
        mysqli_stmt_bind_param($stmt, "i", $activityId);

        // Executa a query
        if (mysqli_stmt_execute($stmt)) {
            echo "success";  // Retorna sucesso para o AJAX
        } else {
            echo "error";  // Caso ocorra algum erro
        }

        // Fecha o statement
        mysqli_stmt_close($stmt);
    } else {
        echo "error";  // Caso falhe ao preparar a query
    }
} else {
    echo "error";  // Caso o ID não seja passado
}

// Fecha a conexão com o banco de dados
mysqli_close($conn);
?>
