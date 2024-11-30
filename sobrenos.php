<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('https://telaviva.com.br/wp-content/uploads/2022/05/streaming.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .overlay {
            background: rgba(0, 0, 0, 0.8);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .container {
            padding: 40px;
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }

        h1 {
            font-size: 48px;
            color: #e50914;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }

        p {
            font-size: 20px;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .team {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .team-member {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 200px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8);
        }

        .team-member img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 10px;
            border: 3px solid #e50914;
        }

        .team-member h3 {
            font-size: 18px;
            color: #e50914;
            margin-bottom: 10px;
        }

        .team-member p {
            font-size: 16px;
            margin: 0;
        }

        .btn-back {
            display: inline-block;
            background-color: #e50914;
            color: #fff;
            padding: 14px 28px;
            font-size: 18px;
            border-radius: 8px;
            margin-top: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #f40612;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            h1 {
                font-size: 36px;
            }

            .team-member {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="overlay"></div>
    <div class="container">
        <h1>Sobre Nós</h1>
        <p>
            Bem-vindo à nossa plataforma! Apaixonados por entretenimento, criamos esta experiência para você explorar e organizar seus filmes favoritos.
        </p>
        <p>
            Nossa equipe trabalha para garantir que você tenha acesso às melhores ferramentas e informações de forma simples e intuitiva.
        </p>

        <div class="team">
            <div class="team-member">
                <img src="imagens/Leonardo.jpg" alt="Leonardo">
                <h3>Leonardo Heim Monteiro</h3>
                <p>Desenvolvedor</p>
            </div>
            <div class="team-member">
                <img src="imagens/Jean.png" alt="Jean">
                <h3>Jean</h3>
                <p>Desenvolvedor</p>
            </div>
            <div class="team-member">
                <img src="imagens/Heitor.png" alt="Heitor">
                <h3>Heitor</h3>
                <p>Desenvolvedor</p>
            </div>
            <div class="team-member">
                <img src="imagens/Ryck.png" alt="Ryck">
                <h3>Ryck</h3>
                <p>Desenvolvedor</p>
            </div>
            <div class="team-member">
                <img src="imagens/Fábio.png" alt="Fábio">
                <h3>Fábio</h3>
                <p>Desenvolvedor</p>
            </div>
        </div>

        <a href="pginicial.php" class="btn-back">Voltar à Página Inicial</a>
    </div>
</body>
</html>
