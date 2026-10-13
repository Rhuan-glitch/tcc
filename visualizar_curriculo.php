<?php

require_once __DIR__ . "/php/config/config.php";

exigirLogin();


/* =====================================================
   VERIFICA QUAL PERFIL ESTÁ ACESSANDO
   ===================================================== */

$tipo = $_SESSION["tipo"] ?? "";


/* =====================================================
   EMPRESA
   ===================================================== */

if ($tipo === "empresa") {

    exigirPerfil("empresa");

    $id_candidatura = intval($_GET["id_candidatura"] ?? 0);
    $cnpj = $_SESSION["cnpj"] ?? "";

    if ($id_candidatura <= 0 || empty($cnpj)) {
        die("Dados inválidos.");
    }


    /* =================================================
       BUSCA O CANDIDATO E O CURRÍCULO
       ================================================= */

    $stmt = $conn->prepare("
        SELECT
            e.nome,
            e.email,
            e.telefone,
            e.cidade,
            e.area_interesse,
            e.foto_perfil,

            c.formacao,
            c.experiencia_profissional,
            c.informacoes_adicionais,
            c.data_atualizacao

        FROM egresso_vaga ev

        INNER JOIN egresso e
            ON ev.cpf_egresso = e.cpf

        INNER JOIN vaga v
            ON ev.id_vaga = v.id_vaga

        LEFT JOIN curriculo c
            ON e.cpf = c.cpf_egresso

        WHERE ev.id_candidatura = ?
        AND v.cnpj_empresa = ?
    ");

    $stmt->bind_param(
        "is",
        $id_candidatura,
        $cnpj
    );

    $stmt->execute();

    $resultado = $stmt->get_result();


    if ($resultado->num_rows !== 1) {
        die("Currículo não encontrado.");
    }


    $curriculo = $resultado->fetch_assoc();


}


/* =====================================================
   EGRESSO
   ===================================================== */

elseif ($tipo === "egresso") {

    exigirPerfil("egresso");

    $cpf = $_SESSION["cpf"] ?? "";

    if (empty($cpf)) {
        die("Dados inválidos.");
    }


    /* =================================================
       BUSCA O EGRESSO E O CURRÍCULO
       ================================================= */

    $stmt = $conn->prepare("
        SELECT
            e.nome,
            e.email,
            e.telefone,
            e.cidade,
            e.area_interesse,
            e.foto_perfil,

            c.formacao,
            c.experiencia_profissional,
            c.informacoes_adicionais,
            c.data_atualizacao

        FROM egresso e

        LEFT JOIN curriculo c
            ON e.cpf = c.cpf_egresso

        WHERE e.cpf = ?
    ");


    $stmt->bind_param(
        "s",
        $cpf
    );

    $stmt->execute();

    $resultado = $stmt->get_result();


    if ($resultado->num_rows !== 1) {
        die("Currículo não encontrado.");
    }


    $curriculo = $resultado->fetch_assoc();


}


/* =====================================================
   PERFIL INVÁLIDO
   ===================================================== */

else {

    die("Perfil não autorizado.");

}


/* =====================================================
   ORGANIZA HABILIDADES E DISPONIBILIDADE
   ===================================================== */

$habilidades = [];
$disponibilidades = [];

if (!empty($curriculo["informacoes_adicionais"])) {

    $partes = explode(
        "\n\n",
        $curriculo["informacoes_adicionais"]
    );

    foreach ($partes as $parte) {

        if (strpos($parte, "Habilidades:") === 0) {

            $texto = str_replace(
                "Habilidades:\n",
                "",
                $parte
            );

            $habilidades = array_values(
                array_filter(
                    explode("\n", $texto)
                )
            );
        }


        if (strpos($parte, "Disponibilidade:") === 0) {

            $texto = str_replace(
                "Disponibilidade:\n",
                "",
                $parte
            );

            $disponibilidades = array_values(
                array_filter(
                    explode("\n", $texto)
                )
            );
        }
    }
}

?>


<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Currículo - <?= htmlspecialchars($curriculo["nome"]) ?>
    </title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f8f6f2;
            margin: 0;
            padding: 40px;
            color: #333;
        }

        .curriculo {
            max-width: 850px;
            margin: auto;
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        }

        .cabecalho {
            border-bottom: 2px solid #edc764;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .cabecalho h1 {
            margin: 0 0 8px;
            font-size: 30px;
        }

        .cabecalho p {
            margin: 5px 0;
        }

        .secao {
            margin-bottom: 25px;
        }

        .secao h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .secao p {
            margin: 6px 0;
            line-height: 1.5;
        }

        .tag {
            display: inline-block;
            padding: 8px 12px;
            margin: 4px;
            border-radius: 8px;
            background: #fff3cd;
            border: 1px solid #edc764;
        }

        .botoes {
            text-align: center;
            margin-top: 30px;
        }

        .botoes button {
            border: none;
            padding: 12px 22px;
            border-radius: 8px;
            cursor: pointer;
            background: #edc764;
            font-weight: bold;
        }

        @media print {

            body {
                background: white;
                padding: 0;
            }

            .curriculo {
                box-shadow: none;
                max-width: none;
            }

            .botoes {
                display: none;
            }

        }

    </style>

</head>


<body>

<div class="curriculo">


    <!-- =====================================================
         CABEÇALHO
         ===================================================== -->

    <div class="cabecalho">

        <h1>
            <?= htmlspecialchars($curriculo["nome"]) ?>
        </h1>

        <p>
            <strong>
                Área de interesse:
            </strong>

            <?= htmlspecialchars(
                $curriculo["area_interesse"] ?: "Não informada"
            ) ?>
        </p>

        <p>
            <strong>
                Cidade:
            </strong>

            <?= htmlspecialchars(
                $curriculo["cidade"] ?: "Não informada"
            ) ?>
        </p>

        <p>
            <strong>
                E-mail:
            </strong>

            <?= htmlspecialchars(
                $curriculo["email"] ?: "Não informado"
            ) ?>
        </p>

        <p>
            <strong>
                Telefone:
            </strong>

            <?= htmlspecialchars(
                $curriculo["telefone"] ?: "Não informado"
            ) ?>
        </p>

    </div>


    <!-- =====================================================
         ESCOLARIDADE
         ===================================================== -->

    <div class="secao">

        <h2>
            🎓 Escolaridade
        </h2>

        <p>
            <?= nl2br(
                htmlspecialchars(
                    $curriculo["formacao"] ?: "Não informado"
                )
            ) ?>
        </p>

    </div>


    <!-- =====================================================
         EXPERIÊNCIAS
         ===================================================== -->

    <div class="secao">

        <h2>
            💼 Experiências
        </h2>

        <?php if (!empty($curriculo["experiencia_profissional"])): ?>

            <?php foreach (
                explode("\n", $curriculo["experiencia_profissional"])
                as $experiencia
            ): ?>

                <?php if (trim($experiencia) !== ""): ?>

                    <p>
                        • <?= htmlspecialchars($experiencia) ?>
                    </p>

                <?php endif; ?>

            <?php endforeach; ?>

        <?php else: ?>

            <p>
                Não informado.
            </p>

        <?php endif; ?>

    </div>


    <!-- =====================================================
         HABILIDADES
         ===================================================== -->

    <div class="secao">

        <h2>
            ⭐ Habilidades
        </h2>

        <?php if (!empty($habilidades)): ?>

            <?php foreach ($habilidades as $habilidade): ?>

                <span class="tag">
                    <?= htmlspecialchars($habilidade) ?>
                </span>

            <?php endforeach; ?>

        <?php else: ?>

            <p>
                Não informado.
            </p>

        <?php endif; ?>

    </div>


    <!-- =====================================================
         DISPONIBILIDADE
         ===================================================== -->

    <div class="secao">

        <h2>
            🕐 Disponibilidade
        </h2>

        <?php if (!empty($disponibilidades)): ?>

            <?php foreach ($disponibilidades as $disponibilidade): ?>

                <span class="tag">
                    <?= htmlspecialchars($disponibilidade) ?>
                </span>

            <?php endforeach; ?>

        <?php else: ?>

            <p>
                Não informado.
            </p>

        <?php endif; ?>

    </div>


    <!-- =====================================================
         BOTÃO
         ===================================================== -->

    <div class="botoes">

        <button
            type="button"
            onclick="window.print()"
        >
            Imprimir / Salvar PDF
        </button>

    </div>


</div>

</body>

</html>