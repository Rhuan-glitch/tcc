<?php

require_once "php/config/config.php";

// Verifica se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../login.html");
    exit();
}

// Recebe os dados enviados pelo formulário
$email = trim($_POST["email"]);
$senha = $_POST["senha"];

// Verifica se os campos foram preenchidos
if (empty($email) || empty($senha)) {
    die("Preencha todos os campos.");
}

/*
==========================================================
A PARTIR DAQUI ENTRARÁ A CONSULTA AO BANCO DE DADOS
==========================================================
*/

echo "Dados recebidos com sucesso!";

?>