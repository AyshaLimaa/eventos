<!DOCTYPE html> 
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Novo Usuário</title>
    <style>
        /* Define the height of the full page and basic styling */
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to bottom, #013220, #000000); /* Verde e Preto */
        }

        /* Semi-transparent box for registration form */
        .register-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            width: 350px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
        }

        /* Title styling */
        h1 {
            margin-top: 0;
            color: white;
            font-size: 24px;
        }

        /* Input field labels */
        label {
            color: white;
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-size: 14px;
        }

        /* Input fields styling */
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }

        /* Submit button styling */
        button {
            width: 100%;
            padding: 10px;
            background-color: #013220; /* Verde escuro */
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #004d33; /* Verde mais claro no hover */
        }

        /* Error message styling */
        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="register-box">
    <h1>Cadastrar Novo Usuário</h1>
    <form method="POST" action="processa_cadastro_usuario.php">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        
        <button type="submit">Cadastrar</button>
    </form>
</div>

</body>
</html>
