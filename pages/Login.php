<?php   
session_start();
include('../includes/db_connect.php');

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepara a consulta SQL para verificar o usuário
    $query = $conn->prepare("SELECT ID, Nome, Senha FROM organizador WHERE Email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if ($senha === $row['Senha']) {
            $_SESSION['organizador'] = $row['Nome']; 
            $_SESSION['organizador_id'] = $row['ID'];
            $_SESSION['loggedin'] = true;

            // Redireciona para a página principal
            header("Location: Tela_principal.php");
            exit;
        } else {
            $erro = "E-mail ou senha incorretos.";
        }
    } else {
        $erro = "E-mail ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Fundo dinâmico animado */
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: linear-gradient(135deg, #013220, #000000);
            background-size: 200% 200%;
            animation: gradientAnimation 10s ease infinite;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Caixa de login */
        .login-box {
            background: rgba(0, 0, 0, 0.6); /* Fundo semi-transparente */
            padding: 40px;
            border-radius: 10px;
            width: 350px;
            text-align: center;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.4);
            color: white;
        }

        /* Estilo do título */
        h2 {
            margin-top: 0;
            font-weight: bold;
            font-size: 24px;
            color: #fff;
        }

        /* Campos de entrada */
        label {
            color: white;
            display: block;
            text-align: left;
            margin-top: 10px;
            font-size: 14px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0 16px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            background-color: rgba(0, 50, 20, 0.6); /* Fundo semitransparente verde escuro */
            color: #fff;
            outline: none;
        }

        /* Estilo do botão de login */
        button {
            width: 100%;
            padding: 12px;
            background-color: #013220; /* Verde escuro */
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #004d33; /* Verde mais claro no hover */
            transform: scale(1.05);
        }

        /* Links de login */
        .login-links {
            margin-top: 15px;
            font-size: 14px;
            color: #f1f1f1;
        }

        .login-links a {
            color: #b0c4b1; /* Cinza esverdeado */
            text-decoration: none;
            margin-right: 10px;
        }

        .login-links a:hover {
            text-decoration: underline;
        }

        /* Mensagem de erro */
        .error {
            color: #ff4d4d;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>LOGIN</h2>
        <form method="POST">
            <label for="email">E-mail</label>
            <input type="text" id="email" name="email" placeholder="Digite o e-mail" required>
            
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" placeholder="Digite a sua senha" required>
            
            <button type="submit">Entrar</button>
        </form>

        <?php if (isset($erro)) { echo "<p class='error'>$erro</p>"; } ?>

        <div class="login-links">
            <a href="#">Esqueceu a senha?</a>
            <a href="cadastro_usuario.php">Criar uma conta</a>
        </div>
    </div>
</body>
</html>
