<?php

require_once "php/config/config.php";

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
        
        <!-- START NAVBAR -->
        <div class="site-mobile-menu site-navbar-target">
          <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
              <span class="icon-close2 js-menu-toggle"></span>
            </div>
          </div>
          <div class="site-mobile-menu-body"></div>
        </div>
       
        <header class="site-navbar js-sticky-header site-navbar-target" role="banner">
          <div class="container">
            <div class="row align-items-center">       
              <div class="col-6 col-xl-2">
                <h1 class="mb-0 site-logo"><a href="index.html"><img src="assets/img/Logo 3R .png" alt="Logo 3R"></a></h1>
              </div>
              <div class="col-12 col-md-10 d-none d-xl-block">
                <nav class="site-navigation position-relative text-right" role="navigation">
                  <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                    <li class="nav-link"> <a href="index.html" class="nav-link">Home</a></li>   
                    <li><a class="nav-link" href="trabalhista.html">Trabalhista</a></li>                
                    <li><a class="nav-link" href="formacao.php">Formação</a></li>                                
                    <li><a href="login.html" class="nav-link">Login</a></li>
                  </ul>   
                </nav>
              </div>
              <div class="col-6 d-inline-block d-xl-none ml-md-0 py-3" style="position: relative; top: 3px;">
                <a href="#" class="site-menu-toggle js-menu-toggle float-right"><span class="icon-menu h3"></span></a>
              </div>
            </div>
          </div>
        </header>
        <!-- END NAVBAR -->    


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
                        <!-- CURSO 1 -->
                         <?php

$sql = "SELECT * FROM curso";

$resultado = $conn->query($sql);

while ($curso = $resultado->fetch_assoc()) {

?>

<div class="col-lg-4 col-md-6 curso-item" data-categoria="<?= $curso['area'] ?>">

    <div class="formacao-card">

        <img 
        src="/tcc-1/php/uploads/<?= $curso['img_curso'] ?>" 
        class="img-fluid" 
        alt="<?= $curso['nome_curso'] ?>"
        >
        <div class="formacao-content">

            <span class="categoria">
                <?= ucfirst($curso['area']) ?>
            </span>

            <h2>
                <?= $curso['nome_curso'] ?>
            </h2>

            <p>
                <?= $curso['descricao'] ?>
            </p>

            <div class="formacao-info">
                <i class="fa fa-clock-o"></i>
                <?= $curso['carga_horaria'] ?> horas
            </div>

            <button 
            class="formacao-btn"
            onclick="abrirModalCurso(
                '<?= $curso['nome_curso'] ?>',
                '<?= $curso['carga_horaria'] ?> horas',
                '<?= $curso['descricao'] ?>',
                '<?= $curso['url_curso'] ?>'
            )">

                Acessar Formação

            </button>
            <a href="php/admin/editar_curso.php?id=<?= $curso['id_curso'] ?>"class="btn btn-warning">Editar</a>
            <form action="php/admin/excluir_curso.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este curso?');" style="display:inline;">
    
    <input type="hidden" name="id" value="<?= $curso['id_curso'] ?>">

    <button type="submit">
        Excluir
    </button>

</form>
        </div>

    </div>

</div>

<?php

}

?>
                        <div class="col-lg-4 col-md-6 curso-item" data-categoria="tecnologia">
                            <div class="formacao-card">
                                <img src="assets/img/blog/1.jpg" class="img-fluid" alt="Informática Básica">
                                <div class="formacao-content">
                                    <span class="categoria">Tecnologia</span>
                                    <h2>Informática Básica</h2>
                                    <p>Aprenda conceitos essenciais de computadores, internet e ferramentas digitais.</p>
                                    <div class="formacao-info">
                                        <i class="fa fa-clock-o"></i> 40 horas
                                    </div>
                                    <button class="formacao-btn" onclick="abrirModalCurso('Informática Básica','40 horas','Curso completo para iniciantes em informática, apresentando conceitos básicos de computador, internet e ferramentas digitais.','https://www.curso.com.br')">
                                        Acessar Formação
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- CURSO 2 -->
                        <div class="col-lg-4 col-md-6 curso-item" data-categoria="idiomas">
                            <div class="formacao-card">
                                <img src="assets/img/blog/2.jpg" class="img-fluid" alt="Inglês Básico">
                                <div class="formacao-content">
                                    <span class="categoria">Idiomas</span>
                                    <h2>Inglês Básico para o Trabalho</h2>
                                    <p>Vocabulário e situações profissionais para auxiliar no mercado de trabalho.</p>
                                    <div class="formacao-info">
                                        <i class="fa fa-clock-o"></i> 80 horas
                                    </div>
                                    <button class="formacao-btn" onclick="abrirModalCurso('Inglês Básico para o Trabalho','80 horas','Curso focado em vocabulário profissional, e-mails, documentos, conversação básica e apresentações.','https://www.curso.com.br')">
                                        Acessar Formação
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- CURSO 3 -->
                        <div class="col-lg-4 col-md-6 curso-item" data-categoria="comercial">
                            <div class="formacao-card">
                                <img src="assets/img/blog/3.jpg" class="img-fluid" alt="Atendimento ao Cliente">
                                <div class="formacao-content">
                                    <span class="categoria">Comercial</span>
                                    <h2>Atendimento ao Cliente</h2>
                                    <p>Desenvolva comunicação e relacionamento com clientes.</p>
                                    <div class="formacao-info">
                                        <i class="fa fa-clock-o"></i> 30 horas
                                    </div>
                                    <button class="formacao-btn" onclick="abrirModalCurso('Atendimento ao Cliente','30 horas','Formação voltada para comunicação, postura profissional e atendimento de qualidade.','https://www.curso.com.br')">
                                        Acessar Formação
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- CURSO 4 -->
                        <div class="col-lg-4 col-md-6 curso-item" data-categoria="administrativo">
                            <div class="formacao-card">
                                <img src="assets/img/blog/4.jpg" class="img-fluid" alt="Excel para Escritórios">
                                <div class="formacao-content">
                                    <span class="categoria">Administrativo</span>
                                    <h2>Excel para Escritórios</h2>
                                    <p>Aprenda ferramentas essenciais para organização e produtividade administrativa.</p>
                                    <div class="formacao-info">
                                        <i class="fa fa-clock-o"></i> 60 horas
                                    </div>
                                    <button class="formacao-btn" onclick="abrirModalCurso('Excel para Escritórios','60 horas','Curso de planilhas, organização de dados e ferramentas utilizadas no ambiente administrativo.','https://www.curso.com.br')">
                                        Acessar Formação
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- CURSO 5 -->
                        <div class="col-lg-4 col-md-6 curso-item" data-categoria="negocios">
                            <div class="formacao-card">
                                <img src="assets/img/blog/5.jpg" class="img-fluid" alt="Empreendedorismo">
                                <div class="formacao-content">
                                    <span class="categoria">Negócios</span>
                                    <h2>Empreendedorismo</h2>
                                    <p>Aprenda conceitos para iniciar um negócio e desenvolver ideias.</p>
                                    <div class="formacao-info">
                                        <i class="fa fa-clock-o"></i> 40 horas
                                    </div>
                                    <button class="formacao-btn" onclick="abrirModalCurso('Empreendedorismo','40 horas','Formação sobre planejamento, organização e desenvolvimento de negócios.','https://www.curso.com.br')">
                                        Acessar Formação
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- CURSO 6 -->
                        <div class="col-lg-4 col-md-6 curso-item" data-categoria="desenvolvimento">
                            <div class="formacao-card">
                                <img src="assets/img/blog/6.jpg" class="img-fluid" alt="Comunicação Profissional">
                                <div class="formacao-content">
                                    <span class="categoria">Desenvolvimento Pessoal</span>
                                    <h2>Comunicação Profissional</h2>
                                    <p>Melhore sua comunicação e postura no ambiente profissional.</p>
                                    <div class="formacao-info">
                                        <i class="fa fa-clock-o"></i> 20 horas
                                    </div>
                                    <button class="formacao-btn" onclick="abrirModalCurso('Comunicação Profissional','20 horas','Curso voltado ao desenvolvimento da comunicação, confiança e relacionamento profissional.','https://www.curso.com.br')">
                                        Acessar Formação
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- CURSO 7 -->
                        <div class="col-lg-4 col-md-6 curso-item" data-categoria="operacional">
                            <div class="formacao-card">
                                <img src="assets/img/blog/7.jpg" class="img-fluid" alt="Segurança no Trabalho">
                                <div class="formacao-content">
                                    <span class="categoria">Operacional</span>
                                    <h2>Segurança no Trabalho</h2>
                                    <p>Conhecimentos básicos sobre prevenção e ambiente profissional seguro.</p>
                                    <div class="formacao-info">
                                        <i class="fa fa-clock-o"></i> 40 horas
                                    </div>
                                    <button class="formacao-btn" onclick="abrirModalCurso('Segurança no Trabalho','40 horas','Formação com conceitos básicos de segurança, prevenção de riscos e comportamento profissional.','https://www.curso.com.br')">
                                        Acessar Formação
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ÁREA ADMINISTRADOR -->
                    <div class="area-admin">
                        <h3>Área Administrativa</h3>
                        <p>Publique novas formações na plataforma.</p>
                        <button class="btn-admin" onclick="abrirModalCadastro()">
                            <i class="fa fa-plus"></i> Publicar Formação
                        </button>
                    </div>

                </div>
            </section>
        </main>

        <!-- MODAL CURSO -->
        <div id="modalCurso" class="modal-overlay" style="display:none;">
            <div class="modal-content">
                <img src="assets/img/Logo 3R .png" class="logo-modal">
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
                    <li>Conteúdo da formação</li>
                    <li>Desenvolvimento profissional</li>
                    <li>Preparação para o mercado</li>
                </ul>
                
                <a id="cursoLink" href="#" target="_blank" class="btn-inscricao-3r">
                    Inscrever-se na Formação
                </a>
                <button onclick="fecharModalCurso()" class="btn-fechar">
                    Fechar
                </button>
            </div>
        </div>

        <!-- MODAL CADASTRO ADMINISTRADOR -->
        <div id="modalCadastro" class="modal-overlay" style="display:none;">
            <div class="modal-content modal-admin">
                <img src="assets/img/Logo 3R .png" class="logo-modal">
                <h2>
                    <i class="fa fa-plus-circle"></i> Cadastrar Nova Formação
                </h2>
                <form id="formAdminCurso" class="form-admin" action="php/admin/create_curso.php" method="POST" enctype= 'multipart/form-data'>
                    <label>Foto da Capa do Curso</label>
                    <input type="file" id="imagemCurso" name="img_curso" accept="image/png, image/jpeg, image/webp" required>
                    
                    <label>Categoria da Formação</label>
                    <select id="categoriaCurso" name='area'>
                        <option value="tecnologia">Tecnologia</option>
                        <option value="comercial">Comercial</option>
                        <option value="administrativo">Administrativo</option>
                        <option value="idiomas">Idiomas</option>
                        <option value="negocios">Negócios</option>
                        <option value="desenvolvimento">Desenvolvimento Pessoal</option>
                        <option value="operacional">Operacional</option>
                    </select>
                    
                    <label>Nome da Formação</label>
                    <input type="text" id="nomeCurso" name='nome_curso' placeholder="Ex: Inglês Básico para o Trabalho" required>
                    
                    <label>Carga Horária</label>
                    <input type="text" id="cargaCurso" name="carga_horaria" placeholder="Ex: 80 horas" required>
                    
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
                        Publicar Curso
                    </button>
                    <a href="../php/admin/listar_curso.php"> Gerenciar Cursos </a>
                </form>
                <button onclick="fecharModalCadastro()" class="btn-fechar">
                    Cancelar
                </button>
            </div>
        </div>

        <!-- START FOOTER -->
        <div class="footer" style="background-size:cover;">
            <div class="container">     
                <div class="row footer_bg">                     
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="footer_logo">
                            <img src="assets/img/Logo 3R (5).png" alt="" />
                            <p>Nossa missão é ser a ponte para o seu novo futuro. Ajudamos pessoas em processo de reconstrução a encontrar oportunidades de trabalho e capacitação.</p>
                        </div>
                        <div class="social_profile">
                            <ul>
                                <li><a href="#" class="f_facebook"><i class="fa fa-facebook" title="Facebook"></i></a></li>
                                <li><a href="#" class="f_twitter"><i class="fa fa-youtube" title="Twitter"></i></a></li>
                                <li><a href="#" class="f_instagram"><i class="fa fa-instagram" title="Instagram"></i></a></li>
                                <li><a href="#" class="f_linkedin"><i class="fa fa-linkedin" title="LinkedIn"></i></a></li>
                            </ul>
                        </div>                          
                    </div>                  
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="single_footer">
                            <h4>Frequently Asked Questions</h4>
                            <ul>
                                <li><a href="#">Privacy & Securty</a></li>
                                <li><a href="#">Terms of Service</a></li>
                                <li><a href="#">Communications</a></li>
                                <li><a href="#">Referral Terms</a></li>
                                <li><a href="#">Disclaimers</a></li>
                            </ul>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-sm-6 col-xs-1">
                        <div class="single_footer">
                            <h4>Company</h4>
                            <ul>
                                <li><a href="#">Licenses</a></li>
                                <li><a href="#">market API</a></li>
                                <li><a href="#">Careers and job</a></li>
                                <li><a href="#">Emplois en France</a></li>
                                <li><a href="#">Jobs in Deutschland </a></li>                       
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
        <!-- END FOOTER --> 

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
    </body>
</html>