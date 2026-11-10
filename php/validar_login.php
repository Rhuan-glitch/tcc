<?php

require_once __DIR__ . "/config/config.php";

// Função para exibir erro amigável (estilizado) e voltar para o login
function falharLogin($mensagem = "Usuário ou senha inválidos.") {
    echo "<!DOCTYPE html>
    <html lang='pt-BR'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Erro de Login</title>
        <!-- Carrega o visual bonitinho da caixinha (SweetAlert2) -->
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <style>
            body { background-color: #f4f6f9; font-family: sans-serif; }
        </style>
    </head>
    <body>
        <script>
            // Dispara o alerta na tela
            Swal.fire({
                icon: 'error',
                title: 'Ops!',
                text: " . json_encode($mensagem) . ",
                confirmButtonColor: '#e74c3c',
                confirmButtonText: 'Tentar novamente'
            }).then((result) => {
                // Quando o usuário clica no botão, volta para o login
                window.location.href = '../login.php';
            });
        </script>
    </body>
    </html>";
    exit();
}

// Verifica se o formulário foi enviado via POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../login.html");
    exit();
}

// Recebe e limpa os dados do formulário
$login = trim($_POST["email"] ?? '');
$senha = $_POST["senha"] ?? '';

// Verifica se os campos foram preenchidos (AQUI ESTAVA O ERRO CORRIGIDO)
if (empty($login) || empty($senha)) {
    falharLogin("Preencha todos os campos.");
}

/* ==========================================================
   1. LOGIN DO ADMINISTRADOR
========================================================== */

$stmt = $conn->prepare("SELECT usuario, senha FROM administrador WHERE usuario = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 1) {
    $admin = $resultado->fetch_assoc();

    // Passando a variável $senha
    if (password_verify($senha, $admin["senha"])) {

        $_SESSION["usuario"] = $admin["usuario"];
        $_SESSION["tipo"]    = "administrador";

        header("Location: ../index.php");
        exit();
    }
}

/* ==========================================================
   2. LOGIN DA EMPRESA
========================================================== */

$stmt = $conn->prepare("SELECT cnpj, email, senha FROM empresa WHERE email = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 1) {
    $empresa = $resultado->fetch_assoc();

    // Usando $senha (em vez de $senhaHash)
    if (password_verify($senha, $empresa["senha"])) {

        $_SESSION["usuario"] = $empresa["email"];
        $_SESSION["tipo"]    = "empresa";
        $_SESSION["cnpj"]    = $empresa["cnpj"];

        header("Location: ../index.php");
        exit();
    }
}

/* ==========================================================
   3. LOGIN DO EGRESSO
========================================================== */

$stmt = $conn->prepare("SELECT cpf, email, senha FROM egresso WHERE email = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 1) {
    $egresso = $resultado->fetch_assoc();

    // Usando $senha 
    if (password_verify($senha, $egresso["senha"])) {

        $_SESSION["usuario"] = $egresso["email"];
        $_SESSION["tipo"]    = "egresso";
        $_SESSION["cpf"]     = $egresso["cpf"];

        header("Location: ../index.php");
        exit();
    }
}

/* ==========================================================
   SE CHEGOU ATÉ AQUI, O LOGIN OU SENHA ESTÃO INCORRETOS
========================================================== */
falharLogin();

?>