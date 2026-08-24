<?php

session_start();

require_once __DIR__ . "/../config/config.php";

//  /* ==========================================================
//     1. VERIFICAR SE É UMA EMPRESA LOGADA
//  ========================================================== */

//  if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== "empresa") {
//      header("Location: ../../login.html");
//      exit();
//  }

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
            status,
            data_aprovacao
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Aguardando Aprovação', NULL)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar cadastro: " . $conn->error);
}

$stmt->bind_param(
    "sssssssiss",
    $cnpj_empresa,
    $titulo_vaga,
    $area,
    $cidade,
    $descricao,
    $requisitos,
    $beneficios,
    $carga_horaria,
    $faixa_salarial,
    $tipo_contrato
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