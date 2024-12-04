<?php    
session_start();
if (!isset($_SESSION['organizador'])) {
    header('Location: Login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Tela Principal</title>
    <style>
        /* Fundo dinâmico animado */
        body {
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
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
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
        }

        /* Container principal dos recursos */
        .button-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            width: 90%;
            max-width: 600px;
            margin-top: 20px;
        }

        /* Estilo dos botões de recurso */
        .button-container button {
            background-color: rgba(255, 255, 255, 0.1); /* Fundo semi-transparente */
            border: 1px solid #4f5d4a; /* Verde escuro desbotado */
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            color: #f1f1f1;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s;
        }

        .button-container button:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-5px);
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.25);
        }

        .button-container button:active {
            transform: scale(0.98);
        }

        /* Botão de logout */
        .logout-button {
            background-color: #013220; /* Verde escuro */
            color: white;
            font-size: 16px;
            padding: 12px 22px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .logout-button:hover {
            background-color: #004d33; /* Verde mais claro no hover */
            transform: translateY(-5px);
        }

    </style>
</head>
<body>
    <h2>Bem-vindo, <?php echo htmlspecialchars($_SESSION['organizador']); ?>!</h2>
    
    <div class="button-container">
        <button onclick="window.location.href='cadastro_evento.php'">Cadastrar Evento</button>
        <button onclick="window.location.href='listar_eventos.php'">Listar Eventos</button>
        <button onclick="window.location.href='cadastro_atividades.php'">Cadastrar Atividades</button>
        <button onclick="window.location.href='Tela_atividades.php'">Tela Atividades</button>
    </div>

    <button class="logout-button" onclick="logout()">Sair</button>

    <script>
        function logout() {
            window.location.href = "Sair_sistema.php";
        }
    </script>
</body>
</html>
