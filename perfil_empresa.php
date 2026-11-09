<?php

require_once __DIR__ . "/php/config/config.php";

exigirLogin();
exigirPerfil("empresa");

$cnpj = $_SESSION["cnpj"];



$stmtEmpresa = $conn->prepare("
    SELECT
        cnpj,
        razao_social,
        email,
        telefone,
        estado,
        cidade,
        bairro,
        rua,
        numero,
        complemento,
        cep,
        descricao_empresa,
        logo_empresa
    FROM empresa
    WHERE cnpj = ?
");

$stmtEmpresa->bind_param("s", $cnpj);
$stmtEmpresa->execute();

$resultadoEmpresa = $stmtEmpresa->get_result();

if ($resultadoEmpresa->num_rows !== 1) {
    die("Empresa não encontrada.");
}

$empresa = $resultadoEmpresa->fetch_assoc();



$stmtVagas = $conn->prepare("
    SELECT
        id_vaga,
        titulo_vaga,
        area,
        cidade,
        descricao,
        requisitos,
        beneficios,
        carga_horaria,
        faixa_salarial,
        tipo_contrato,
        img_vaga,
        status,
        data_aprovacao
    FROM vaga
    WHERE cnpj_empresa = ?
    ORDER BY id_vaga DESC
");

$stmtVagas->bind_param("s", $cnpj);
$stmtVagas->execute();

$resultadoVagas = $stmtVagas->get_result();

$vagas = [];

while ($vaga = $resultadoVagas->fetch_assoc()) {
    $vagas[] = $vaga;
}



$totalVagas = 0;
$totalCandidaturas = 0;
$totalEmSelecao = 0;


/* Total de vagas publicadas */

$stmtTotalVagas = $conn->prepare("
    SELECT COUNT(*) AS total
    FROM vaga
    WHERE cnpj_empresa = ?
    AND status = 'Publicada'
");

$stmtTotalVagas->bind_param("s", $cnpj);
$stmtTotalVagas->execute();

$resultadoTotalVagas = $stmtTotalVagas->get_result();
$totalVagas = $resultadoTotalVagas->fetch_assoc()["total"];


/* Total de candidaturas */

$stmtTotalCandidaturas = $conn->prepare("
    SELECT COUNT(*) AS total
    FROM egresso_vaga ev
    INNER JOIN vaga v
        ON ev.id_vaga = v.id_vaga
    WHERE v.cnpj_empresa = ?
");

$stmtTotalCandidaturas->bind_param("s", $cnpj);
$stmtTotalCandidaturas->execute();

$resultadoTotalCandidaturas = $stmtTotalCandidaturas->get_result();
$totalCandidaturas = $resultadoTotalCandidaturas->fetch_assoc()["total"];


/* Candidaturas em análise */

$stmtEmSelecao = $conn->prepare("
    SELECT COUNT(*) AS total
    FROM egresso_vaga ev
    INNER JOIN vaga v
        ON ev.id_vaga = v.id_vaga
    WHERE v.cnpj_empresa = ?
    AND ev.status_candidatura = 'Em Análise'
");

$stmtEmSelecao->bind_param("s", $cnpj);
$stmtEmSelecao->execute();

$resultadoEmSelecao = $stmtEmSelecao->get_result();
$totalEmSelecao = $resultadoEmSelecao->fetch_assoc()["total"];
 


$stmtCandidaturasRecentes = $conn->prepare("
    SELECT
        ev.cpf_egresso,
        ev.id_vaga,
        ev.status_candidatura,
        e.nome,
        e.foto_perfil,
        v.titulo_vaga
    FROM egresso_vaga ev
    INNER JOIN vaga v
        ON ev.id_vaga = v.id_vaga
    INNER JOIN egresso e
        ON ev.cpf_egresso = e.cpf
    WHERE v.cnpj_empresa = ?
    ORDER BY ev.id_vaga DESC
    LIMIT 5
");

$stmtCandidaturasRecentes->bind_param("s", $cnpj);
$stmtCandidaturasRecentes->execute();

$resultadoCandidaturasRecentes = $stmtCandidaturasRecentes->get_result();

$candidaturasRecentes = [];

while ($candidatura = $resultadoCandidaturasRecentes->fetch_assoc()) {
    $candidaturasRecentes[] = $candidatura;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>


    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no"
    >

    <meta
        name="description"
        content="Plataforma 3R - Perfil da Empresa"
    >

    <meta
        name="keywords"
        content="Plataforma 3R, empresa, vagas, candidaturas, emprego"
    >



    <title>Plataforma 3R - Perfil da Empresa</title>




    <link
        rel="stylesheet"
        href="assets/bootstrap/css/bootstrap.min.css"
    >




    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800"
    >

    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600"
    >

    <link
        rel="stylesheet"
        href="assets/fonts/font-awesome.min.css"
    >

    <link
        rel="stylesheet"
        href="assets/fonts/themify-icons.css"
    >


    <

    <link
        rel="stylesheet"
        href="assets/owlcarousel/css/owl.carousel.css"
    >

    <link
        rel="stylesheet"
        href="assets/owlcarousel/css/owl.theme.css"
    >

    <link
        rel="stylesheet"
        href="assets/css/fonts.css"
    >

    <link
        rel="stylesheet"
        href="assets/css/animate.css"
    >

    <link
        rel="stylesheet"
        href="assets/css/venobox.css"
    >

    <link
        rel="stylesheet"
        href="assets/css/magnific-popup.css"
    >

    <link
        rel="stylesheet"
        href="assets/css/menu.css"
    >

    <link
        rel="stylesheet"
        href="assets/css/slider.css"
    >

    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

    <link
        rel="stylesheet"
        href="assets/css/responsive.css"
    >

    <link
        rel="stylesheet"
        href="assets/css/perfil_empresa.css"
    >

</head>


<body data-spy="scroll" data-offset="80">

    <div class="preloader">

        <div class="spinner">

            <div class="double-bounce1"></div>

            <div class="double-bounce2"></div>

        </div>

    </div>

    <div class="site-mobile-menu site-navbar-target">

        <div class="site-mobile-menu-header">

            <div class="site-mobile-menu-close mt-3">

                <span class="icon-close2 js-menu-toggle"></span>

            </div>

        </div>

        <div class="site-mobile-menu-body"></div>

    </div>


    
        <?php include 'nav-bar.php'; ?>



    <main class="perfil-empresa-wrapper">

        <div class="container">

            <section class="empresa-hero-card">


                <div class="empresa-logo-wrapper">
                <?php if (!empty($empresa['logo_empresa'])): ?>
                    <img
                        id="empresa-logo-preview"
                        src="<?= htmlspecialchars($empresa['logo_empresa']) ?>"
                        alt="Logo da empresa"
                        class="empresa-logo-img">
                <?php else: ?>
                    <img
                        id="empresa-logo-preview"
                        src="assets/img/team/team-one.jpg"
                        alt="Logo da empresa"
                        class="empresa-logo-img">
                <?php endif; ?>

                </div>


                <div class="empresa-hero-info">

                    <span class="badge-empresa">
                        Perfil da Empresa
                    </span>


                    <h1 class="empresa-nome" id="display-razao-social"><?= htmlspecialchars($empresa["razao_social"]) ?></h1>


                    <p class="empresa-localizacao">
                        <i class="fa fa-map-marker"></i>
                        <span id="display-cidade"><?= htmlspecialchars($empresa["cidade"]) ?></span>-<span id="display-estado"><?= htmlspecialchars($empresa["estado"]) ?></span></p>
                     
                     
                    <p class="empresa-descricao" id="display-descricao"><?= htmlspecialchars($empresa["descricao_empresa"]?? '') ?></p>


                    <div class="empresa-hero-actions">

                        <button
                            type="button"
                            class="btn-3r-primary"
                            data-toggle="modal"
                            data-target="#modalEditarEmpresa"
                        >

                            <i class="fa fa-pencil"></i>

                            Editar Perfil

                        </button>

                    </div>

                </div>

            </section>

            <section class="empresa-resumo-grid">


                <div class="empresa-mini-card">

                    <div class="mini-icon">

                        <i class="fa fa-briefcase"></i>

                    </div>


                    <div>
                        <span class="mini-label">Vagas Publicadas</span>
                        <strong class="mini-value" id="stat-vagas"><?= $totalVagas ?></strong>
                    </div>

                </div>


                <div class="empresa-mini-card">

                    <div class="mini-icon">

                        <i class="fa fa-users"></i>

                    </div>


                    <div>
                        <span class="mini-label">Candidaturas</span>
                        <strong class="mini-value" id="stat-candidaturas"><?= $totalCandidaturas ?></strong>
                    </div>

                </div>


                <div class="empresa-mini-card">

                    <div class="mini-icon">

                        <i class="fa fa-clock-o"></i>

                    </div>


                    <div>
                        <span class="mini-label">Em Seleção</span>
                        <strong class="mini-value" id="stat-selecao"><?= $totalEmSelecao ?></strong>
                    </div>

                </div>


            </section>



            <section class="empresa-impacto-card">


                <div class="impacto-icon">

                    <i class="fa fa-star"></i>

                </div>


                <div class="impacto-content">

                    <span class="impacto-kicker">
                        Impacto da sua empresa
                    </span>


                    <h2>
                        Continue abrindo novas oportunidades
                    </h2>


                    <p>
                        Sua empresa já abriu oportunidades e recebeu
                        candidatos interessados. Cada nova vaga pode
                        representar um novo começo para alguém.
                    </p>


                    <button
                        type="button"
                        class="btn-impacto"
                        data-toggle="modal"
                        data-target="#modalNovaVaga"
                    >

                        <i class="fa fa-plus"></i>

                        Publicar nova vaga

                    </button>

                </div>


            </section>

            <section class="card-empresa vagas-section">


                <div class="section-header section-header-vagas">


                    <div>

                        <span class="section-kicker">
                            Oportunidades
                        </span>


                        <h2>
                            Suas Vagas
                        </h2>


                        <p>
                            Acompanhe e gerencie as oportunidades
                            publicadas pela sua empresa.
                        </p>

                    </div>


                    <button
                        type="button"
                        class="btn-3r-primary"
                        data-toggle="modal"
                        data-target="#modalNovaVaga"
                        id="btn-nova-vaga"
                    >

                        <i class="fa fa-plus"></i>

                        Nova Vaga

                    </button>

                </div>


                <!-- FILTROS -->

                <div class="vagas-filtros">


                    <button
                        type="button"
                        class="filtro-vaga active"
                        data-filtro="todas"
                    >
                        Todas
                    </button>


                    <button
                        type="button"
                        class="filtro-vaga"
                        data-filtro="ativa"
                    >
                        Ativas
                    </button>


                    <button
                        type="button"
                        class="filtro-vaga"
                        data-filtro="selecao"
                    >
                        Em seleção
                    </button>


                    <button
                        type="button"
                        class="filtro-vaga"
                        data-filtro="encerrada"
                    >
                        Encerradas
                    </button>


                </div>


                <!-- LISTA DE VAGAS -->

                <div
                    class="lista-vagas"
                    id="lista-vagas"
                >


                    <?php foreach ($vagas as $vaga): ?>

    <?php
        /*
         * Define o status visual da vaga
         * sem alterar o valor original do banco.
         */

        if ($vaga["status"] === "Publicada") {
            $statusClasse = "ativa";
            $statusTexto = "Ativa";
        } elseif ($vaga["status"] === "Arquivada") {
            $statusClasse = "encerrada";
            $statusTexto = "Encerrada";
        } elseif ($vaga["status"] === "Aguardando Aprovação") {
            $statusClasse = "selecao";
            $statusTexto = "Aguardando aprovação";
        } else {
            $statusClasse = "encerrada";
            $statusTexto = $vaga["status"];
        }


        /*
         * Conta quantas pessoas se candidataram
         * para esta vaga.
         */

        $stmtCandidatos = $conn->prepare("
            SELECT COUNT(*) AS total
            FROM egresso_vaga
            WHERE id_vaga = ?
        ");

        $stmtCandidatos->bind_param("i", $vaga["id_vaga"]);
        $stmtCandidatos->execute();

        $resultadoCandidatos = $stmtCandidatos->get_result();

        $totalCandidatos = $resultadoCandidatos->fetch_assoc()["total"];
    ?>


    <article
        class="vaga-empresa-card"
        data-status="<?= $statusClasse ?>"
    >
        

        <div class="vaga-card-top">


            <div>

                <span class="vaga-status <?= $statusClasse ?>">

                    <i class="fa fa-circle"></i>

                    <?= htmlspecialchars($statusTexto) ?>

                </span>


                <h3>
                    <?= htmlspecialchars($vaga["titulo_vaga"] ?? "") ?>
                </h3>


                <p class="vaga-meta">

                    <i class="fa fa-map-marker"></i>

                    <?= htmlspecialchars($vaga["cidade"] ?? "") ?>

                    <span class="separador">
                        •
                    </span>

                    <i class="fa fa-clock-o"></i>

                    <?= htmlspecialchars($vaga["tipo_contrato"] ?? "") ?>

                </p>

            </div>


        </div>


        <p class="vaga-descricao">

            <?= htmlspecialchars($vaga["descricao"] ?? "") ?>

        </p>


        <div class="vaga-info-grid">


            <div>

                <span>
                    Área
                </span>

                <strong>
                    <?= htmlspecialchars($vaga["area"] ?? "") ?>
                </strong>

            </div>


            <div>

                <span>
                    Carga horária
                </span>

                <strong>
                    <?= htmlspecialchars($vaga["carga_horaria"] ?? "") ?>h semanais
                </strong>

            </div>


            <div>

                <span>
                    Faixa salarial
                </span>

                <strong>
                    <?= htmlspecialchars($vaga["faixa_salarial"] ?? "") ?>
                </strong>

            </div>


            <div>

                <span>
                    Candidatos
                </span>

                <strong>
                    <?= $totalCandidatos ?>
                </strong>

            </div>


        </div>


        <div class="vaga-card-footer">


            <button
                type="button"
                class="btn-3r-outline btn-editar-vaga"
                data-toggle="modal"
                data-target="#modalNovaVaga"
                data-id="<?= $vaga["id_vaga"] ?>"
                data-img="<?= htmlspecialchars($vaga["img_vaga"] ?? "") ?>"
                data-vaga="<?= htmlspecialchars($vaga["titulo_vaga"] ?? "") ?>"
                data-area="<?= htmlspecialchars($vaga["area"] ?? "") ?>"
                data-cidade="<?= htmlspecialchars($vaga["cidade"] ?? "") ?>"
                data-tipo-contrato="<?= htmlspecialchars($vaga["tipo_contrato"] ?? "") ?>"
                data-carga-horaria="<?= htmlspecialchars($vaga["carga_horaria"] ?? "") ?>"
                data-faixa-salarial="<?= htmlspecialchars($vaga["faixa_salarial"] ?? "") ?>"
                data-status="<?= htmlspecialchars($vaga["status"] ?? "") ?>"
                data-descricao="<?= htmlspecialchars($vaga["descricao"] ?? "") ?>"
                data-requisitos="<?= htmlspecialchars($vaga["requisitos"] ?? "") ?>"
                data-beneficios="<?= htmlspecialchars($vaga["beneficios"] ?? "") ?>">

                <i class="fa fa-pencil"></i>

                Editar

            </button>


            <button
                type="button"
                class="btn-candidatos"
                data-id="<?= $vaga["id_vaga"] ?>"
                data-vaga="<?= htmlspecialchars($vaga["titulo_vaga"] ?? "") ?>"
            >

                <i class="fa fa-users"></i>

                Ver candidaturas

            </button>


        </div>


    </article>


<?php endforeach; ?>
                </div>

            </section>

            <section class="card-empresa candidaturas-section">


                <div class="section-header">


                    <div>

                        <span class="section-kicker">
                            Interessados
                        </span>


                        <h2>
                            Candidaturas Recentes
                        </h2>


                        <p>
                            Acompanhe os candidatos que demonstraram
                            interesse nas oportunidades da empresa.
                        </p>

                    </div>


                </div>


                <div
                    class="lista-candidaturas"
                    id="lista-candidaturas"
                >
                     <?php if (empty($candidaturasRecentes)): ?>

        <div class="candidatura-card">

            <div class="candidato-avatar">

                <i class="fa fa-user"></i>

            </div>

            <div class="candidato-info">

                <h3>
                    Nenhuma candidatura ainda
                </h3>

                <p>
                    As candidaturas recebidas pela sua empresa aparecerão aqui.
                </p>

            </div>

        </div>

    <?php else: ?>

        <?php foreach ($candidaturasRecentes as $candidatura): ?>

            <article class="candidatura-card">

                <div class="candidato-avatar">

                    <?php if (!empty($candidatura["foto_perfil"])): ?>

                        <img
                            src="<?= htmlspecialchars($candidatura["foto_perfil"]) ?>"
                            alt="Foto de <?= htmlspecialchars($candidatura["nome"]) ?>"
                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;"
                        >

                    <?php else: ?>

                        <i class="fa fa-user"></i>

                    <?php endif; ?>

                </div>


                <div class="candidato-info">

                    <h3>
                        <?= htmlspecialchars($candidatura["nome"]) ?>
                    </h3>


                    <p>
                        <?= htmlspecialchars($candidatura["titulo_vaga"]) ?>
                    </p>


                    <span class="candidatura-data">

                        Status:
                        <?= htmlspecialchars($candidatura["status_candidatura"]) ?>

                    </span>

                </div>


                <button
                    type="button"
                    class="btn-ver-candidato"
                    title="Ver candidatura"
                    data-id-vaga="<?= htmlspecialchars($candidatura["id_vaga"]) ?>"
                    data-cpf="<?= htmlspecialchars($candidatura["cpf_egresso"]) ?>"
                >

                    <i class="fa fa-chevron-right"></i>

                </button>

            </article>

        <?php endforeach; ?>

    <?php endif; ?>

                    


                </div>


            </section>


        </div>

    </main>


    <div
        class="modal fade modal-custom-empresa"
        id="modalEditarEmpresa"
        tabindex="-1"
        role="dialog"
        aria-hidden="true"
    >

        <div
            class="modal-dialog modal-lg modal-dialog-centered"
            role="document"
        >

            <div class="modal-content">


                <div class="modal-header">


                    <h5 class="modal-title">

                        <i class="fa fa-building"></i>

                        Editar Perfil da Empresa

                    </h5>


                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Fechar"
                    >

                        <span aria-hidden="true">
                            &times;
                        </span>

                    </button>

                </div>


                <form id="formEditarEmpresa" action="/tcc-1/php/empresa/atualizar_perfil_empresa.php" method="POST" enctype="multipart/form-data">


                    <div class="modal-body">


                        <div class="foto-empresa-editor">

                        <?php if (!empty($empresa['logo_empresa'])): ?>
                            <img
                                id="modal-logo-preview"
                                src="<?= htmlspecialchars($empresa['logo_empresa']) ?>"
                                alt="Preview da logo"
                                class="modal-logo-img">
                        <?php else: ?>
                            <img
                                id="modal-logo-preview"
                                src="assets/img/team/team-one.jpg"
                                alt="Preview da logo"
                                class="modal-logo-img">
                        <?php endif; ?>
                        <div>

                                <label>
                                    Logo da Empresa
                                </label>


                                <input
                                    type="file"
                                    id="input-logo-arquivo"
                                    name='logo_empresa'
                                    accept="image/png, image/jpeg, image/webp"
                                    class="d-none"
                                >


                                <button
                                    type="button"
                                    class="btn-3r-outline"
                                    id="btn-escolher-logo"
                                >
                                    <i class="fa fa-upload"></i>
                                    Escolher logo
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Razão Social</label>
                                <input type="text" class="custom-input" name="razao_social" id="input-razao-social" value="<?= htmlspecialchars($empresa["razao_social"] ?? "") ?>" required>
                            </div>


                            <div class="col-md-6 form-group">
                                <label>CNPJ</label>
                                <input type="text" class="custom-input disabled" value="<?= htmlspecialchars($empresa["cnpj"] ?? "") ?>" readonly disabled>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input type="email" class="custom-input" name="email" value="<?= htmlspecialchars($empresa["email"] ?? "") ?>" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Telefone</label>
                                <input type="tel" class="custom-input" name="telefone" value="<?= htmlspecialchars($empresa["telefone"] ?? "") ?>">
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Estado</label>
                                <input type="text" class="custom-input" name="estado" value="<?= htmlspecialchars($empresa["estado"] ?? "") ?>">
                            </div>
                            <div class="col-md-8 form-group">
                                <label>Cidade</label>
                                <input type="text" class="custom-input" name="cidade" value="<?= htmlspecialchars($empresa["cidade"] ?? "") ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Bairro</label>
                                <input type="text" class="custom-input" name="bairro" value="<?= htmlspecialchars($empresa["bairro"] ?? "") ?>" placeholder="Bairro">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Rua</label>
                                <input type="text" class="custom-input" name="rua" value='<?= htmlspecialchars($empresa["rua"] ?? "") ?>' placeholder="Rua">
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Número</label>
                                <input type="text" class="custom-input" name="numero" value='<?= htmlspecialchars($empresa["numero"] ?? "") ?>'placeholder="Número">
                            </div>
                            <div class="col-md-8 form-group">
                                <label>Complemento</label>
                                <input type="text" class="custom-input" name="complemento" value='<?= htmlspecialchars($empresa["complemento"] ?? "") ?>' placeholder="Complemento">
                            </div>
                            <div class="col-md-4 form-group">
                                <label>CEP</label>
                                <input type="text" class="custom-input" name="cep" value='<?= htmlspecialchars($empresa["cep"] ?? "") ?>' placeholder="00000-000">
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Descrição da Empresa</label>
                                <textarea class="custom-input" name="descricao_empresa" rows="4" placeholder="Conte um pouco sobre sua empresa..."><?= htmlspecialchars($empresa["descricao_empresa"] ?? "") ?></textarea>
                            </div>


                        </div>

                    </div>


                    <div class="modal-footer">


                        <button
                            type="button"
                            class="btn-3r-ghost"
                            data-dismiss="modal"
                        >
                            Cancelar
                        </button>


                        <button
                            type="submit"
                            class="btn-3r-primary" 
                        >

                            <i class="fa fa-save"></i>

                            Salvar Alterações

                        </button>


                    </div>


                </form>

            </div>

        </div>

    </div>


    <div
        class="modal fade modal-custom-empresa"
        id="modalNovaVaga"
        tabindex="-1"
        role="dialog"
        aria-hidden="true"
    >

        <div
            class="modal-dialog modal-lg modal-dialog-centered"
            role="document"
        >

            <div class="modal-content">


                <div class="modal-header">


                    <h5
                        class="modal-title"
                        id="titulo-modal-vaga"
                    >

                        <i class="fa fa-briefcase"></i>

                        Nova Vaga

                    </h5>


                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Fechar"
                    >

                        <span aria-hidden="true">
                            &times;
                        </span>

                    </button>

                </div>


                <form id="formNovaVaga"  action="php/empresa/create_vaga.php" method="POST" enctype="multipart/form-data">
                    
                    <input type="hidden" name="id_vaga" id="input-id-vaga">
                    <div class="modal-body">


                        <p class="modal-intro">
                            Preencha ou altere as informações da oportunidade.
                        </p>


                        <div class="row">


                            <div class="col-md-8 form-group">

                                <label>
                                    Título da Vaga
                                </label>


                                <input
                                    type="text"
                                    class="custom-input"
                                    name="titulo_vaga"
                                    id="input-titulo-vaga"
                                    placeholder="Ex.: Auxiliar Administrativo"
                                    required
                                >

                            </div>


                            <div class="col-md-4 form-group">

                                <label>
                                    Área
                                </label>


                                <input
                                    type="text"
                                    class="custom-input"
                                    name="area"
                                    placeholder="Ex.: Administração"
                                    required
                                >

                            </div>


                            <div class="col-md-6 form-group">

                                <label>
                                    Cidade
                                </label>


                                <input
                                    type="text"
                                    class="custom-input"
                                    name="cidade"
                                    placeholder="Cidade da vaga"
                                    required
                                >

                            </div>
                            <div class="col-md-6 form-group">

                                <label>
                                    Tipo de Contrato
                                </label>
                                <input
                                    type="text"
                                    class="custom-input"
                                    name="tipo_contrato"
                                    placeholder="Ex.: CLT, Estágio..."
                                >

                            </div>
                            <div class="col-md-6 form-group">

                                <label>
                                    Carga Horária
                                </label>


                                <input
                                    type="number"
                                    class="custom-input"
                                    name="carga_horaria"
                                    placeholder="Ex.: 40"
                                    min='1' required
                                >

                            </div>


                            <div class="col-md-6 form-group">

                                <label>
                                    Faixa Salarial
                                </label>


                                <input
                                    type="text"
                                    class="custom-input"
                                    name="faixa_salarial"
                                    placeholder="Ex.: R$ 1.800 - R$ 2.200"
                                >

                            </div>


                            <div class="col-md-12 form-group">

                                <label>
                                    Status da Vaga
                                </label>


                                <select
                                    class="custom-input"
                                    name="status"
                                    id="select-status-vaga"
                                >

                                    <option value="ativa">
                                        Ativa
                                    </option>

                                    <option value="selecao">
                                        Em seleção
                                    </option>

                                    <option value="encerrada">
                                        Encerrada
                                    </option>

                                </select>

                                <small class="campo-ajuda">
                                    Atualize o andamento do processo seletivo
                                    conforme a situação da vaga.
                                </small>

                            </div>


                            <div class="col-md-12 form-group">

                                <label>
                                    Descrição
                                </label>


                                <textarea
                                    class="custom-input"
                                    name="descricao"
                                    rows="4"
                                    placeholder="Descreva a oportunidade..."
                                ></textarea>

                            </div>


                            <div class="col-md-12 form-group">

                                <label>
                                    Requisitos
                                </label>


                                <textarea
                                    class="custom-input"
                                    name="requisitos"
                                    rows="4"
                                    placeholder="Informe os requisitos para a vaga..."
                                ></textarea>

                            </div>


                            <div class="col-md-12 form-group">

                                <label>
                                    Benefícios
                                </label>


                                <textarea
                                    class="custom-input"
                                    name="beneficios"
                                    rows="4"
                                    placeholder="Informe os benefícios oferecidos..."
                                ></textarea>

                            </div>


                            <div class="col-md-12 form-group">

                                <label>Imagem da Vaga</label>
                            <div id="imagem-atual-vaga" style="margin-bottom: 10px; display: none;">
                            <small>Imagem atual:</small><br>
                            <img id="preview-imagem-vaga" src="" alt="Imagem atual da vaga" style="max-width: 250px; max-height: 150px; object-fit: cover; margin-top: 8px; border-radius: 8px;">
                            </div>
                            <input type="file" class="custom-input-file" name="img_vaga" accept="image/png, image/jpeg, image/webp">
                            </div>


                        </div>

                    </div>


                    <div class="modal-footer">


                        <button
                            type="button"
                            class="btn-3r-ghost"
                            data-dismiss="modal"
                        >
                            Cancelar
                        </button>


                        <button
                            type="submit"
                            class="btn-3r-primary"
                            id="btn-salvar-vaga"
                        >

                            <i class="fa fa-save"></i>

                            Publicar Vaga

                        </button>


                    </div>


                </form>

            </div>

        </div>

    </div>

    <div
        class="modal fade modal-custom-empresa"
        id="modalCandidaturas"
        tabindex="-1"
        role="dialog"
        aria-hidden="true"
    >

        <div
            class="modal-dialog modal-lg modal-dialog-centered"
            role="document"
        >

            <div class="modal-content">


                <div class="modal-header">


                    <h5 class="modal-title">

                        <i class="fa fa-users"></i>

                        Candidaturas da Vaga

                    </h5>


                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Fechar"
                    >

                        <span aria-hidden="true">
                            &times;
                        </span>

                    </button>

                </div>


                <div class="modal-body">


                    <div class="modal-vaga-resumo">


                        <span>
                            Vaga selecionada
                        </span>


                        <strong id="modal-vaga-nome">
                            Auxiliar Administrativo
                        </strong>


                    </div>


                    <div
                        class="modal-lista-candidatos"
                        id="modal-lista-candidatos"
                    >


                        <!-- CANDIDATO 1 -->

                        <article class="candidato-modal-card">


                            <div class="candidato-avatar candidato-avatar-large">

                                <i class="fa fa-user"></i>

                            </div>


                            <div class="candidato-modal-info">

                                <h3>
                                    Candidato de Exemplo
                                </h3>


                                <p>
                                    Candidatura recebida recentemente
                                </p>


                                <span class="status-candidatura recebido">
                                    Em análise
                                </span>

                            </div>


                            <button
                                type="button"
                                class="btn-curriculo"
                            >

                                Ver currículo

                                <i class="fa fa-arrow-right"></i>

                            </button>


                        </article>


                        <!-- CANDIDATO 2 -->

                        <article class="candidato-modal-card">


                            <div class="candidato-avatar candidato-avatar-large">

                                <i class="fa fa-user"></i>

                            </div>


                            <div class="candidato-modal-info">

                                <h3>
                                    Candidato de Exemplo
                                </h3>


                                <p>
                                    Candidatura recebida recentemente
                                </p>


                                <span class="status-candidatura entrevista">
                                    Em seleção
                                </span>

                            </div>


                            <button
                                type="button"
                                class="btn-curriculo"
                            >

                                Ver currículo

                                <i class="fa fa-arrow-right"></i>

                            </button>


                        </article>


                    </div>

                </div>


                <div class="modal-footer">


                    <button
                        type="button"
                        class="btn-3r-ghost"
                        data-dismiss="modal"
                    >

                        Fechar

                    </button>


                </div>


            </div>

        </div>

    </div>
    

<div
    class="modal fade modal-custom-3r"
    id="modalVisualizarCurriculo"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
>

    <div
        class="modal-dialog modal-lg modal-dialog-centered"
        role="document"
    >

        <div class="modal-content">


            <!-- CABEÇALHO -->

            <div class="modal-header">

                <h5 class="modal-title">

                    <i class="fa fa-file-text"></i>

                    Currículo do Candidato

                </h5>


                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Fechar"
                >

                    <span aria-hidden="true">
                        &times;
                    </span>

                </button>

            </div>


            <!-- CONTEÚDO -->

            <div class="modal-body">


                <!-- DADOS DO CANDIDATO -->

                <div class="mb-4">

                    <h4 id="curriculo-nome">
                        Carregando...
                    </h4>

                    <p id="curriculo-area">
                        Área de interesse
                    </p>

                    <p id="curriculo-contato">
                        Contato
                    </p>

                </div>


                <!-- ESCOLARIDADE -->

                <div class="form-group mb-4">

                    <label class="font-weight-bold">
                        <i class="fa fa-graduation-cap"></i>
                        Escolaridade
                    </label>

                    <p id="curriculo-formacao">
                        Não informado
                    </p>

                </div>


                <!-- EXPERIÊNCIAS -->

                <div class="form-group mb-4">

                    <label class="font-weight-bold">
                        <i class="fa fa-briefcase"></i>
                        Experiências
                    </label>

                    <div id="curriculo-experiencias">
                        Não informado
                    </div>

                </div>


                <!-- HABILIDADES -->

                <div class="form-group mb-4">

                    <label class="font-weight-bold">
                        <i class="fa fa-star"></i>
                        Habilidades
                    </label>

                    <div id="curriculo-habilidades">
                        Não informado
                    </div>

                </div>


                <!-- DISPONIBILIDADE -->

                <div class="form-group mb-2">

                    <label class="font-weight-bold">
                        <i class="fa fa-clock-o"></i>
                        Disponibilidade
                    </label>

                    <div id="curriculo-disponibilidade">
                        Não informado
                    </div>

                </div>


            </div>


            <!-- RODAPÉ -->

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn-3r-ghost"
                    data-dismiss="modal"
                >

                    Fechar

                </button>

            </div>


        </div>

    </div>

</div> 






    <?php include 'footer.php';?>


    <script src="assets/js/jquery-1.12.4.min.js"></script>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <script src="assets/js/modernizr-2.8.3.min.js"></script>

    <script src="assets/owlcarousel/js/owl.carousel.min.js"></script>

    <script src="assets/js/jquery.magnific-popup.min.js"></script>

    <script src="assets/js/jquery.mixitup.js"></script>

    <script src="assets/js/jquery.appear.js"></script>

    <script src="assets/js/jquery.inview.min.js"></script>

    <script src="assets/js/jquery.touchSwipe.min.js"></script>

    <script src="assets/js/jquery.stellar.min.js"></script>

    <script src="assets/js/wow.min.js"></script>

    <script src="assets/js/form-contact.js"></script>

    <script src="assets/js/menu.js"></script>

    <script src="assets/js/jquery.sticky.js"></script>

    <script src="assets/js/scrolltopcontrol.js"></script>

    <script src="assets/js/scripts.js"></script>

    <!-- JS ESPECÍFICO -->

    <script src="assets/js/perfil_empresa.js"></script>

</body>

</html>