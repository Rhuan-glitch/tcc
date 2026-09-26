<?php

require_once __DIR__ . "/../config/config.php";

exigirLogin();
exigirPerfil("egresso");

$cpf = $_SESSION["cpf"];

// Recebe os dados enviados pelo formulário
$nome = $_POST["nome"];
$email = $_POST["email"];
$telefone = $_POST["telefone"];
$data_nascimento = $_POST["data_nascimento"];
$cidade = $_POST["cidade"];
$area_interesse = $_POST["area_interesse"];

if (isset($_FILES["foto_perfil"]) && $_FILES["foto_perfil"]["error"] === UPLOAD_ERR_OK) {

    $foto = $_FILES["foto_perfil"];

    // Extensão do arquivo
    $extensao = strtolower(pathinfo($foto["name"], PATHINFO_EXTENSION));

    // Extensões permitidas
    $extensoesPermitidas = ["jpg", "jpeg", "png"];

    if (!in_array($extensao, $extensoesPermitidas)) {
        die("Formato de imagem não permitido.");
    }

    // Cria um nome único para a imagem
    $novoNome = uniqid("perfil_") . "." . $extensao;

    // Caminho onde a imagem será salva
    $pasta = __DIR__ . "/../uploads/";

    $caminho = $pasta . $novoNome;

    // Move a imagem para a pasta uploads
    if (!move_uploaded_file($foto["tmp_name"], $caminho)) {
        die("Erro ao salvar a imagem.");
    }

    // Salva o caminho da imagem no banco
    $foto_perfil = "php/uploads/" . $novoNome;

    $stmt = $conn->prepare("
        UPDATE egresso
        SET nome = ?,
            email = ?,
            telefone = ?,
            data_nascimento = ?,
            cidade = ?,
            area_interesse = ?,
            foto_perfil = ?
        WHERE cpf = ?
    ");

    $stmt->bind_param(
        "ssssssss",
        $nome,
        $email,
        $telefone,
        $data_nascimento,
        $cidade,
        $area_interesse,
        $foto_perfil,
        $cpf
    );

} else {

    // Se nenhuma foto foi enviada, atualiza somente os outros dados

    $stmt = $conn->prepare("
        UPDATE egresso
        SET nome = ?,
            email = ?,
            telefone = ?,
            data_nascimento = ?,
            cidade = ?,
            area_interesse = ?
        WHERE cpf = ?
    ");

    $stmt->bind_param(
        "sssssss",
        $nome,
        $email,
        $telefone,
        $data_nascimento,
        $cidade,
        $area_interesse,
        $cpf
    );
}

if ($stmt->execute()) {

    header("Location: ../../perfil_egresso.php");
    exit;

} else {

    die("Erro ao atualizar o perfil: " . $stmt->error);
}