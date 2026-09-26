<?php

require_once __DIR__ . "/../config/config.php";

exigirLogin();
exigirPerfil('egresso');

$cpf = $_SESSION["cpf"];


/* =====================================================
   RECEBE OS DADOS
   ===================================================== */

/* Dados do formulário antigo */
$formacao = trim($_POST["formacao"] ?? "");
$experiencia = trim($_POST["experiencia_profissional"] ?? "");
$informacoes = trim($_POST["informacoes_adicionais"] ?? "");


/* =====================================================
   DADOS DO MODAL 2
   ===================================================== */

if (isset($_POST["escolaridade"])) {

    /* Escolaridade */
    $formacao = trim($_POST["escolaridade"] ?? "");


    /* Experiências */
    $experiencias = $_POST["experiencias"] ?? [];

    if (!empty($experiencias)) {
        $experiencia = implode("\n", $experiencias);
    } else {
        $experiencia = "";
    }


    /* Habilidades */
    $habilidades = $_POST["habilidades"] ?? [];


    /* Disponibilidade */
    $disponibilidades = $_POST["disponibilidade"] ?? [];


    /* Monta as informações adicionais */
    $partesInformacoes = [];


    if (!empty($habilidades)) {

        $partesInformacoes[] =
            "Habilidades:\n" .
            implode("\n", $habilidades);
    }


    if (!empty($disponibilidades)) {

        $partesInformacoes[] =
            "Disponibilidade:\n" .
            implode("\n", $disponibilidades);
    }


    $informacoes = implode("\n\n", $partesInformacoes);
}


/* =====================================================
   VERIFICA SE O EGRESSO JÁ POSSUI CURRÍCULO
   ===================================================== */

$stmt = $conn->prepare("
    SELECT cpf_egresso
    FROM curriculo
    WHERE cpf_egresso = ?
");

$stmt->bind_param("s", $cpf);
$stmt->execute();

$resultado = $stmt->get_result();


/* =====================================================
   ATUALIZA OU CRIA O CURRÍCULO
   ===================================================== */

if ($resultado->num_rows === 1) {

    /* Já existe → atualiza */

    $stmt = $conn->prepare("
        UPDATE curriculo
        SET
            formacao = ?,
            experiencia_profissional = ?,
            informacoes_adicionais = ?,
            data_atualizacao = NOW()
        WHERE cpf_egresso = ?
    ");

    $stmt->bind_param(
        "ssss",
        $formacao,
        $experiencia,
        $informacoes,
        $cpf
    );

} else {

    /* Não existe → cria */

    $stmt = $conn->prepare("
        INSERT INTO curriculo
        (
            cpf_egresso,
            formacao,
            experiencia_profissional,
            informacoes_adicionais,
            data_atualizacao
        )
        VALUES (?, ?, ?, ?, NOW())
    ");

    $stmt->bind_param(
        "ssss",
        $cpf,
        $formacao,
        $experiencia,
        $informacoes
    );
}


/* =====================================================
   EXECUTA
   ===================================================== */

if ($stmt->execute()) {

    header("Location: ../../perfil_egresso.php");
    exit;

} else {

    die("Erro ao salvar currículo: " . $stmt->error);
}