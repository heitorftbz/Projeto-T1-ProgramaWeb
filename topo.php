<?php
session_start();
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Site</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            overflow-x: hidden;
        }


        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
       header {
            background: linear-gradient(135deg, #5A17EA, #9927EA);
            padding: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            color: white;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-out;
        }

        header .logo img {
            height: 60px;
            border-radius: 5px;
            transition: transform 0.3s ease;
        }

        header .logo img:hover {
            transform: scale(1.1);
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 30px;
            animation: fadeIn 1.5s ease-out;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            font-weight: bold;
            transition: color 0.3s, transform 0.3s;
        }

        nav ul li a:hover {
            color: #FFD700;
            transform: scale(1.1);
        }

        a[href="#contato"] {
            background-color: #FFD700;
            color: #9927EA;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, color 0.3s, transform 0.3s;
            animation: fadeIn 2s ease-out;
        }

        a[href="#contato"]:hover {
            background-color: #9927EA;
            color: white;
            transform: translateY(-3px);
        }

        main {
            padding: 30px;
            padding-top: 100px;
        }

        section {
            padding: 40px 0;
            text-align: center;
            opacity: 0;
            animation: fadeIn 1.5s ease forwards;
        }

        section:nth-child(2) {
            animation-delay: 1s;
        }

        section:nth-child(3) {
            animation-delay: 1.5s;
        }

        h1, h2 {
            font-size: 36px;
            color: #333;
            margin-bottom: 20px;
            animation: fadeIn 2s ease;
        }

        p {
            font-size: 20px;
            color: #555;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.5;
        }

        section:nth-child(2) {
            background-color: #f4f4f9;
        }

        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                gap: 10px;
            }

            a[href="#contato"] {
                font-size: 14px;
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="logo.png" alt="Logo do Site">
    </div>

    <nav>
        <ul>
            <li><a href="pginicial.php">Início</a></li>
            <li><a href="contato.php">Contato</a></li>
            <li><a href="adicionafilme.php">Adicionar filme</a></li>
        </ul>
    </nav>

    <a href="#contato">Fale Conosco</a>
</header>

<main>
    <section>
       <script type="module" src=""></script>
    </section>

    <section>
        <h2>Sobre o site</h2>
        <p>Este site foi feito para ilustrar boas práticas em HTML, com uma estrutura semântica clara, tornando-o mais acessível e amigável para os usuários e motores de busca.</p>
    </section>
</main>

</body>
</html>
