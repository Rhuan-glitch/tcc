<?php

require_once __DIR__ . "/php/config/config.php";

exigirLogin();
exigirPerfil("egresso");

$cpf = $_SESSION["cpf"];

/* Busca os dados do egresso */
$stmt = $conn->prepare("
    SELECT nome, email, telefone, cidade, area_interesse
    FROM egresso
    WHERE cpf = ?
");

$stmt->bind_param("s", $cpf);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    die("Egresso não encontrado.");
}

$egresso = $resultado->fetch_assoc();


/* Busca os dados do currículo */
$stmtCurriculo = $conn->prepare("
    SELECT
        formacao,
        experiencia_profissional,
        informacoes_adicionais
    FROM curriculo
    WHERE cpf_egresso = ?
");

$stmtCurriculo->bind_param("s", $cpf);
$stmtCurriculo->execute();

$resultadoCurriculo = $stmtCurriculo->get_result();

if ($resultadoCurriculo->num_rows === 1) {

    $curriculo = $resultadoCurriculo->fetch_assoc();

} else {

    $curriculo = [
        "formacao" => "",
        "experiencia_profissional" => "",
        "informacoes_adicionais" => ""
    ];
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <title>Currículo - <?= htmlspecialchars($egresso["nome"]) ?></title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 30px;
        }

        .curriculo {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 40px;
        }

        h1 {
            margin-bottom: 5px;
        }

        h2 {
            margin-top: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .dados {
            color: #555;
        }

        .secao {
            margin-top: 20px;
        }

        .botoes {
            max-width: 800px;
            margin: 20px auto;
            text-align: center;
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
        }

        @media print {

            body {
                background: white;
                padding: 0;
            }

            .botoes {
                display: none;
            }

            .curriculo {
                box-shadow: none;
            }

        }

    </style>

</head>

<body>

    <div class="botoes">

        <button onclick="window.print()">
            Salvar / Imprimir PDF
        </button>

    </div>


    <div class="curriculo">

        <h1>
            <?= htmlspecialchars($egresso["nome"]) ?>
        </h1>

        <div class="dados">

            <p>
                <?= htmlspecialchars($egresso["email"]) ?>
            </p>

            <p>
                <?= htmlspecialchars($egresso["telefone"]) ?>
            </p>

            <p>
                <?= htmlspecialchars($egresso["cidade"]) ?>
            </p>

            <p>
                Área de interesse:
                <?= htmlspecialchars($egresso["area_interesse"]) ?>
            </p>

        </div>


        <div class="secao">

            <h2>Formação</h2>

            <p>
                <?= nl2br(htmlspecialchars($curriculo["formacao"])) ?>
            </p>

        </div>


        <div class="secao">

            <h2>Experiência profissional</h2>

            <p>
                <?= nl2br(htmlspecialchars($curriculo["experiencia_profissional"])) ?>
            </p>

        </div>


        <div class="secao">

            <h2>Informações adicionais</h2>

            <p>
                <?= nl2br(htmlspecialchars($curriculo["informacoes_adicionais"])) ?>
            </p>

        </div>

    </div>

</body>

</html>