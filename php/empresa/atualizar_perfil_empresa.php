<?php
require_once __DIR__ . "/../config/config.php";

exigirLogin();
exigirPerfil("empresa");

$cnpj = $_SESSION["cnpj"];

// Recebe os dados enviados pelo formulário
$razao_social = $_POST["razao_social"];
$email = $_POST["email"];
$telefone = $_POST["telefone"];
$estado = $_POST["estado"];
$cidade = $_POST["cidade"];
$bairro = $_POST["bairro"];
$rua = $_POST["rua"];
$numero = $_POST["numero"];
$complemento = $_POST["complemento"];
$cep = $_POST["cep"];
$descricao_empresa = $_POST["descricao_empresa"];
 
$logo_empresa = null;

if (isset($_FILES["logo_empresa"]) && $_FILES["logo_empresa"]["error"] === UPLOAD_ERR_OK) {

    $nomeArquivo = $_FILES["logo_empresa"]["name"];
    $arquivoTemporario = $_FILES["logo_empresa"]["tmp_name"];

    $extensao = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));

    $extensoesPermitidas = ["jpg", "jpeg", "png", "webp"];

    if (!in_array($extensao, $extensoesPermitidas)) {
        die("Formato de imagem não permitido.");
    }

    // Cria um nome único para a imagem
    $novoNome = "empresa_" . $cnpj . "_" . time() . "." . $extensao;

    // Caminho físico onde a imagem será salva
    $pastaUpload = __DIR__ . "/../uploads/";

    // Cria a pasta caso ela não exista
    if (!is_dir($pastaUpload)) {
        mkdir($pastaUpload, 0777, true);
    }

    $caminhoCompleto = $pastaUpload . $novoNome;

    if (!move_uploaded_file($arquivoTemporario, $caminhoCompleto)) {
        die("Erro ao salvar a logo da empresa.");
    }

    // Caminho que será salvo no banco
    $logo_empresa = "php/uploads/" . $novoNome;
}
 
if ($logo_empresa !== null) {

    $stmt = $conn->prepare("
        UPDATE empresa
        SET razao_social = ?,
            email = ?,
            telefone = ?,
            estado = ?,
            cidade = ?,
            bairro = ?,
            rua = ?,
            numero = ?,
            complemento = ?,
            cep = ?,
            descricao_empresa = ?,
            logo_empresa = ?
        WHERE cnpj = ?
    ");

    $stmt->bind_param(
        "sssssssssssss",
        $razao_social,
        $email,
        $telefone,
        $estado,
        $cidade,
        $bairro,
        $rua,
        $numero,
        $complemento,
        $cep,
        $descricao_empresa,
        $logo_empresa,
        $cnpj
    );

} else {

    // Se nenhuma nova imagem foi escolhida,
    // mantém a logo que já estava salva.

    $stmt = $conn->prepare("
        UPDATE empresa
        SET razao_social = ?,
            email = ?,
            telefone = ?,
            estado = ?,
            cidade = ?,
            bairro = ?,
            rua = ?,
            numero = ?,
            complemento = ?,
            cep = ?,
            descricao_empresa = ?
        WHERE cnpj = ?
    ");

    $stmt->bind_param(
        "ssssssssssss",
        $razao_social,
        $email,
        $telefone,
        $estado,
        $cidade,
        $bairro,
        $rua,
        $numero,
        $complemento,
        $cep,
        $descricao_empresa,
        $cnpj
    );
}
if ($stmt->execute()) {

    header("Location: ../../perfil_empresa.php");
    exit;

} else {

    die("Erro ao atualizar o perfil: " . $stmt->error);
}