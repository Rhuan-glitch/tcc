<?php

require_once __DIR__ . "/../config/config.php";

exigirLogin();
exigirPerfil("egresso");

$cpf = $_SESSION["cpf"];

if (!isset($_POST["id_curso"]) || empty($_POST["id_curso"])) {
    die("Curso não informado.");
}

$id_curso = intval($_POST["id_curso"]);


/* Atualiza o curso para concluído */

$stmt = $conn->prepare("
    UPDATE egresso_curso
    SET status_curso = 'Concluído'
    WHERE cpf_egresso = ?
    AND id_curso = ?
    AND status_curso = 'Em Andamento'
");

$stmt->bind_param("si", $cpf, $id_curso);

if ($stmt->execute()) {

    header("Location: ../../perfil_egresso.php");
    exit;

} else {

    die("Erro ao concluir o curso: " . $stmt->error);

}