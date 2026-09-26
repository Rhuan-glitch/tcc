<?php

require_once __DIR__ . "/php/config/config.php";

exigirLogin();
exigirPerfil("egresso");

$cpf = $_SESSION["cpf"];

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
$stmtCurriculo = $conn->prepare("
    SELECT 
        informacoes_adicionais,
        experiencia_profissional,
        formacao,
        data_atualizacao
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
        "informacoes_adicionais" => "",
        "experiencia_profissional" => "",
        "formacao" => "",
        "data_atualizacao" => null
    ];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Currículo - Plataforma 3R</title>

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/perfil_egresso.css">

</head>

<body>

<?php include 'nav-bar.php'; ?>

<section class="section-top perfil-banner"
    style="background-image:url(assets/img/bg/section-top.png);
           background-size:cover;
           background-position:center;">

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center"></div>
        </div>
    </div>

</section>


<section class="perfil-egresso section-padding">

    <div class="container">

        <div class="section-title text-center">

            <h2>Editar Currículo</h2>

            <p>
                Preencha suas informações profissionais para aumentar suas oportunidades na Plataforma 3R.
            </p>

        </div>


        <div class="row">

            <div class="col-lg-12">

                <div class="perfil-card">

                    <h3>Informações do Currículo</h3>

                    <p class="mt-3">
                        Essas informações poderão ser utilizadas para apresentar seu perfil profissional às empresas.
                    </p>


                    <!-- DADOS BÁSICOS -->

                    <div class="row mt-4">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Nome</label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?= htmlspecialchars($egresso['nome']) ?>"
                                    disabled
                                >

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Área de Interesse</label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?= htmlspecialchars($egresso['area_interesse']) ?>"
                                    disabled
                                >

                            </div>

                        </div>

                    </div>


                    <div class="row mt-3">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>E-mail</label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?= htmlspecialchars($egresso['email']) ?>"
                                    disabled
                                >

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Telefone</label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?= htmlspecialchars($egresso['telefone']) ?>"
                                    disabled
                                >

                            </div>

                        </div>

                    </div>

                <form action="php/egresso/atualizar_curriculo.php" method="POST">
                    <!-- FORMAÇÃO -->

                    <div class="form-group mt-4">

                        <label>Formação</label>

                        <textarea
                            name="formacao"
                            class="form-control"
                            rows="5"
                            placeholder="Informe sua formação acadêmica e profissional."
                        ><?= htmlspecialchars($curriculo['formacao']) ?></textarea>

                    </div>


                    <!-- EXPERIÊNCIA -->

                    <div class="form-group mt-4">

                        <label>Experiência Profissional</label>

                        <textarea
                            name="experiencia_profissional"
                            class="form-control"
                            rows="6"
                            placeholder="Descreva suas experiências profissionais, funções exercidas e atividades realizadas."
                        ><?= htmlspecialchars($curriculo['experiencia_profissional']) ?></textarea>

                    </div>


                    <!-- INFORMAÇÕES ADICIONAIS -->

                    <div class="form-group mt-4">

                        <label>Informações Adicionais</label>

                        <textarea
                            name="informacoes_adicionais"
                            class="form-control"
                            rows="5"
                            placeholder="Informe outras habilidades, conhecimentos, objetivos profissionais ou informações relevantes."
                        ><?= htmlspecialchars($curriculo['informacoes_adicionais']) ?></textarea>

                    </div>


                    <!-- BOTÕES -->

                    <div class="mt-4">

                        <button
                            type="submit"
                            class="btn-editar-perfil"
                        >
                            <i class="fa fa-save"></i>
                            Salvar Currículo
                        </button>

                        <a
                            href="perfil_egresso.php"
                            class="btn-editar-perfil"
                        >
                            Cancelar
                        </a>

                    </div>
                </form>
                </div>

            </div>

        </div>

    </div>

</section>


</body>
</html>