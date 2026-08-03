<?php

require_once __DIR__ . "/config/config.php";

// Função auxiliar para exibir mensagem e voltar
function redirecionarErro($msg) {
    echo "<script>
            alert(" . json_encode($msg) . ");
            window.history.back();
          </script>";
    exit();
}

/* ==========================================================
   VERIFICA SE O FORMULÁRIO FOI ENVIADO
========================================================== */

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../cadastro.html");
    exit();
}

/* ==========================================================
   RECEBE OS DADOS DO FORMULÁRIO
========================================================== */

$tipo           = $_POST["tipoUsuario"] ?? '';
$nome           = trim($_POST["nome"] ?? '');
$documento      = preg_replace('/\D/', '', $_POST["documento"] ?? '');
$email          = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
$telefone       = preg_replace('/\D/', '', $_POST["telefone"] ?? '');

$senha          = $_POST["senha"] ?? '';
$confirmarSenha = $_POST["confirmar_senha"] ?? '';

/* ==========================================================
   VALIDAÇÕES BÁSICAS (CAMPOS COMUNS)
========================================================== */

if (empty($tipo) || empty($nome) || empty($documento) || empty($email) || empty($senha) || empty($confirmarSenha)) {
    redirecionarErro("Preencha todos os campos obrigatórios.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirecionarErro("Por favor, informe um e-mail válido.");
}

if ($senha !== $confirmarSenha) {
    redirecionarErro("As senhas não coincidem.");
}

if (strlen($senha) < 8) {
    redirecionarErro("A senha deve ter no mínimo 8 caracteres.");
}

/* ==========================================================
   VERIFICA SE O E-MAIL JÁ EXISTE EM QUALQUER UMA DAS TABELAS
========================================================== */

// Verifica na tabela egresso
$stmt = $conn->prepare("SELECT email FROM egresso WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    redirecionarErro("Este e-mail já está cadastrado no sistema.");
}

// Verifica na tabela empresa
$stmt = $conn->prepare("SELECT email FROM empresa WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    redirecionarErro("Este e-mail já está cadastrado no sistema.");
}

/* ==========================================================
   HASH DA SENHA
========================================================== */

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

/* ==========================================================
   CADASTRO DO EGRESSO
========================================================== */

if ($tipo === "egresso") {

    $cpf            = $documento;
    $dataNascimento = $_POST["data_nascimento"] ?? '';
    $cidade         = trim($_POST["cidade_egresso"] ?? '');

    if (empty($dataNascimento) || empty($cidade)) {
        redirecionarErro("Preencha a data de nascimento e a cidade do egresso.");
    }

    if (strlen($cpf) !== 11) {
        redirecionarErro("CPF inválido. Deve possuir 11 dígitos.");
    }

    /* Verifica CPF */
    $stmt = $conn->prepare("SELECT cpf FROM egresso WHERE cpf = ?");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();

    if ($stmt->get_result()->num_rows > 0) {
        redirecionarErro("CPF já cadastrado.");
    }

    /* Insere Egresso */
    $stmt = $conn->prepare("
        INSERT INTO egresso (cpf, nome, data_nascimento, email, telefone, cidade, senha)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "sssssss",
        $cpf,
        $nome,
        $dataNascimento,
        $email,
        $telefone,
        $cidade,
        $senhaHash
    );

    if ($stmt->execute()) {
        header("Location: ../login.html");
        exit();
    } else {
        redirecionarErro("Erro ao cadastrar egresso.");
    }

} 
/* ==========================================================
   CADASTRO DA EMPRESA
========================================================== */
else if ($tipo === "empresa") {

    $cnpj           = $documento;
    $cidadeInput    = trim($_POST["cidade_empresa"] ?? '');
    $bairro         = trim($_POST["bairro"] ?? '');
    $rua            = trim($_POST["rua"] ?? '');
    $numero         = trim($_POST["numero"] ?? '');
    $complemento    = trim($_POST["complemento"] ?? '');
    $cep            = preg_replace('/\D/', '', $_POST["cep"] ?? '');

    if (empty($cidadeInput) || empty($bairro) || empty($rua) || empty($numero) || empty($cep)) {
        redirecionarErro("Preencha todos os campos do endereço da empresa.");
    }

    if (strlen($cnpj) !== 14) {
        redirecionarErro("CNPJ inválido. Deve possuir 14 dígitos.");
    }

    // Trata Cidade e Estado vindo do ViaCEP ("Cidade - UF")
    $estado = "PR";
    $cidade = $cidadeInput;
    if (strpos($cidadeInput, ' - ') !== false) {
        $partes = explode(' - ', $cidadeInput);
        $cidade = $partes[0];
        $estado = $partes[1];
    }

    /* Verifica CNPJ */
    $stmt = $conn->prepare("SELECT cnpj FROM empresa WHERE cnpj = ?");
    $stmt->bind_param("s", $cnpj);
    $stmt->execute();

    if ($stmt->get_result()->num_rows > 0) {
        redirecionarErro("CNPJ já cadastrado.");
    }

    /* Insere Empresa */
    $stmt = $conn->prepare("
        INSERT INTO empresa (
            cnpj, razao_social, email, telefone, estado,
            cidade, bairro, rua, numero, complemento, cep, senha
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssssssssssss",
        $cnpj,
        $nome,
        $email,
        $telefone,
        $estado,
        $cidade,
        $bairro,
        $rua,
        $numero,
        $complemento,
        $cep,
        $senhaHash
    );

    if ($stmt->execute()) {
        header("Location: ../login.html");
        exit();
    } else {
        redirecionarErro("Erro ao cadastrar empresa.");
    }

} else {
    redirecionarErro("Tipo de usuário inválido.");
}
?>