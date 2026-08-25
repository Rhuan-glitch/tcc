<?php

require_once "../config/config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../trabalhista.php");
    exit;
}

$id_vaga = $_POST["id_vaga"] ?? null;

if (!$id_vaga) {
    die("ID da vaga não informado.");
}

$sql = "DELETE FROM vaga WHERE id_vaga = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar a exclusão: " . $conn->error);
}

$stmt->bind_param("i", $id_vaga);

if ($stmt->execute()) {
    header("Location: ../../trabalhista.php");
    exit;
} else {
    die("Erro ao excluir a vaga: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>