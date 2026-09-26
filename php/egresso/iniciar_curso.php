<?php

require_once __DIR__ . "/../config/config.php";

exigirLogin();
exigirPerfil("egresso");

$cpf = $_SESSION["cpf"];

if (!isset($_POST["id_curso"]) || empty($_POST["id_curso"])) {
    die("Curso não informado.");
}

$id_curso = intval($_POST["id_curso"]);


/* Verifica se o curso existe */

$stmt = $conn->prepare("
    SELECT id_curso
    FROM curso
    WHERE id_curso = ?
");

$stmt->bind_param("i", $id_curso);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    die("Curso não encontrado.");
}


/* Verifica se o egresso já possui esse curso */

$stmt = $conn->prepare("
    SELECT status_curso
    FROM egresso_curso
    WHERE cpf_egresso = ?
    AND id_curso = ?
");

$stmt->bind_param("si", $cpf, $id_curso);
$stmt->execute();

$resultado = $stmt->get_result();


if ($resultado->num_rows > 0) {

    // Já existe a relação.
    // Não cria outra.

    echo "Curso já iniciado.";
    exit;
}


/* Cria a relação entre egresso e curso */

$stmt = $conn->prepare("
    INSERT INTO egresso_curso
    (cpf_egresso, id_curso, status_curso)
    VALUES (?, ?, 'Em Andamento')
");

$stmt->bind_param("si", $cpf, $id_curso);


if ($stmt->execute()) {

    echo "Curso iniciado com sucesso.";

} else {

    die("Erro ao iniciar o curso: " . $stmt->error);

}