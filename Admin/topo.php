


<?php
ob_start();
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma de Filmes</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #141414;
            color: #fff;
            overflow-x: hidden;
        }

        .redd {
   color: red;
   font-weight: bold;
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
            background-color: #111;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            animation: fadeIn 1s ease-out;
        }

        header .logo img {
            height: 50px;
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
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            transition: color 0.3s, transform 0.3s;
        }

        nav ul li a:hover {
            color: #E50914;
            transform: scale(1.1);
        }

        .cta-button {
            margin-right: 30px;
            background-color: #E50914;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, color 0.3s, transform 0.3s;
        }

        .cta-button:hover {
            background-color: #f40612;
            color: #fff;
            transform: translateY(-3px);
        }

        main {
            padding: 80px 30px 30px; /* Ajuste para cabeçalho fixo */
        }

        section {
            padding: 40px 0;
            text-align: center;
            opacity: 0;
            animation: fadeIn 1.5s ease forwards;
        }

        section:nth-child(2) {
            animation-delay: 1s;
            background-color: #222;
        }

        section:nth-child(3) {
            animation-delay: 1.5s;
        }

        h1, h2 {
            font-size: 36px;
            color: #fff;
            margin-bottom: 20px;
            animation: fadeIn 2s ease;
        }

        p {
            font-size: 20px;
            color: #ccc;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.5;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }

        .grid-item {
            background-color: #333;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .grid-item:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.8);
        }

        .grid-item img {
            width: 100%;
            height: auto;
        }

        .grid-item .description {
            padding: 15px;
            text-align: left;
        }

        .grid-item .description h3 {
            margin: 0;
            color: #E50914;
            font-size: 20px;
        }

        .grid-item .description p {
            color: #ddd;
            font-size: 14px;
        }

        .hero-banner {
            border-radius: 30px;
            background-image: url('banner.jpg');
            background-size: cover;
            background-position: center;
            height: 600px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            position: relative;
        }

        .hero-banner h1 {
            font-size: 50px;
            text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.7);
        }

        .hero-banner .cta-button {
            position: absolute;
            bottom: 20px;
            padding: 15px 30px;
            font-size: 18px;
            background-color: #E50914;
            color: white;
            border-radius: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);
            transition: transform 0.3s;
        }

        .hero-banner .cta-button:hover {
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            header .logo img {
                height: 40px;
            }

            nav ul {
                flex-direction: column;
                gap: 10px;
            }

            .cta-button {
                font-size: 14px;
                padding: 10px 20px;
            }

            .hero-banner h1 {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>

<header>
<div class="logo">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="50" height="50">
            <g fill="none" stroke="#fff" stroke-width="2">
                <path d="M23 6h-4.18l-1.41-1.41C17.22 4.22 16.61 4 16 4H8c-.61 0-1.22.22-1.41.59L5.18 6H1c-.55 0-1 .45-1 1v16c0 .55.45 1 1 1h22c.55 0 1-.45 1-1V7c0-.55-.45-1-1-1zm-11 13c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm7-9h-6V5h4l2 2v3z"/>
            </g>
        </svg>
    </div>

    <nav>
        <ul>
            <li><a href="pginicial.php">Início</a></li>
        </ul>
    </nav>

    <a href="adicionafilme.php" class="cta-button">Adicionar Filme</a>
</header>

<main>
    <div class="hero-banner">
        <h1>Administrar Filmes e Comentários</h1>
    </div>


</main>

</body>
</html>
