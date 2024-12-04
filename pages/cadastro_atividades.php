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
    $descricao = $_POST['descricao'];
    $data = $_POST['data'];
    
    if (!empty($_POST['novo_evento']) && !empty($_POST['evento_id'])) {
        echo "<script>alert('Por favor, escolha apenas um evento: ou crie um novo ou selecione um evento existente.');</script>";
    } else {
        if (!empty($_POST['novo_evento'])) {
            $novo_evento = $_POST['novo_evento'];
            $stmt_evento = $mysqli->prepare("INSERT INTO evento (nome) VALUES (?)");
            $stmt_evento->bind_param("s", $novo_evento);
            if ($stmt_evento->execute()) {
                $evento_id = $mysqli->insert_id;

                // Limpar eventos que não possuem atividades associadas
                $stmt_clear = $mysqli->prepare("DELETE FROM evento WHERE id NOT IN (SELECT evento_id FROM atividade WHERE evento_id = ?)");
                $stmt_clear->bind_param("i", $evento_id);
                if ($stmt_clear->execute()) {
                    echo "<script>alert('Eventos antigos sem atividades foram limpos.');</script>";
                } else {
                    echo "Erro ao limpar eventos: " . $stmt_clear->error;
                }
                $stmt_clear->close();
            } else {
                echo "Erro ao criar novo evento: " . $stmt_evento->error;
            }
            $stmt_evento->close();
        } else {
            $evento_id = $_POST['evento_id'];
        }

        // Inserir a atividade
        $stmt = $mysqli->prepare("INSERT INTO atividade (nome, descricao, data, evento_id) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            die("Falha ao preparar: " . $mysqli->error);
        }
        $stmt->bind_param("sssi", $nome, $descricao, $data, $evento_id);

        if ($stmt->execute()) {
            echo "<script>alert('Atividade cadastrada com sucesso!'); window.location.href='Tela_atividades.php?evento_id=$evento_id';</script>";
            exit;
        } else {
            echo "Erro: " . $stmt->error;
        }
        $stmt->close();
    }
}

$eventos = $mysqli->query("SELECT id, nome FROM evento");
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Atividade</title>
    <style>
        body {
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #013220, #000000);
            background-size: 200% 200%;
            animation: gradientAnimation 10s ease infinite;
            color: #f1f1f1;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .form-container {
            width: 100%;
            max-width: 500px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            background-color: rgba(0, 0, 0, 0.6);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-container:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }

        h1 {
            color: #ffffff;
            font-size: 2em;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 15px;
            color: #c1c1c1;
            font-size: 1.1em;
            font-weight: bold;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: none;
            border-radius: 6px;
            font-size: 1em;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        select {
            font-size: 1.1em;
            color: #f1f1f1;
            background-color: rgba(255, 255, 255, 0.2);
            cursor: pointer;
            appearance: none;
        }

        select option {
            background-color: #013220;
            color: #f1f1f1;
            font-size: 1em;
        }

        button, .btn-voltar {
            background-color: #013220;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            margin-top: 15px;
            transition: background-color 0.3s, transform 0.3s;
        }

        button:hover, .btn-voltar:hover {
            background-color: #004d33;
            transform: translateY(-3px);
        }

        .btn-voltar {
            display: inline-block;
            text-decoration: none;
            font-weight: bold;
            font-size: 1em;
            margin-top: 10px;
            color: #c1c1c1;
            transition: color 0.3s;
        }

        .btn-voltar:hover {
            color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Cadastrar Nova Atividade</h1>
        <form method="POST" action="cadastro_atividades.php">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required></textarea>
            
            <label for="data">Data:</label>
            <input type="datetime-local" id="data" name="data" required>
            
            <label for="evento_id">Escolha o Evento Existente:</label>
            <select id="evento_id" name="evento_id">
                <option value="">Selecione um Evento</option>
                <?php
                while ($evento = $eventos->fetch_assoc()) {
                    echo "<option value='{$evento['id']}'>{$evento['nome']}</option>";
                }
                ?>
            </select>
            
            <button type="submit">Cadastrar</button>
            <a href="Tela_principal.php" class="btn-voltar">Voltar</a>
        </form>
    </div>
</body>
</html>
