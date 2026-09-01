<?php

require_once "../config/config.php";
exigirPerfis(["empresa", "administrador"]);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../trabalhista.php");
    exit;
}

$id_vaga = $_POST["id_vaga"] ?? null;

if (!$id_vaga) {
    die("ID da vaga não informado.");
}
if ($_SESSION["tipo"] === "administrador") {

    $sql = "DELETE FROM vaga
            WHERE id_vaga = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar a exclusão: " . $conn->error);
    }

    $stmt->bind_param("i", $id_vaga);
}


/* ==========================================================
   5. EMPRESA
========================================================== */

else if ($_SESSION["tipo"] === "empresa") {

    $cnpj_empresa = $_SESSION["cnpj"] ?? '';

    if (empty($cnpj_empresa)) {
        die("Erro: não foi possível identificar a empresa.");
    }

    $sql = "DELETE FROM vaga
            WHERE id_vaga = ?
            AND cnpj_empresa = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar a exclusão: " . $conn->error);
    }

    $stmt->bind_param(
        "is",
        $id_vaga,
        $cnpj_empresa
    );
}


/* ==========================================================
   6. EXECUTAR
========================================================== */

if ($stmt->execute()) {

    header("Location: ../../trabalhista.php");
    exit();

} else {

    die("Erro ao excluir a vaga: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>