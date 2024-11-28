<?php 
include_once ("topo.php");
include ("config.inc.php");
?>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entre em Contato</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .contato {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h3 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        label {
            font-size: 16px;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            transition: border-color 0.3s ease-in-out;
        }
        input:focus, textarea:focus {
            border-color: #007bff;
            background-color: #fff;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            font-size: 16px;
            padding: 12px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        textarea {
            height: 150px;
            resize: vertical;
        }
        .msg {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="contato">
        <h3>Entre em Contato</h3>
        <form action="enviar_contato.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="mensagem">Mensagem:</label>
            <textarea id="mensagem" name="mensagem" required></textarea>
            
            <input type="submit" value="Enviar">
        </form>
    </div>
</body>
</html>
