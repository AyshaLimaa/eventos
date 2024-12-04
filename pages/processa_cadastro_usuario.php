<?php 
session_start();
include('../includes/db_connect.php'); // Conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha']; // Sem `password_hash`, armazenando a senha diretamente

    // Verifica se o e-mail já está cadastrado
    $query = $conn->prepare("SELECT ID FROM organizador WHERE Email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // E-mail já cadastrado
        echo "<script>alert('E-mail já cadastrado!'); window.location.href='cadastro_usuario.php';</script>";
        exit;
    }

    // Limpa a sessão para remover dados do usuário anterior, se houver
    session_unset();
    session_destroy();
    session_start(); // Inicia uma nova sessão limpa

    // Prepara a declaração para inserir o novo usuário
    $stmt = $conn->prepare("INSERT INTO organizador (Nome, Email, Senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senha);

    // Executa a declaração
    if ($stmt->execute()) {
        // Armazena o ID do novo usuário na sessão
        $_SESSION['usuario_id'] = $conn->insert_id;

        // Redireciona para a página de login ou uma página de cadastro de itens
        header('Location: login.php');
        exit;
    } else {
        // Em caso de erro na execução, exibe o erro
        echo "Erro ao cadastrar usuário: " . $stmt->error;
    }

    // Fecha a declaração
    $stmt->close();
}

// Fecha a conexão
$conn->close();
?>
