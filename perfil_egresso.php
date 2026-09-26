<!DOCTYPE html>
<html lang="pt-br">
<?php
require_once __DIR__ . "/php/config/config.php";
exigirLogin();
exigirPerfil('egresso');
$cpf = $_SESSION["cpf"];
$stmt = $conn->prepare("
    SELECT cpf, nome, data_nascimento, email, telefone, cidade, area_interesse, foto_perfil
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
$stmtCursos = $conn->prepare("
    SELECT
        c.id_curso,
        c.nome_curso,
        c.area,
        c.descricao,
        c.url_curso,
        ec.status_curso
    FROM egresso_curso ec
    INNER JOIN curso c
        ON ec.id_curso = c.id_curso
    WHERE ec.cpf_egresso = ?
    ORDER BY c.id_curso
");

$stmtCursos->bind_param("s", $cpf);
$stmtCursos->execute();

$resultadoCursos = $stmtCursos->get_result();
$cursosEgresso = $resultadoCursos->fetch_all(MYSQLI_ASSOC);

$stmtModalCurriculo = $conn->prepare("
    SELECT
        formacao,
        experiencia_profissional,
        informacoes_adicionais
    FROM curriculo
    WHERE cpf_egresso = ?
");

$stmtModalCurriculo->bind_param("s", $cpf);
$stmtModalCurriculo->execute();

$resultadoModalCurriculo = $stmtModalCurriculo->get_result();

if ($resultadoModalCurriculo->num_rows === 1) {

    $curriculoModal = $resultadoModalCurriculo->fetch_assoc();

} else {

    $curriculoModal = [
        "formacao" => "",
        "experiencia_profissional" => "",
        "informacoes_adicionais" => ""
    ];
}
// Busca as candidaturas do egresso
$stmtCandidaturas = $conn->prepare("
    SELECT
        ev.id_candidatura,
        ev.data_candidatura,
        ev.status_candidatura,
        v.titulo_vaga,
        v.cidade,
        e.razao_social
    FROM egresso_vaga ev
    INNER JOIN vaga v ON ev.id_vaga = v.id_vaga
    INNER JOIN empresa e ON v.cnpj_empresa = e.cnpj
    WHERE ev.cpf_egresso = ?
    ORDER BY ev.data_candidatura DESC
");


$stmtCandidaturas->bind_param("s", $cpf);
$stmtCandidaturas->execute();


$resultadoCandidaturas = $stmtCandidaturas->get_result();


$candidaturas = [];


while ($candidatura = $resultadoCandidaturas->fetch_assoc()) {
    $candidaturas[] = $candidatura;
}


$totalCandidaturas = count($candidaturas);

// Busca a quantidade de cursos concluídos e em andamento

$stmtCursos = $conn->prepare("
    SELECT
        SUM(status_curso = 'Concluído') AS total_cursos_concluidos,
        SUM(status_curso = 'Em Andamento') AS total_cursos_andamento
    FROM egresso_curso
    WHERE cpf_egresso = ?
");

$stmtCursos->bind_param("s", $cpf);

$stmtCursos->execute();

$resultadoCursos = $stmtCursos->get_result();

$cursos = $resultadoCursos->fetch_assoc();

$totalCursosConcluidos = $cursos['total_cursos_concluidos'] ?? 0;
$totalCursosAndamento = $cursos['total_cursos_andamento'] ?? 0;
?>
    <head>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Plataforma 3R - Perfil do Egresso">
        <meta name="keywords" content="agencia, business, corporate, creative, html5, modern, multipurpose">    
       
        <!-- SITE TITLE -->
        <title>Plataforma 3R - Perfil do Egresso</title>          
       
        <!-- Latest Bootstrap min CSS -->
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">      
       
        <!-- Google Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600">          
       
        <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
        <link rel="stylesheet" href="assets/fonts/themify-icons.css">
        <link rel="stylesheet" href="assets/owlcarousel/css/owl.carousel.css">
        <link rel="stylesheet" href="assets/owlcarousel/css/owl.theme.css">
        <link rel="stylesheet" href="assets/css/fonts.css">    
        <link rel="stylesheet" href="assets/css/animate.css">      
        <link rel="stylesheet" href="assets/css/venobox.css">          
        <link rel="stylesheet" href="assets/css/magnific-popup.css">                    
       
        <!-- Style CSS -->                      
        <link rel="stylesheet" href="assets/css/menu.css">  
        <link rel="stylesheet" href="assets/css/slider.css">            
        <link rel="stylesheet" href="assets/css/style.css">                
        <link rel="stylesheet" href="assets/css/responsive.css">
        <link rel="stylesheet" href="assets/css/perfil_egresso.css">        
    </head>
   
    <body data-spy="scroll" data-offset="80">

        <!-- PRELOADER -->
        <div class="preloader">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
        <?php include 'nav-bar.php'; ?>
        
 
        <!-- SEÇÃO PRINCIPAL DO PERFIL -->
        <main class="perfil-main-wrapper">
          <div class="container">
           
            <!-- CABEÇALHO DO USUÁRIO -->
            <section class="perfil-hero-card">
              <div class="hero-avatar-wrapper">
                <?php if (!empty($egresso['foto_perfil'])): ?>
                  <img class='hero-avatar-img' src="<?= htmlspecialchars($egresso['foto_perfil']) ?>" alt="Foto de <?= htmlspecialchars($egresso['nome']) ?>">
                <?php else: ?>
                  <img class='hero-avatar-img' src="assets/img/team/team-one.jpg" alt="Foto do Usuário"><?php endif; ?>
              </div>
              <div class="hero-info">
                <span class="badge-boas-vindas">Bem-vindo!</span>
                <h1 class="hero-nome" id="display-nome"><?= htmlspecialchars($egresso['nome']) ?></h1>
                <p class="hero-bio">
                  Este é o seu espaço seguro para organizar suas ideias, aprender coisas novas e dar o próximo passo rumo ao seu futuro profissional.
                </p>
                <div class="hero-actions">
                  <button class="btn-3r-primary" data-toggle="modal" data-target="#modalEditarPerfil">
                    <i class="fa fa-pencil"></i> Editar Meus Dados
                  </button>
                </div>
              </div>
            </section>

            <!-- GRID CONTEÚDO PRINCIPAL -->
            <div class="row layout-grid">
             
              <!-- COLUNA DA ESQUERDA -->
              <div class="col-lg-8">
               
                <!-- CARD: TRILHA DE APRENDIZAGEM -->
                <article class="card-3r card-trilha">
                  <div class="card-trilha-content">
                    <div class="card-icon-header">
                      <i class="fa fa-map-signs"></i>
                    </div>
                    <div>
                      <h3>Sua Trilha de Aprendizagem</h3>
                      <p>Você tem novos cursos liberados! Acompanhe seu progresso, escolha seu avatar e navegue pelo seu tabuleiro interativo.</p>
                    </div>
                  </div>
                  <div class="card-trilha-footer">
                    <button class="btn-3r-secondary" data-toggle="modal" data-target="#modalTrilhaGigante">
                      <i class="fa fa-gamepad"></i> Abrir Meu Tabuleiro
                    </button>
                  </div>
                </article>

                <!-- CARD: CONSTRUIR CURRÍCULO -->
                <article class="card-3r card-curriculo">
                  <div class="card-header-clean">
                    <div class="icon-badge"><i class="fa fa-file-text-o"></i></div>
                    <div>
                      <h3>Construa seu Currículo</h3>
                      <p>Monte sua vitrine profissional cadastrando sua formação e experiências.</p>
                    </div>
                  </div>
                  <div class="curriculo-options">
                    <div class="option-box">
                      <h4>Preencher na Plataforma</h4>
                      <p>Mantenha seus dados atualizados diretamente no nosso sistema de forma simples.</p>
                      <button class="btn-3r-outline" data-toggle="modal" data-target="#modalCurriculo">
                        <i class="fa fa-edit"></i> Preencher no Site
                      </button>
                    </div>
                    <div class="option-box">
                      <h4>Fazer via Google Docs</h4>
                      <p>Prefere modelo externo? Crie e edite diretamente na nuvem.</p>
                      <a href="https://docs.google.com/document/d/1fO5ckkvMBWfYtZ2Cqoq9Ms6PF7b12Dxsjv5S6oA7wJI/edit?usp=sharing" target="_blank" rel="noopener" class="btn-3r-dark">
                        <i class="fa fa-external-link"></i> Abrir Google Docs
                      </a>
                    </div>
                  </div>
                </article>

              </div>

              <!-- COLUNA DA DIREITA -->
              <div class="col-lg-4">
               
                <!-- CARD: ESTATÍSTICAS -->
                <aside class="card-3r card-stats">
                  <h3 class="side-title"><i class="fa fa-bar-chart"></i> Seus Números</h3>
                  <ul class="stats-list">
                    <li class="stat-item">
                      <span class="stat-label">Cursos Concluídos</span>
                      <span class="stat-value highlight" id="stat-cursos-concluidos"><?= $totalCursosConcluidos?></span>
                    </li>
                    <li class="stat-item">
                      <span class="stat-label">Em Andamento</span>
                      <span class="stat-value" id="stat-cursos-andamento"><?= $totalCursosAndamento?></span>
                    </li>
                    <li class="stat-item">
                      <span class="stat-label">Vagas Candidatadas</span>
                      <span class="stat-value" id="stat-vagas-candidatadas"><?= $totalCandidaturas ?></span>
                    </li>
                  </ul>
                </aside>

                <!-- CARD: OPORTUNIDADES -->
                <aside class="card-3r card-vagas">
                  <h3 class="side-title"><i class="fa fa-briefcase"></i> Oportunidades</h3>
                  <div class="vagas-wrapper" id="lista-candidaturas">
                    <div class="vagas-wrapper" id="lista-candidaturas">
                      <?php if (count($candidaturas) > 0): ?>
                        <?php foreach ($candidaturas as $candidatura): ?>
                        <div class="vaga-card">
                        <h4 class="vaga-titulo"><?= htmlspecialchars($candidatura['titulo_vaga']) ?></h4>
                        <p class="vaga-empresa"><?= htmlspecialchars($candidatura['razao_social']) ?></p>
                        <span class="status-pill status-espera">
                        <i class="fa fa-clock-o"></i><?= htmlspecialchars($candidatura['status_candidatura']) ?>
                        </span>
                        </div>
                      <?php endforeach; ?>
                      <?php else: ?>
                        <div class="vaga-card">
                        <p class="vaga-empresa">Você ainda não se candidatou a nenhuma oportunidade.</p>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </aside>

              </div>
            </div>

          </div>
        </main>

        <!-- MODAL 1: EDITAR PERFIL -->
        <div class="modal fade modal-custom-3r" id="modalEditarPerfil" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-user-circle"></i> Editar Dados Pessoais</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="formEditarPerfil" action="php/egresso/atualizar_perfil.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                  <div class="foto-seletor-container mb-4">
                    <label class="d-block font-weight-bold mb-2">Foto de Perfil</label>
                    <div class="d-flex align-items-center gap-3">
                      <img id="modal-foto-preview" src="<?= !empty($egresso['foto_perfil']) ? htmlspecialchars($egresso['foto_perfil']) : 'assets/img/team/team-one.jpg' ?>" alt="Foto de Perfil" class="seletor-preview-img">
                      <div class="flex-grow-1 ml-3">
                        <input type="file" id="input-foto-arquivo" name='foto_perfil' accept="image/png, image/jpeg, image/webp" class="d-none">
                        <button type="button" class="btn-3r-outline mb-2" onclick="document.getElementById('input-foto-arquivo').click();">
                          <i class="fa fa-upload"></i> Escolher foto
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="input-nome">Nome Completo</label>
                      <input type="text" class="custom-input" id="input-nome" name="nome" value= '<?= htmlspecialchars($egresso['nome']) ?>' required>
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="input-cpf">CPF (Inalterável)</label>
                      <input type="text" class="custom-input disabled" id="input-cpf" name="cpf" value="<?= htmlspecialchars($egresso['cpf']) ?>" readonly disabled>
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="input-data-nasc">Data de Nascimento</label>
                      <input type="date" class="custom-input" id="input-data-nasc" name="data_nascimento" value="<?= htmlspecialchars($egresso['data_nascimento']) ?>" required>
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="input-email">E-mail</label>
                      <input type="email" class="custom-input" id="input-email" name="email" value="<?= htmlspecialchars($egresso['email']) ?>" required>
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="input-telefone">Telefone</label>
                      <input type="tel" class="custom-input" id="input-telefone" name="telefone" value="<?= htmlspecialchars($egresso['telefone']) ?>" placeholder="(00) 00000-0000">
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="input-cidade">Cidade</label>
                      <input type="text" class="custom-input" id="input-cidade" name="cidade" value="<?= htmlspecialchars($egresso['cidade']) ?>" placeholder="Sua cidade">
                    </div>
                    <div class="col-md-12 form-group">
    <label for="select-area-interesse">Área de Interesse</label>

    <select class="custom-input" id="select-area-interesse" name="area_interesse" required>

        <option value="">Selecione uma área</option>

        <option value="Tecnologia"
            <?= $egresso['area_interesse'] === 'Tecnologia' ? 'selected' : '' ?>>
            Tecnologia
        </option>

        <option value="Idiomas"
            <?= $egresso['area_interesse'] === 'Idiomas' ? 'selected' : '' ?>>
            Idiomas
        </option>

        <option value="Administrativo"
            <?= $egresso['area_interesse'] === 'Administrativo' ? 'selected' : '' ?>>
            Administrativo
        </option>

        <option value="Logística"
            <?= $egresso['area_interesse'] === 'Logística' ? 'selected' : '' ?>>
            Logística
        </option>

        <option value="Comercial"
            <?= $egresso['area_interesse'] === 'Comercial' ? 'selected' : '' ?>>
            Comercial
        </option>

        <option value="Negócios"
            <?= $egresso['area_interesse'] === 'Negócios' ? 'selected' : '' ?>>
            Negócios
        </option>

        <option value="Atendimento"
            <?= $egresso['area_interesse'] === 'Atendimento' ? 'selected' : '' ?>>
            Atendimento
        </option>

        <option value="Desenvolvimento Pessoal"
            <?= $egresso['area_interesse'] === 'Desenvolvimento Pessoal' ? 'selected' : '' ?>>
            Desenvolvimento Pessoal
        </option>

        <option value="Operacional"
            <?= $egresso['area_interesse'] === 'Operacional' ? 'selected' : '' ?>>
            Operacional
        </option>

    </select>
</div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn-3r-ghost" data-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn-3r-primary">Salvar Alterações</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- MODAL 2: PREENCHER CURRÍCULO (POR CLIQUE) -->
        <div class="modal fade modal-custom-3r" id="modalCurriculo" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-file-text"></i> Construir Currículo Rápido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form id="formCurriculo" action="php/egresso/atualizar_curriculo.php" method="POST">
                <div class="modal-body">
                  <p class="small text-muted mb-3">Clique nas opções abaixo para montar seu perfil profissional sem precisar digitar textos longos:</p>
                 
                  <!-- 1. ESCOLARIDADE -->
                  <div class="form-group mb-4">
                    <label class="font-weight-bold d-block mb-1">1. Sua Escolaridade:</label>
                    <div class="tag-selector-grid">
                      <input type="radio" name="escolaridade" id="esc-1" value="Ensino Médio Incompleto" class="tag-checkbox" <?= $curriculoModal["formacao"] === "Ensino Médio Incompleto" ? "checked" : "" ?>>
                      <label for="esc-1" class="tag-label"><i class="fa fa-graduation-cap"></i> Ensino Médio Incompleto</label>

                      <input type="radio" name="escolaridade" id="esc-2" value="Ensino Médio Completo" class="tag-checkbox" <?= $curriculoModal["formacao"] === "Ensino Médio Completo" ? "checked" : "" ?>>
                      <label for="esc-2" class="tag-label"><i class="fa fa-graduation-cap"></i> Ensino Médio Completo</label>

                      <input type="radio" name="escolaridade" id="esc-3" value="Curso Técnico" class="tag-checkbox" <?= $curriculoModal["formacao"] === "Curso Técnico" ? "checked" : "" ?>>
                      <label for="esc-3" class="tag-label"><i class="fa fa-graduation-cap"></i> Curso Técnico</label>

                      <input type="radio" name="escolaridade" id="esc-4" value="Ensino Superior" class="tag-checkbox" <?= $curriculoModal["formacao"] === "Ensino Superior" ? "checked" : "" ?>>
                      <label for="esc-4" class="tag-label"><i class="fa fa-graduation-cap"></i> Ensino Superior</label>
                    </div>
                  </div>

                  <!-- 2. EXPERIÊNCIA PRÉVIA -->
                  <div class="form-group mb-4">
                    <label class="font-weight-bold d-block mb-1">2. Áreas de Experiência (Marque as que já trabalhou):</label>
                    <div class="tag-selector-grid">
                      <input type="checkbox" id="exp-1" name="experiencias[]" value="Em busca do Primeiro Emprego" class="tag-checkbox" <?= strpos($curriculoModal["experiencia_profissional"], "Em busca do Primeiro Emprego") !== false ? "checked" : "" ?>>
                      <label for="exp-1" class="tag-label"><i class="fa fa-star"></i> Primeiro Emprego</label>

                      <input type="checkbox" id="exp-2" name="experiencias[]" value="Atendimento / Recepção" class="tag-checkbox" <?= strpos($curriculoModal["experiencia_profissional"], "Atendimento / Recepção") !== false ? "checked" : "" ?>>
                      <label for="exp-2" class="tag-label"><i class="fa fa-comments"></i> Atendimento / Recepção</label>

                      <input type="checkbox" id="exp-3" name="experiencias[]" value="Vendas / Comércio" class="tag-checkbox" <?= strpos($curriculoModal["experiencia_profissional"], "Vendas / Comércio") !== false ? "checked" : "" ?>>
                      <label for="exp-3" class="tag-label"><i class="fa fa-shopping-cart"></i> Vendas / Comércio</label>

                      <input type="checkbox" id="exp-4" name="experiencias[]" value="Apoio Administrativo" class="tag-checkbox" <?= strpos($curriculoModal["experiencia_profissional"], "Apoio Administrativo") !== false ? "checked" : "" ?>>
                      <label for="exp-4" class="tag-label"><i class="fa fa-folder"></i> Apoio Administrativo</label>

                      <input type="checkbox" id="exp-5" name="experiencias[]" value="Serviços Gerais / Limpeza" class="tag-checkbox" <?= strpos($curriculoModal["experiencia_profissional"], "Serviços Gerais") !== false ? "checked" : "" ?>>
                      <label for="exp-5" class="tag-label"><i class="fa fa-wrench"></i> Serviços Gerais</label>

                      <input type="checkbox" id="exp-6" name="experiencias[]" value="Estoque / Logística" class="tag-checkbox" <?= strpos($curriculoModal["experiencia_profissional"], " Estoque / Logística") !== false ? "checked" : "" ?>>
                      <label for="exp-6" class="tag-label"><i class="fa fa-archive"></i> Estoque / Logística</label>
                    </div>
                  </div>

                  <!-- 3. PRINCIPAIS HABILIDADES -->
                  <div class="form-group mb-4">
                    <label class="font-weight-bold d-block mb-1">3. Seus Pontos Fortes e Habilidades:</label>
                    <div class="tag-selector-grid">
                      <input type="checkbox" id="hab-1"  name="habilidades[]" value="Pontual e Responsável" class="tag-checkbox" <?= strpos($curriculoModal["informacoes_adicionais"], "Pontualidade") !== false ? "checked" : "" ?>>
                      <label for="hab-1" class="tag-label"><i class="fa fa-clock-o"></i> Pontualidade</label>

                      <input type="checkbox" id="hab-2" name="habilidades[]" value="Boa Comunicação" class="tag-checkbox" <?= strpos($curriculoModal["informacoes_adicionais"], "Boa Comunicação") !== false ? "checked" : "" ?>>
                      <label for="hab-2" class="tag-label"><i class="fa fa-bullhorn"></i> Boa Comunicação</label>

                      <input type="checkbox" id="hab-3" name="habilidades[]" value="Informática Básica" class="tag-checkbox" <?= strpos($curriculoModal["informacoes_adicionais"], "Informática Básica") !== false ? "checked" : "" ?>>
                      <label for="hab-3" class="tag-label"><i class="fa fa-laptop"></i> Informática Básica</label>

                      <input type="checkbox" id="hab-4" name="habilidades[]" value="Trabalho em Equipe" class="tag-checkbox" <?= strpos($curriculoModal["informacoes_adicionais"], "Trabalho em Equipe") !== false ? "checked" : "" ?>>
                      <label for="hab-4" class="tag-label"><i class="fa fa-users"></i> Trabalho em Equipe</label>

                      <input type="checkbox" id="hab-5"  name="habilidades[]" value="Facilidade para Aprender" class="tag-checkbox" <?= strpos($curriculoModal["informacoes_adicionais"], "Facilidade p/ Aprender") !== false ? "checked" : "" ?>>
                      <label for="hab-5" class="tag-label"><i class="fa fa-lightbulb-o"></i> Facilidade p/ Aprender</label>
                    </div>
                  </div>

                  <!-- 4. DISPONIBILIDADE -->
                  <div class="form-group mb-2">
                    <label class="font-weight-bold d-block mb-1">4. Disponibilidade para Trabalhar:</label>
                    <div class="tag-selector-grid">
                      <input type="checkbox" id="disp-1" name="disponibilidade[]"  value="Manhã" class="tag-checkbox" <?= strpos($curriculoModal["informacoes_adicionais"], "Manhã") !== false ? "checked" : "" ?>>
                      <label for="disp-1" class="tag-label"><i class="fa fa-sun-o"></i> Turno Manhã</label>

                      <input type="checkbox" id="disp-2" name="disponibilidade[]" value="Tarde" class="tag-checkbox" <?= strpos($curriculoModal["informacoes_adicionais"], "Tarde") !== false ? "checked" : "" ?>>
                      <label for="disp-2" class="tag-label"><i class="fa fa-sun-o"></i> Turno Tarde</label>

                      <input type="checkbox" id="disp-3"  name="disponibilidade[]" value="Noite" class="tag-checkbox" <?= strpos($curriculoModal["informacoes_adicionais"], "Noite") !== false ? "checked" : "" ?>>
                      <label for="disp-3" class="tag-label"><i class="fa fa-moon-o"></i> Turno Noite</label>

                      <input type="checkbox" id="disp-4" name="disponibilidade[]" value="Integral" class="tag-checkbox" <?= strpos($curriculoModal["informacoes_adicionais"], "Período Integral") !== false ? "checked" : "" ?>>
                      <label for="disp-4" class="tag-label"><i class="fa fa-briefcase"></i> Período Integral</label>
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn-3r-ghost" data-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn-3r-primary">Salvar Meu Currículo</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- MODAL 3: TABULEIRO DA TRILHA -->
        <div class="modal fade modal-custom-3r" id="modalTrilhaGigante" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-map-o"></i> Tabuleiro da Trilha de Aprendizagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body p-4 text-center">
               
                <div class="avatar-picker-section">
                  <h5>1. Escolha seu Avatar:</h5>
                  <div class="avatar-grid">
                    <button type="button" class="btn-avatar active" data-icone="fa-street-view" title="Pessoa"><i class="fa fa-street-view"></i></button>
                    <button type="button" class="btn-avatar" data-icone="fa-car" title="Carro"><i class="fa fa-car"></i></button>
                    <button type="button" class="btn-avatar" data-icone="fa-rocket" title="Foguete"><i class="fa fa-rocket"></i></button>
                    <button type="button" class="btn-avatar" data-icone="fa-star" title="Estrela"><i class="fa fa-star"></i></button>
                  </div>
                </div>

                <div class="trilha-info-banner mt-3 mb-3">
                  <span>Área Escolhida: <strong id="trilha-area-nome"><?= !empty($egresso['area_interesse']) ? htmlspecialchars($egresso['area_interesse']) : 'Não definida' ?></strong></span>
                </div>

                <div id="casa-detalhe-card" class="casa-detalhe-box mb-3 d-none">
                  <h6 id="casa-detalhe-titulo" class="font-weight-bold mb-1">Nome do Curso</h6>
                  <p id="casa-detalhe-desc" class="small text-muted mb-2">Descrição do módulo...</p>
                  <a id="btn-acao-casa" href="formacao.php" class="btn-3r-primary btn-sm">Acessar Curso</a>
                </div>

                <div class="tabuleiro-container">
    <svg class="tabuleiro-path" viewBox="0 0 100 100" preserveAspectRatio="none">
        <path d="M 15 20 Q 50 20 50 40 T 85 60 Q 50 60 50 80 T 15 90"
              fill="transparent"
              stroke="#E2E8F0"
              stroke-width="3"
              stroke-dasharray="4" />
    </svg>

    <?php
    $posicoes = [
        ["top" => "15%", "left" => "12%"],
        ["top" => "55%", "left" => "80%"],
        ["top" => "85%", "left" => "12%"]
    ];

    foreach ($cursosEgresso as $indice => $curso):
        $status = $curso["status_curso"];

        if ($status === "Concluído") {
            $classe = "node-done";
            $icone = "fa-check";
            $statusTrilha = "concluido";
        } else {
            $classe = "node-current";
            $icone = "fa-street-view";
            $statusTrilha = "atual";
        }

        $posicao = $posicoes[$indice % count($posicoes)];
    ?>

        <div
            class="casa-node <?= $classe ?>"
            style="top: <?= $posicao["top"] ?>; left: <?= $posicao["left"] ?>;"
            data-titulo="<?= htmlspecialchars($curso["nome_curso"]) ?>"
            data-desc="<?= htmlspecialchars($curso["descricao"]) ?>"
            data-status="<?= $statusTrilha ?>"
            data-url="<?= htmlspecialchars($curso["url_curso"]) ?>"
        >

            <div class="node-icon">

                <?php if ($status === "Concluído"): ?>

                    <i class="fa fa-check"></i>

                <?php else: ?>

                    <i id="<?= $indice === 0 ? 'pino-jogador-trilha' : '' ?>"
                       class="fa fa-street-view pino-icon"></i>

                <?php endif; ?>

            </div>

            <span class="node-title">
                <?= htmlspecialchars($curso["nome_curso"]) ?>
            </span>

        </div>

    <?php endforeach; ?>

</div>
              </div>
            </div>
          </div>
        </div>

        <!-- FOOTER -->
        <div class="footer" style="background-size: cover;">
            <div class="container">    
                <div class="row footer_bg">                    
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="footer_logo">
                            <img src="assets/img/Logo 3R (5).png" alt="Logo Footer" />
                            <p>Nossa missão é ser a ponte para o seu novo futuro. Ajudamos pessoas em processo de reconstrução a encontrar oportunidades de trabalho e capacitação.</p>
                        </div>
                        <div class="social_profile">
                            <ul>
                                <li><a href="#" class="f_facebook"><i class="fa fa-facebook" title="Facebook"></i></a></li>
                                <li><a href="#" class="f_youtube"><i class="fa fa-youtube" title="YouTube"></i></a></li>
                                <li><a href="#" class="f_instagram"><i class="fa fa-instagram" title="Instagram"></i></a></li>
                                <li><a href="#" class="f_linkedin"><i class="fa fa-linkedin" title="LinkedIn"></i></a></li>
                            </ul>
                        </div>                          
                    </div>                  
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="single_footer">
                            <h4>Dúvidas Frequentes</h4>
                            <ul>
                                <li><a href="#">Privacidade e Segurança</a></li>
                                <li><a href="#">Termos de Uso</a></li>
                                <li><a href="#">Comunicação</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="single_footer">
                            <h4>Plataforma</h4>
                            <ul>
                                <li><a href="#">Sobre Nós</a></li>
                                <li><a href="#">Vagas de Emprego</a></li>
                                <li><a href="formacao.html">Cursos Liberados</a></li>
                            </ul>
                        </div>
                    </div>
                </div>    
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="footer_copyright">
                            <p>&copy; 2026 Plataforma 3R - Recomeçar, Reconstruir e Renascer. <br>Todos os direitos reservados.</p>
                        </div>
                    </div>
                </div>              
            </div>
        </div>

        <!-- JS IMPORTS -->
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
        <script src="assets/js/perfil_egresso.js"></script>
    </body>
</html>