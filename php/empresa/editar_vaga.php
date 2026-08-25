<?php

session_start();

require_once __DIR__ . "/../config/config.php";

/* ==========================================================
   1. PEGAR O CNPJ DA EMPRESA LOGADA
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
        WHERE id_vaga = ?
        AND cnpj_empresa = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar atualização: " . $conn->error);
}

/* ==========================================================
   6. VINCULAR OS VALORES
========================================================== */

$stmt->bind_param(
    "ssssssissis",
    $titulo_vaga,
    $area,
    $cidade,
    $descricao,
    $requisitos,
    $beneficios,
    $carga_horaria,
    $faixa_salarial,
    $tipo_contrato,
    $id_vaga,
    $cnpj_empresa
);

/* ==========================================================
   7. EXECUTAR
========================================================== */

if ($stmt->execute()) {

    header("Location: ../../trabalhista.php");
    exit();

} else {

    die("Erro ao editar vaga: " . $stmt->error);
}

?>