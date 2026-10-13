<?php

require_once __DIR__ . "/../config/config.php";

exigirLogin();
exigirPerfil("empresa");

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode([
        "erro" => "Método inválido."
    ]);
    exit;
}

$id_vaga = intval($_GET["id_vaga"] ?? 0);
$cnpj = $_SESSION["cnpj"] ?? "";

if ($id_vaga <= 0 || empty($cnpj)) {
    http_response_code(400);
    echo json_encode([
        "erro" => "Dados inválidos."
    ]);
    exit;
}

$stmt = $conn->prepare("
    SELECT
        ev.id_candidatura,
        ev.cpf_egresso,
        ev.data_candidatura,
        ev.status_candidatura,
        e.nome,
        e.email,
        e.telefone,
        e.cidade,
        e.area_interesse,
        e.foto_perfil,
        v.titulo_vaga
    FROM egresso_vaga ev
    INNER JOIN egresso e
        ON ev.cpf_egresso = e.cpf
    INNER JOIN vaga v
        ON ev.id_vaga = v.id_vaga
    WHERE ev.id_vaga = ?
    AND v.cnpj_empresa = ?
    ORDER BY ev.data_candidatura DESC
");

$stmt->bind_param("is", $id_vaga, $cnpj);
$stmt->execute();

$resultado = $stmt->get_result();

$candidaturas = [];

while ($candidatura = $resultado->fetch_assoc()) {
    $candidaturas[] = $candidatura;
}

echo json_encode($candidaturas, JSON_UNESCAPED_UNICODE);