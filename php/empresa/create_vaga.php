<?php

session_start();

require_once __DIR__ . "/../config/config.php";
exigirPerfis(['empresa','administrador']);

 /* ==========================================================
    2. PEGAR O CNPJ DA EMPRESA LOGADA
 ========================================================== */

 $cnpj_empresa = $_SESSION["cnpj"] ?? '';

 if (empty($cnpj_empresa)) {
     echo "<script>
             alert('Não foi possível identificar a empresa.');
             window.location.href = '../../login.html';
           </script>";
     exit();
 }

 /* ==========================================================
    3. VERIFICAR SE O FORMULÁRIO FOI ENVIADO
 ========================================================== */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../trabalhista.php");
    exit();
}

/* ==========================================================
   4. RECEBER OS DADOS DO FORMULÁRIO
========================================================== */

$titulo_vaga     = trim($_POST["titulo_vaga"] ?? '');
$area            = trim($_POST["area"] ?? '');
$cidade          = trim($_POST["cidade"] ?? '');
$descricao       = trim($_POST["descricao"] ?? '');
$requisitos      = trim($_POST["requisitos"] ?? '');
$beneficios      = trim($_POST["beneficios"] ?? '');
$carga_horaria   = intval($_POST["carga_horaria"] ?? 0);
$faixa_salarial  = trim($_POST["faixa_salarial"] ?? '');
$tipo_contrato   = trim($_POST["tipo_contrato"] ?? '');
/* ==========================================================
   4.1 RECEBER E SALVAR IMAGEM DA VAGA
========================================================== */

$img_vaga = null;

if (isset($_FILES["img_vaga"]) && $_FILES["img_vaga"]["error"] === 0) {

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
        die("Erro ao salvar a imagem da vaga.");
    }

    $img_vaga = "php/uploads/" . $novoNome;
}
/* ==========================================================
   5. VALIDAR CAMPOS
========================================================== */

if (
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
   6. INSERIR A VAGA
========================================================== */

$sql = "INSERT INTO vaga (
            cnpj_empresa,
            titulo_vaga,
            area,
            cidade,
            descricao,
            requisitos,
            beneficios,
            carga_horaria,
            faixa_salarial,
            tipo_contrato,
            img_vaga,
            status,
            data_aprovacao
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?, 'Aguardando Aprovação', NULL)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar cadastro: " . $conn->error);
}

$stmt->bind_param(
    "sssssssisss",
    $cnpj_empresa,
    $titulo_vaga,
    $area,
    $cidade,
    $descricao,
    $requisitos,
    $beneficios,
    $carga_horaria,
    $faixa_salarial,
    $tipo_contrato,
    $img_vaga
);

/* ==========================================================
   7. EXECUTAR
========================================================== */

if ($stmt->execute()) {

    header("Location: ../../trabalhista.php");
    exit();

} else {

    die("Erro ao cadastrar vaga: " . $stmt->error);
}

?>