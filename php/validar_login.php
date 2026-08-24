<?php
// 1. OBRIGATÓRIO: Inicia a sessão para conseguir gravar $_SESSION
session_start();

require_once __DIR__ . "/config/config.php";

// Função para exibir erro amigável e voltar para o login
function falharLogin($mensagem = "Usuário ou senha inválidos.") {
    echo "<script>
            alert(" . json_encode($mensagem) . ");
            window.location.href = '../login.html';
          </script>";
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

// Verifica se os campos foram preenchidos
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

    // CORRIGIDO: Passando a variável $senha
    if (password_verify($senha, $admin["senha"])) {

        $_SESSION["usuario"] = $admin["usuario"];
        $_SESSION["tipo"]    = "administrador";

        header("Location: ../php/admin/dashboard.php");
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

    // CORRIGIDO: Usando $senha (em vez de $senhaHash)
    if (password_verify($senha, $empresa["senha"])) {

        $_SESSION["usuario"] = $empresa["email"];
        $_SESSION["tipo"]    = "empresa";
        $_SESSION["cnpj"]    = $empresa["cnpj"];

        header("Location: ../empresa/dashboard.php");
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

    // CORRIGIDO: Usando $senha (em vez de $senhaHas)
    if (password_verify($senha, $egresso["senha"])) {

        $_SESSION["usuario"] = $egresso["email"];
        $_SESSION["tipo"]    = "egresso";
        $_SESSION["cpf"]     = $egresso["cpf"];

        header("Location: ../egresso/dashboard.php");
        exit();
    }
}

/* ==========================================================
   SE CHEGOU ATÉ AQUI, O LOGIN OU SENHA ESTÃO INCORRETOS
========================================================== */
falharLogin();

?>