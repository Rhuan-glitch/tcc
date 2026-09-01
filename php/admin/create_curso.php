<?php

require_once __DIR__ . "/../config/config.php";
exigirPerfil('administrador');
/* ==========================================
   VERIFICA SE É ADMINISTRADOR
========================================== */

// if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] != "administrador") {
//     header("Location: ../login.html");
//     exit();
// }

/* ==========================================
   VERIFICA SE O FORMULÁRIO FOI ENVIADO
========================================== */

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: cadastrar_curso.php");
    exit();
}

/* ==========================================
   RECEBE OS DADOS
========================================== */

$nome_curso = trim($_POST["nome_curso"]);
$area = trim($_POST["area"]);
$carga_horaria = (int) $_POST["carga_horaria"];
$descricao = trim($_POST["descricao"]);
$conteudo_programatico = trim($_POST["conteudo_programatico"]);
$certificado = $_POST["certificado"];
$url_curso = trim($_POST["url_curso"]);

/* ==========================================
   VALIDAÇÃO
========================================== */

if (
    empty($nome_curso) ||
    empty($area) ||
    empty($carga_horaria) ||
    empty($descricao) ||
    empty($certificado) ||
    empty($url_curso)
) {
    die("Preencha todos os campos obrigatórios.");
}

/* ==========================================
   UPLOAD DA IMAGEM
========================================== */

$img_curso = NULL;

if (!empty($_FILES["img_curso"]["name"])) {

    $arquivo = $_FILES["img_curso"];

    $permitidos = ["jpg", "jpeg", "png", "webp"];

    $extensao = strtolower(pathinfo($arquivo["name"], PATHINFO_EXTENSION));

    if (!in_array($extensao, $permitidos)) {
        die("Formato de imagem inválido.");
    }

    if ($arquivo["size"] > 3 * 1024 * 1024) {
        die("Imagem maior que 3MB.");
    }

    $img_curso = uniqid("curso_") . "." . $extensao;

    $destino = __DIR__ . "/../uploads/" . $img_curso;

    if (!move_uploaded_file($arquivo["tmp_name"], $destino)) {
        die("Erro ao enviar a imagem.");
    }
}

/* ==========================================
   INSERT
========================================== */

$stmt = $conn->prepare("

INSERT INTO curso
(

nome_curso,
area,
carga_horaria,
descricao,
conteudo_programatico,
certificado,
img_curso,
url_curso

)

VALUES
(

?, ?, ?, ?, ?, ?, ?, ?

)

");

$stmt->bind_param(

"ssisssss",

$nome_curso,
$area,
$carga_horaria,
$descricao,
$conteudo_programatico,
$certificado,
$img_curso,
$url_curso

);

if($stmt->execute()){

    header("Location: ../../formacao.php");
    exit();

}else{

    die("Erro ao cadastrar curso: " . $conn->error);

}

?>