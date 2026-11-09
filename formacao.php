<?php
require_once "php/config/config.php";
exigirLogin();

$sql = "SELECT * FROM curso";
$resultado = $conn->query($sql);
?> 
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Plataforma 3R - Reinserção Social">
        <title>3R - Cursos e Formações</title>           
        
        <!-- CSS Links -->
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">       
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800"> 
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600">           
        <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
        <link rel="stylesheet" href="assets/fonts/themify-icons.css">
        <link rel="stylesheet" href="assets/owlcarousel/css/owl.carousel.css">
        <link rel="stylesheet" href="assets/owlcarousel/css/owl.theme.css">
        <link rel="stylesheet" href="assets/css/animate.css">               
        <link rel="stylesheet" href="assets/css/menu.css">          
        <link rel="stylesheet" href="assets/css/style.css">         
        <link rel="stylesheet" href="assets/css/responsive.css">  
        <link rel="stylesheet" href="assets/css/formacao.css">
    </head>
    
    <body data-spy="scroll" data-offset="80">
        
        <?php include 'nav-bar.php'; ?>

        <!-- START CONTEÚDO PRINCIPAL -->
        <main>
            <!-- BANNER TOPO -->
            <section class="section-top formacao-banner" style="background-image:url(assets/img/bg/section-top.png);background-size:cover;background-position:center;">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 text-center">
                        </div>
                    </div>
                </div>
            </section>

            <!-- INTRODUÇÃO DA PÁGINA -->
            <div class="container">
                <div class="formacao-intro">
                    <h3>Formação 3R</h3>
                    <p>Nós acreditamos que toda pessoa merece uma segunda chance e que a educação é a ferramenta mais poderosa para construir um novo amanhã. Esta página existe para transformar em prática o que a Lei de Execução Penal (LEP) garante como direito: o acesso à qualificação profissional para uma reinserção digna na sociedade. Reunimos aqui cursos práticos e gratuitos, pensados estrategicamente para que você desenvolva novas habilidades, conquiste sua autonomia e se prepare para o mercado de trabalho. Escolha uma área abaixo e dê o próximo passo no seu progresso!</p>
                </div>
            </div>

            <!-- DIFERENCIAIS DA FORMAÇÃO (Layout Exclusivo em Grid 2x2) -->
            <div class="formacao-diferenciais">
                <div class="dif-card">
                    <div class="dif-numero">01</div>
                    <div class="dif-conteudo">
                        <span class="dif-tag">O Direito ao Estudo</span>
                        <h4>Direito Fundamental</h4>
                        <p>A lei garante que o processo de retorno à sociedade deve incluir obrigatoriamente a instrução escolar e a formação profissional.</p>
                        <span class="dif-artigo">Art. 17 — LEP</span>
                    </div>
                </div>

                <div class="dif-card">
                    <div class="dif-numero">02</div>
                    <div class="dif-conteudo">
                        <span class="dif-tag">Qualificação Técnica</span>
                        <h4>Ensino Profissionalizante</h4>
                        <p>A capacitação deve ser oferecida para preparar e aperfeiçoar o cidadão, desenvolvendo habilidades reais para o mercado de trabalho.</p>
                        <span class="dif-artigo">Art. 19 — LEP</span>
                    </div>
                </div>

                <div class="dif-card">
                    <div class="dif-numero">03</div>
                    <div class="dif-conteudo">
                        <span class="dif-tag">Remição de Pena</span>
                        <h4>Desconto pelo Estudo</h4>
                        <p>A dedicação às atividades educativas e aos cursos de qualificação permite abater dias da pena, acelerando a progressão de regime.</p>
                        <span class="dif-artigo">Art. 126 — LEP</span>
                    </div>
                </div>

                <div class="dif-card">
                    <div class="dif-numero">04</div>
                    <div class="dif-conteudo">
                        <span class="dif-tag">Incentivo ao Diploma</span>
                        <h4>Acréscimo por Formatura</h4>
                        <p>O tempo abatido da pena em função do estudo será aumentado em 1/3 quando o cidadão conclui com sucesso o curso ou nível de ensino.</p>
                        <span class="dif-artigo">Art. 126, §5º — LEP</span>
                    </div>
                </div>
            </div>

            <!-- FILTROS E LISTA DE CURSOS -->
            <section class="blog_area section-padding formacoes-area">
                <div class="container">
                    
                    <div class="text-center mb-5">
                        <button class="filtro-btn ativo" data-filtro="todos">Todos</button>
                        <button class="filtro-btn" data-filtro="tecnologia">Tecnologia</button>
                        <button class="filtro-btn" data-filtro="comercial">Comercial</button>
                        <button class="filtro-btn" data-filtro="administrativo">Administrativo</button>
                        <button class="filtro-btn" data-filtro="idiomas">Idiomas</button>
                        <button class="filtro-btn" data-filtro="negocios">Negócios</button>
                        <button class="filtro-btn" data-filtro="desenvolvimento">Desenvolvimento Pessoal</button>
                        <button class="filtro-btn" data-filtro="operacional">Operacional</button>
                    </div>

                    <div class="row" id="listaCursos">
                        <!-- CURSOS DINÂMICOS DO BANCO -->
                        <?php
                        $sql = "SELECT * FROM curso";
                        $resultado = $conn->query($sql);

                        while ($curso = $resultado->fetch_assoc()) {
                        ?>
                        <div class="col-lg-4 col-md-6 curso-item mb-4" data-categoria="<?= htmlspecialchars($curso['area']) ?>">
                            <div class="formacao-card">
                                <img 
                                    src="/tcc-1/php/uploads/<?= htmlspecialchars($curso['img_curso']) ?>" 
                                    class="img-fluid" 
                                    alt="<?= htmlspecialchars($curso['nome_curso']) ?>"
                                >
                                <div class="formacao-content">
                                    <span class="categoria">
                                        <?= htmlspecialchars(ucfirst($curso['area'])) ?>
                                    </span>

                                    <h2>
                                        <?= htmlspecialchars($curso['nome_curso']) ?>
                                    </h2>

                                    <p>
                                        <?= htmlspecialchars($curso['descricao']) ?>
                                    </p>

                                    <div class="formacao-info">
                                        <i class="fa fa-clock-o"></i>
                                        <?= htmlspecialchars($curso['carga_horaria']) ?> horas
                                    </div>

                                    <button 
                                        class="formacao-btn"
                                        onclick='abrirModalCurso(
                                            <?= json_encode($curso["id_curso"]) ?>,
                                            <?= json_encode($curso["nome_curso"]) ?>,
                                            <?= json_encode($curso["carga_horaria"] . " horas") ?>,
                                            <?= json_encode($curso["descricao"]) ?>,
                                            <?= json_encode($curso["url_curso"]) ?>,
                                            <?= json_encode($curso["certificado"]) ?>,
                                            <?= json_encode($curso["conteudo_programatico"]) ?>
                                        )'>
                                        <i class="fa fa-graduation-cap"></i> Acessar Formação
                                    </button>

                                    <?php if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] === "administrador"): ?>
                                    <div class="admin-card-actions">
                                        <button 
                                            type="button" 
                                            class="btn-card-edit"
                                            onclick='abrirModalEditar(
                                                <?= json_encode($curso["id_curso"]) ?>,
                                                <?= json_encode($curso["nome_curso"]) ?>,
                                                <?= json_encode($curso["area"]) ?>,
                                                <?= json_encode($curso["carga_horaria"]) ?>,
                                                <?= json_encode($curso["certificado"]) ?>,
                                                <?= json_encode($curso["descricao"]) ?>,
                                                <?= json_encode($curso["conteudo_programatico"]) ?>,
                                                <?= json_encode($curso["url_curso"]) ?>
                                            )'>
                                            <i class="fa fa-pencil"></i> Editar
                                        </button>

                                        <button 
                                            type="button" 
                                            class="btn-card-delete" 
                                            onclick="abrirModalExcluir(<?= $curso['id_curso'] ?>, '<?= addslashes(htmlspecialchars($curso['nome_curso'], ENT_QUOTES)) ?>')">
                                            <i class="fa fa-trash"></i> Excluir
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                        
                    <?php if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] === "administrador"): ?>
                    <!-- ÁREA ADMINISTRADOR -->
                    <div class="area-admin">
                        <h3>Área Administrativa</h3>
                        <p>Publique novas formações na plataforma.</p>
                        <button class="btn-admin" onclick="abrirModalCadastro()">
                            <i class="fa fa-plus-circle"></i> Publicar Formação
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            </section>
        </main>

        <!-- MODAL VER DETALHES DO CURSO -->
        <div id="modalCurso" class="modal-overlay" style="display:none;">
            <div class="modal-content">
                <img src="assets/img/Logo 3R .png" class="logo-modal" alt="Logo 3R">
                <h2 id="cursoTitulo">Nome do Curso</h2>
                
                <div class="curso-dados">
                    <span id="cursoHoras">Carga horária</span>
                    <span class="curso-certificado">
                        <i class="fa fa-certificate"></i> Com Certificado
                    </span>
                </div>
                
                <h5>Sobre a Formação</h5>
                <p id="cursoDescricao">Descrição do curso.</p>
                
                <h5>Conteúdo Programático</h5>
                <ul id="cursoConteudo">
                </ul>
                
                <a id="cursoLink" href="#" target="_blank" class="btn-inscricao-3r">
                    Inscrever-se na Formação
                </a>
                <form id="formConcluirCurso" action="php/egresso/concluir_curso.php" method="POST">
                    <input type="hidden" id="idCursoConcluir" name="id_curso">
                    <button type="submit" class="btn-inscricao-3r">
                        Marcar como concluído
                    </button>
                </form>
                <button onclick="fecharModalCurso()" class="btn-fechar">
                    Fechar
                </button>
            </div>
        </div>

        <!-- MODAL CADASTRO ADMINISTRADOR -->
        <div id="modalCadastro" class="modal-overlay" style="display:none;">
            <div class="modal-content modal-admin">
                <img src="assets/img/Logo 3R .png" class="logo-modal" alt="Logo 3R">
                <h2>
                    <i class="fa fa-plus-circle"></i> Cadastrar Nova Formação
                </h2>
                <form id="formAdminCurso" class="form-admin" action="php/admin/create_curso.php" method="POST" enctype="multipart/form-data">
                    <label>Foto da Capa do Curso</label>
                    <input type="file" id="imagemCurso" name="img_curso" accept="image/png, image/jpeg, image/webp" required>
                    
                    <label>Categoria da Formação</label>
                    <select id="categoriaCurso" name="area">
                        <option value="tecnologia">Tecnologia</option>
                        <option value="comercial">Comercial</option>
                        <option value="administrativo">Administrativo</option>
                        <option value="idiomas">Idiomas</option>
                        <option value="negocios">Negócios</option>
                        <option value="desenvolvimento">Desenvolvimento Pessoal</option>
                        <option value="operacional">Operacional</option>
                    </select>
                    
                    <label>Nome da Formação</label>
                    <input type="text" id="nomeCurso" name="nome_curso" placeholder="Ex: Inglês Básico para o Trabalho" required>
                    
                    <label>Carga Horária (em horas)</label>
                    <input type="text" id="cargaCurso" name="carga_horaria" placeholder="Ex: 80" required>
                    
                    <label>Possui Certificado?</label>
                    <select id="certificadoCurso" name="certificado">
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                    </select>
                    
                    <label>Sobre a Formação</label>
                    <textarea id="descricaoCurso" name="descricao" placeholder="Digite a descrição da formação" required></textarea>
                    
                    <label>Conteúdo Programático</label>
                    <textarea id="conteudoCurso" name="conteudo_programatico" placeholder="Ex: Vocabulário profissional..." required></textarea>
                    
                    <label>Link da Formação</label>
                    <input type="url" id="linkCurso" name="url_curso" placeholder="https://..." required>
                    
                    <button type="submit" class="btn-publicar">
                        <i class="fa fa-check-circle"></i> Publicar Curso
                    </button>
                </form>
                <button onclick="fecharModalCadastro()" class="btn-fechar">
                    Cancelar
                </button>
            </div>
        </div>

        <!-- MODAL EDITAR FORMAÇÃO (NOVO E COMPLETO) -->
        <div id="modalEditar" class="modal-overlay" style="display:none;">
            <div class="modal-content modal-admin">
                <img src="assets/img/Logo 3R .png" class="logo-modal" alt="Logo 3R">
                <h2>
                    <i class="fa fa-pencil-square-o"></i> Editar Formação
                </h2>
                <form id="formEditarCurso" class="form-admin" action="php/admin/editar_curso.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="edit_id_curso" name="id">
                    
                    <label>Alterar Capa (Deixe em branco para manter a imagem atual)</label>
                    <input type="file" id="edit_imagemCurso" name="img_curso" accept="image/png, image/jpeg, image/webp">
                    
                    <label>Categoria da Formação</label>
                    <select id="edit_categoriaCurso" name="area">
                        <option value="tecnologia">Tecnologia</option>
                        <option value="comercial">Comercial</option>
                        <option value="administrativo">Administrativo</option>
                        <option value="idiomas">Idiomas</option>
                        <option value="negocios">Negócios</option>
                        <option value="desenvolvimento">Desenvolvimento Pessoal</option>
                        <option value="operacional">Operacional</option>
                    </select>
                    
                    <label>Nome da Formação</label>
                    <input type="text" id="edit_nomeCurso" name="nome_curso" placeholder="Ex: Inglês Básico para o Trabalho" required>
                    
                    <label>Carga Horária (em horas)</label>
                    <input type="text" id="edit_cargaCurso" name="carga_horaria" placeholder="Ex: 80" required>
                    
                    <label>Possui Certificado?</label>
                    <select id="edit_certificadoCurso" name="certificado">
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                    </select>
                    
                    <label>Sobre a Formação</label>
                    <textarea id="edit_descricaoCurso" name="descricao" placeholder="Digite a descrição da formação" required></textarea>
                    
                    <label>Conteúdo Programático</label>
                    <textarea id="edit_conteudoCurso" name="conteudo_programatico" placeholder="Ex: Vocabulário profissional..." required></textarea>
                    
                    <label>Link da Formação</label>
                    <input type="url" id="edit_linkCurso" name="url_curso" placeholder="https://..." required>
                    
                    <button type="submit" class="btn-publicar">
                        <i class="fa fa-save"></i> Salvar Alterações
                    </button>
                </form>
                <button onclick="fecharModalEditar()" class="btn-fechar">
                    Cancelar
                </button>
            </div>
        </div>

        <!-- MODAL CONFIRMAÇÃO DE EXCLUSÃO CUSTOMIZADO -->
        <div id="modalExcluirCurso" class="modal-overlay" style="display:none;">
            <div class="modal-content modal-confirm-delete">
                <div class="modal-delete-icon">
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
                <h2>Excluir Formação?</h2>
                <p>Você tem certeza que deseja excluir a formação <strong id="nomeCursoExcluir"></strong>?</p>
                <p style="font-size:12px; color:#888; margin-top:4px;">Esta ação é permanente e não poderá ser desfeita.</p>
                
                <form id="formExcluirCurso" action="php/admin/excluir_curso.php" method="POST">
                    <input type="hidden" name="id" id="idCursoExcluir">
                    <div class="modal-delete-buttons">
                        <button type="button" onclick="fecharModalExcluir()" class="btn-cancelar-delete">Cancelar</button>
                        <button type="submit" class="btn-confirmar-delete">Sim, Excluir</button>
                    </div>
                </form>
            </div>
        </div>

        <?php include 'footer.php';?>

        <!-- Scripts JS -->
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
        <script src="assets/js/modal-actions.js"></script> 

        <script>
            // FUNÇÕES PARA O MODAL DE EXCLUIR
            function abrirModalExcluir(id, nome) {
                document.getElementById('idCursoExcluir').value = id;
                document.getElementById('nomeCursoExcluir').textContent = nome;
                document.getElementById('modalExcluirCurso').style.display = 'flex';
            }

            function fecharModalExcluir() {
                document.getElementById('modalExcluirCurso').style.display = 'none';
            }

            // FUNÇÕES PARA O MODAL DE EDITAR
            function abrirModalEditar(id, nome, area, carga, certificado, descricao, conteudo, url) {
                document.getElementById('edit_id_curso').value = id;
                document.getElementById('edit_nomeCurso').value = nome;
                document.getElementById('edit_categoriaCurso').value = area;
                document.getElementById('edit_cargaCurso').value = carga;
                document.getElementById('edit_certificadoCurso').value = certificado;
                document.getElementById('edit_descricaoCurso').value = descricao;
                document.getElementById('edit_conteudoCurso').value = conteudo;
                document.getElementById('edit_linkCurso').value = url;
                document.getElementById('modalEditar').style.display = 'flex';
            }

            function fecharModalEditar() {
                document.getElementById('modalEditar').style.display = 'none';
            }
        </script>
    </body>
</html>