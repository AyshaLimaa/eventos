<?php
// Conexão com o banco de dados
$mysqli = new mysqli("localhost", "root", "", "gerenciamentoeventos");

// Verifica se houve erro na conexão
if ($mysqli->connect_error) {
    die("Falha na conexão: " . $mysqli->connect_error);
}

// Consulta os eventos cadastrados
$resultado = $mysqli->query("SELECT id, nome, data_inicio, data_termino, local FROM evento ORDER BY data_inicio DESC");

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listar Eventos</title>
    <style>
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

        h2 {
            color: #fff;
            font-size: 2em;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }

        .evento-container {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 20px;
            width: 320px;
            margin: 10px;
            border-radius: 10px;
            color: #f1f1f1;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .evento-container h3 {
            margin: 0;
            font-size: 1.5em;
        }

        .evento-container p {
            margin: 10px 0;
        }

        a.botao-voltar {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #013220;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        a.botao-voltar:hover {
            background-color: #004d33;
        }
    </style>
</head>
<body>

<h2>Eventos Cadastrados</h2>

<?php if ($resultado->num_rows > 0): ?>
    <?php while ($evento = $resultado->fetch_assoc()): ?>
        <div class="evento-container">
            <h3><?php echo $evento['nome']; ?></h3>
            <p><strong>Data de Início:</strong> <?php echo $evento['data_inicio']; ?></p>
            <p><strong>Data de Término:</strong> <?php echo $evento['data_termino']; ?></p>
            <p><strong>Local:</strong> <?php echo $evento['local']; ?></p>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>Nenhum evento cadastrado ainda.</p>
<?php endif; ?>

<a href="tela_principal.php" class="botao-voltar">Voltar para a Tela Principal</a>

</body>
</html>
