<?php
// Conexão com o banco de dados
$mysqli = new mysqli("localhost", "root", "", "gerenciamentoeventos");

// Verifica se houve erro na conexão
if ($mysqli->connect_error) {
    die("Falha na conexão: " . $mysqli->connect_error);
}

// Verifica se o método de requisição é POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $data_inicio = $_POST['data_inicio'];
    $data_termino = $_POST['data_termino'];
    $local = $_POST['local'];
    $descricao = $_POST['descricao'];

    // Prepara a inserção no banco de dados
    $stmt = $mysqli->prepare("INSERT INTO evento (nome, data_inicio, data_termino, local, descricao) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nome, $data_inicio, $data_termino, $local, $descricao);

    if ($stmt->execute()) {
        // Redireciona para a página de listagem de eventos
        header('Location: listar_eventos.php');
        exit;
    } else {
        echo "Erro ao cadastrar evento: " . $stmt->error;
    }

    $stmt->close();
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Evento</title>
    <style>
        /* Fundo dinâmico animado */
        body {
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #f1f1f1;
            background: linear-gradient(135deg, #013220, #000000);
            background-size: 200% 200%;
            animation: gradientAnimation 10s ease infinite;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Estilo para o título */
        h2 {
            color: #fff;
            font-size: 2em;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        /* Estilo do formulário */
        form {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 10px;
            width: 320px;
            text-align: left;
            color: #f1f1f1;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-top: 15px;
            color: #c1c1c1;
            font-size: 14px;
        }

        input[type="text"], input[type="date"], textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        /* Estilo dos botões */
        button, .botao-voltar {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background-color: #013220; /* Verde escuro */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s, transform 0.3s;
            text-decoration: none; /* Remove a sublinhado do botão de voltar */
            display: inline-block;
        }

        button:hover, .botao-voltar:hover {
            background-color: #004d33; /* Verde mais claro no hover */
            transform: translateY(-3px);
        }
    </style>
</head>
<body>
    <h2>Cadastrar Novo Evento</h2>
    <form method="POST" action="">
        <label for="nome">Nome do Evento:</label>
        <input type="text" id="nome" name="nome" required>
        
        <label for="data_inicio">Data de Início:</label>
        <input type="date" id="data_inicio" name="data_inicio" required>
        
        <label for="data_termino">Data de Término:</label>
        <input type="date" id="data_termino" name="data_termino" required>
        
        <label for="local">Local:</label>
        <input type="text" id="local" name="local" required>
        
        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao"></textarea>
        
        <button type="submit">Salvar Evento</button>

        <!-- Botão de Voltar para a Tela Principal -->
        <a href="tela_principal.php" class="botao-voltar">Voltar para a Tela Principal</a>
    </form>
</body>
</html>

