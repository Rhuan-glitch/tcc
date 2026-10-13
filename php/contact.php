<?php

require_once __DIR__ . "/config/config.php";

if (isset($_POST["submit"])) {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    $stmt = $conn->prepare("
        INSERT INTO contato (nome, email, assunto, mensagem)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param("ssss", $name, $email, $subject, $message);

    if ($stmt->execute()) {

        echo '
        <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Mensagem enviada - Plataforma 3R</title>

            <style>
                body {
                    margin: 0;
                    min-height: 100vh;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    background: #FEF8F4;
                    font-family: Arial, sans-serif;
                }

                .success-box {
                    background: white;
                    width: 90%;
                    max-width: 500px;
                    padding: 45px 35px;
                    text-align: center;
                    border-radius: 20px;
                    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
                }

                .check {
                    width: 70px;
                    height: 70px;
                    margin: 0 auto 20px;
                    border-radius: 50%;
                    background: #EDB064;
                    color: white;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 38px;
                    font-weight: bold;
                }

                h1 {
                    color: #333;
                    margin-bottom: 15px;
                }

                p {
                    color: #666;
                    font-size: 16px;
                    line-height: 1.6;
                }

                .btn {
                    display: inline-block;
                    margin-top: 20px;
                    padding: 12px 25px;
                    background: #ED9964;
                    color: white;
                    text-decoration: none;
                    border-radius: 10px;
                    font-weight: bold;
                }

                .btn:hover {
                    opacity: 0.9;
                }
            </style>
        </head>

        <body>

            <div class="success-box">

                <div class="check">✓</div>

                <h1>Mensagem enviada com sucesso!</h1>

                <p>
                    Obrigado por entrar em contato com a Plataforma 3R.
                    Sua mensagem foi registrada e será analisada pela nossa equipe.
                </p>

                <a href="../index.php" class="btn">Voltar para o início</a>

            </div>

        </body>
        </html>
        ';

    } else {

        echo "Erro ao salvar a mensagem: " . $stmt->error;

    }

    $stmt->close();
}

?>
