<?php

require_once __DIR__ . "/../config/config.php";

exigirLogin();
exigirPerfil('egresso');

$cpf = $_SESSION["cpf"];


/* Recebe os dados do formulário */
$formacao = trim($_POST["formacao"] ?? "");
$experiencia = trim($_POST["experiencia_profissional"] ?? "");
$informacoes = trim($_POST["informacoes_adicionais"] ?? "");


/* Verifica se o egresso já possui currículo */
$stmt = $conn->prepare("
    SELECT cpf_egresso
    FROM curriculo
    WHERE cpf_egresso = ?
");

$stmt->bind_param("s", $cpf);
$stmt->execute();

$resultado = $stmt->get_result();


/* Se já existe, atualiza */
if ($resultado->num_rows === 1) {

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

    /* Se não existe, cria o currículo */
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


/* Executa */
if ($stmt->execute()) {

    header("Location: ../../perfil_egresso.php");
    exit;

} else {

    die("Erro ao salvar currículo: " . $stmt->error);
}