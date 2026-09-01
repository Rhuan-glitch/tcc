<?php

require_once __DIR__ . "/../config/config.php";
exigirPerfil('administrador');
/* ==========================================================
   VERIFICA LOGIN
========================================================== */

// if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] != "administrador") {
//     header("Location: ../../login.html");
//     exit();
// }

/* ==========================================================
   EXCLUI CURSO
========================================================== */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = (int)($_POST["id"] ?? 0);

    /* ======================================================
       BUSCA A IMAGEM
    ====================================================== */

    $stmt = $conn->prepare("
        SELECT img_curso
        FROM curso
        WHERE id_curso = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $resultado = $stmt->get_result();

    $curso = $resultado->fetch_assoc();

    /* ======================================================
       APAGA A IMAGEM
    ====================================================== */

    if (
        $curso &&
        !empty($curso["img_curso"]) &&
        file_exists(__DIR__ . "/../uploads/" . $curso["img_curso"])
    ) {

        unlink(__DIR__ . "/../uploads/" . $curso["img_curso"]);

    }

    /* ======================================================
       APAGA DO BANCO
    ====================================================== */

    $stmt = $conn->prepare("
        DELETE FROM curso
        WHERE id_curso = ?
    ");

    $stmt->bind_param("i", $id);

    $stmt->execute();

}

/* ==========================================================
   RETORNA PARA A FORMAÇÃO
========================================================== */

header("Location: ../../formacao.php");
exit();