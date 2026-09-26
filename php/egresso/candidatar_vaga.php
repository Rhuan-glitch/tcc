<?php

require_once __DIR__ . "/../config/config.php";

exigirLogin();
exigirPerfil("egresso");

$cpf = $_SESSION["cpf"];

if (!isset($_POST["id_vaga"]) || empty($_POST["id_vaga"])) {
    die("Vaga não informada.");
}

$id_vaga = intval($_POST["id_vaga"]);

// Verifica se a vaga existe
$stmt = $conn->prepare("
    SELECT id_vaga
    FROM vaga
    WHERE id_vaga = ?
");

$stmt->bind_param("i", $id_vaga);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    die("Vaga não encontrada.");
}


// Verifica se o egresso já se candidatou
$stmt = $conn->prepare("
    SELECT id_candidatura
    FROM egresso_vaga
    WHERE cpf_egresso = ?
    AND id_vaga = ?
");

$stmt->bind_param("si", $cpf, $id_vaga);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    die("Você já se candidatou a esta vaga.");
}


// Cadastra a candidatura
$stmt = $conn->prepare("
    INSERT INTO egresso_vaga
    (cpf_egresso, id_vaga, data_candidatura, status_candidatura)
    VALUES (?, ?, CURDATE(), 'Em Análise')
");

$stmt->bind_param("si", $cpf, $id_vaga);

if ($stmt->execute()) {

    header("Location: ../../perfil_egresso.php");
    exit;

} else {

    die("Erro ao realizar candidatura: " . $stmt->error);
}