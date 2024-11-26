<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Site</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Estilo do cabeçalho */
        header {
            background: linear-gradient(135deg, #5A17EA, #9927EA); /* Gradiente usando as duas cores */
            color: white;
            padding: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        /* Logo */
        .logo img {
            height: 50px;
        }

        /* Menu de navegação */
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 20px;
        }

        nav ul li {
            display: inline;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #FFD700; /* Cor do hover dos links */
        }

        /* Botão de ação */
        .cta-btn {
            background-color: #FFD700; /* Cor do botão */
            color: #9927EA; /* Cor do texto do botão */
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s, color 0.3s;
        }

        .cta-btn:hover {
            background-color: #ffbb33; /* Cor do hover do botão */
            color: #B80BEB; /* Mudança na cor do texto no hover */
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <!-- Substitua o "logo.png" pelo caminho real do seu logotipo -->
        <img src="logo.png" alt="Logo do Site">
    </div>
    
    <nav>
        <ul>
            <li><a href="index.php">Início</a></li>
            <li><a href="#">Sobre</a></li>
            <li><a href="#">Serviços</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="contato.php">Contato</a></li>
        </ul>
    </nav>
    
    <a href="#contato" class="cta-btn">Fale Conosco</a>
</header>

</body>
</html>
