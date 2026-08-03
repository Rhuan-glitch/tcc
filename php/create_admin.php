<?php

require_once __DIR__ . "/config/config.php";

$usuario = 'admin';


$senha = '123456';


$hash = password_hash($senha, PASSWORD_DEFAULT);


$stmt = $conn->prepare("SELECT usuario FROM administrador WHERE usuario = ?");
$stmt->bind_param('s', $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    die("Administrador já existe.");
}

$stmt = $conn->prepare("INSERT INTO administrador (usuario, senha) VALUES (?, ?)");
$stmt->bind_param("ss", $usuario, $hash);

if ($stmt->execute()) {
    echo "Administrador criado com sucesso!";
} else {
    echo "Erro ao criar administrador.";
}
