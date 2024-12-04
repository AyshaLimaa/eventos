<?php   
session_start();
if (!isset($_SESSION['organizador'])) {
    header('Location: login.php');
    exit;
}

// Conectar ao banco de dados
include('../includes/db_connect.php');

// Buscar atividades cadastradas
$query = "SELECT * FROM Atividade";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Atividades</title>
    <style>
        /* Fundo dinâmico animado */
        body {
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
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
        h1 {
            color: #ffffff;
            font-size: 2.5em;
            margin: 20px 0;
            text-align: center;
            font-weight: bold;
        }

        /* Contêiner de atividades */
        .activities-container {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 80%;
            max-width: 600px;
            margin-bottom: 20px;
        }

        /* Estilo para lista de atividades */
        #activityList {
            list-style-type: none;
            padding: 0;
        }

        #activityList li {
            background-color: rgba(255, 255, 255, 0.1);
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #f1f1f1;
            font-size: 1.1em;
        }

        /* Estilo dos botões */
        .deleteBtn, .btn-voltar {
            background-color: #013220;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .deleteBtn:hover, .btn-voltar:hover {
            background-color: #004d33;
            transform: translateY(-3px);
        }

        /* Estilo do botão de voltar */
        .btn-voltar {
            display: inline-block;
            text-align: center;
            width: 100%;
            max-width: 250px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="activities-container">
        <h1>Atividades Cadastradas</h1>
        <ul id="activityList">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <li id="activity-<?php echo $row['ID']; ?>">
                    <div>
                        <strong><?php echo isset($row['Nome']) ? $row['Nome'] : 'Nome não disponível'; ?></strong><br>
                        <?php echo isset($row['Descricao']) ? $row['Descricao'] : 'Descrição não disponível'; ?><br>
                        <small><?php echo isset($row['Data']) ? $row['Data'] : 'Data não disponível'; ?></small>
                    </div>
                    <button class="deleteBtn" onclick="deleteActivity(<?php echo $row['ID']; ?>)">Excluir</button>
                </li>
            <?php } ?>
        </ul>
        <a href="Tela_principal.php" class="btn-voltar">Voltar</a>
    </div>

    <script>
        // Função de exclusão com AJAX
        function deleteActivity(activityId) {
            if (confirm("Você tem certeza que deseja excluir esta atividade?")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "Excluir_atividades.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = xhr.responseText;
                        if (response === "success") {
                            document.getElementById('activity-' + activityId).remove();
                            alert("Atividade excluída com sucesso!");
                        } else {
                            alert("Erro ao excluir a atividade. Tente novamente.");
                        }
                    }
                };
                xhr.send("delete_id=" + activityId);
            }
        }
    </script>
</body>
</html>

<?php
// Fecha a conexão com o banco de dados
mysqli_close($conn);
?>
