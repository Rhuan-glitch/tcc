<?php

require_once __DIR__ . "/../config/config.php";
exigirPerfis(["empresa", "administrador"]);

/* ==========================================================
   1. PEGAR O CNPJ DA EMPRESA LOGADA
========================================================== */

// $cnpj_empresa = $_SESSION["cnpj"] ?? '';

// if (empty($cnpj_empresa)) {
//     echo "<script>
//             alert('Não foi possível identificar a empresa.');
//             window.location.href = '../../login.html';
//           </script>";
//     exit();
// }

/* ==========================================================
   2. VERIFICAR SE O FORMULÁRIO FOI ENVIADO
========================================================== */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../trabalhista.php");
    exit();
}

/* ==========================================================
   3. RECEBER OS DADOS
========================================================== */

$id_vaga        = intval($_POST["id_vaga"] ?? 0);
$titulo_vaga    = trim($_POST["titulo_vaga"] ?? '');
$area           = trim($_POST["area"] ?? '');
$cidade         = trim($_POST["cidade"] ?? '');
$descricao      = trim($_POST["descricao"] ?? '');
$requisitos     = trim($_POST["requisitos"] ?? '');
$beneficios     = trim($_POST["beneficios"] ?? '');
$carga_horaria  = intval($_POST["carga_horaria"] ?? 0);
$faixa_salarial = trim($_POST["faixa_salarial"] ?? '');
$tipo_contrato  = trim($_POST["tipo_contrato"] ?? '');
/* ==========================================================
   IMAGEM DA VAGA
========================================================== */

$novaImagem = null;

if (
    isset($_FILES["img_vaga"]) &&
    $_FILES["img_vaga"]["error"] === 0
) {

    $extensao = strtolower(
        pathinfo($_FILES["img_vaga"]["name"], PATHINFO_EXTENSION)
    );

    $extensoesPermitidas = ["jpg", "jpeg", "png", "webp"];

    if (!in_array($extensao, $extensoesPermitidas)) {
        die("Erro: formato de imagem não permitido.");
    }

    $novoNome = uniqid("vaga_", true) . "." . $extensao;

    $pastaUpload = __DIR__ . "/../uploads/";

    if (!is_dir($pastaUpload)) {
        mkdir($pastaUpload, 0777, true);
    }

    if (!move_uploaded_file(
        $_FILES["img_vaga"]["tmp_name"],
        $pastaUpload . $novoNome
    )) {
        die("Erro ao salvar a nova imagem da vaga.");
    }

    $novaImagem = "php/uploads/" . $novoNome;
}
/* ==========================================================
   4. VALIDAR OS CAMPOS
========================================================== */

if (
    $id_vaga <= 0 ||
    empty($titulo_vaga) ||
    empty($area) ||
    empty($cidade) ||
    empty($descricao) ||
    empty($requisitos) ||
    empty($beneficios) ||
    $carga_horaria <= 0 ||
    empty($faixa_salarial) ||
    empty($tipo_contrato)
) {
    die("Erro: preencha todos os campos obrigatórios.");
}

/* ==========================================================
   5. ATUALIZAR A VAGA
========================================================== */
if ($_SESSION["tipo"] === "administrador") {

$sql = "UPDATE vaga SET
            titulo_vaga = ?,
            area = ?,
            cidade = ?,
            descricao = ?,
            requisitos = ?,
            beneficios = ?,
            carga_horaria = ?,
            faixa_salarial = ?,
            tipo_contrato = ?
        WHERE id_vaga = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar atualização: " . $conn->error);
}

/* ==========================================================
   6. VINCULAR OS VALORES
========================================================== */

$stmt->bind_param(
    "ssssssissi",
    $titulo_vaga,
    $area,
    $cidade,
    $descricao,
    $requisitos,
    $beneficios,
    $carga_horaria,
    $faixa_salarial,
    $tipo_contrato,
    $id_vaga
);
} else {

    // EMPRESA SÓ PODE EDITAR SUAS PRÓPRIAS VAGAS

    $cnpj_empresa = $_SESSION["cnpj"] ?? '';

    if (empty($cnpj_empresa)) {
        die("Erro: não foi possível identificar a empresa.");
    }

    $sql = "UPDATE vaga SET
                titulo_vaga = ?,
                area = ?,
                cidade = ?,
                descricao = ?,
                requisitos = ?,
                beneficios = ?,
                carga_horaria = ?,
                faixa_salarial = ?,
                tipo_contrato = ?,
                img_vaga = COALESCE(?, img_vaga)
            WHERE id_vaga = ?
            AND cnpj_empresa = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Erro ao preparar atualização: " . $conn->error);
    }

    $stmt->bind_param(
        "ssssssisssis",
        $titulo_vaga,
        $area,
        $cidade,
        $descricao,
        $requisitos,
        $beneficios,
        $carga_horaria,
        $faixa_salarial,
        $tipo_contrato,
        $novaImagem,
        $id_vaga,
        $cnpj_empresa
    );
}

/* ==========================================================
   7. EXECUTAR
========================================================== */

if ($stmt->execute()) {

    // Verifica se alguma vaga realmente foi alterada
    if ($stmt->affected_rows > 0) {

        header("Location: ../../trabalhista.php");
        exit();

    } else {

        die("Erro: a vaga não existe ou você não tem permissão para editá-la.");
    }

} else {

    die("Erro ao editar vaga: " . $stmt->error);
}

?>