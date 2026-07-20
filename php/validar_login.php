<?php

require_once "config/config.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../login.html");
    exit();
}

// Recebe os dados do formulário
$email = trim($_POST["email"]);
$senha = $_POST["senha"];

// Validação simples
if (empty($email) || empty($senha)) {
    die("Preencha todos os campos.");
}

// Aqui será feita a autenticação no banco de dados.

echo "Login recebido com sucesso!";