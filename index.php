<?php
require_once __DIR__ . '/php/config/config.php';
?> 
<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Meta -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Monoline - Design Agency HTML Template">
        <meta name="keywords" content="agency, business, corporate, creative, html5, modern, multipurpose, One Page, parallax, startup ">       
        <!-- SITE TITLE -->
        <title>3R - Recomeçar, Reconstruir e Renascer</title>           
        <!-- Latest Bootstrap min CSS -->
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">       
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800"> 
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600">           
        <!-- Font Awesome CSS -->
        <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
        <link rel="stylesheet" href="assets/fonts/themify-icons.css">
        <!--- owl carousel Css-->
        <link rel="stylesheet" href="assets/owlcarousel/css/owl.carousel.css">
        <link rel="stylesheet" href="assets/owlcarousel/css/owl.theme.css">
        <!--materialdesignicons Css-->
        <link rel="stylesheet" href="assets/css/fonts.css">     
        <!-- animate CSS -->
        <link rel="stylesheet" href="assets/css/animate.css">       
        <!-- Venobox CSS -->
        <link rel="stylesheet" href="assets/css/venobox.css">           
        <!-- MAGNIFIC CSS -->
        <link rel="stylesheet" href="assets/css/magnific-popup.css">                    
        <!-- Style CSS -->                      
        <link rel="stylesheet" href="assets/css/menu.css">  
        <link rel="stylesheet" href="assets/css/slider.css">            
        <link rel="stylesheet" href="assets/css/style.css">                 
        <link rel="stylesheet" href="assets/css/responsive.css">  
        
        <!-- SEU CSS EXCLUSIVO DA HOME - SEMPRE POR ÚLTIMO -->          
        <link rel="stylesheet" href="assets/css/index.css">

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    
    <body>
       <?php include 'nav-bar.php'; ?>
        <!-- START PRELOADER -->
        <div class="preloader">
            <div class="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>
        <!-- END PRELOADER -->      

        <!-- START HOME (CARROSSEL) -->
        <div id="kenburns_061" class="carousel slide ps_indicators_txt_icon ps_control_txt_icon data-bs-target kbrns_zoomInOut thumb_scroll_x swipe_x ps_easeOutQuart" data-ride="carousel" data-pause="hover" data-interval="10000" data-duration="2000">
            <!-- Wrapper For Slides -->
            <div class="carousel-inner" role="listbox">
                <!-- First Slide -->
                <div class="carousel-item active">
                    <img src="assets/img/bg/Fundo.png" alt="slider-image" />
                    <div class="kenburns_061_slide" data-animation="animated fadeInRight">
                        <h2>Uma Iniciativa IFPR Campus Pinhais</h2>
                        <h1>Uma nova chance para recomeçar com dignidade</h1>
                        <h3>A Plataforma 3R conecta egressos do sistema prisional a oportunidades reais de emprego...</h3>
                        <div class="hero-buttons-container">
                            <a href="cadastro.php" class="btn-hero-dark"><i class="fa fa-user-plus"></i> Cadastre-se</a>
                        </div>
                    </div>
                </div>
                
                <!-- Second Slide -->
                <div class="carousel-item">
                    <img src="assets/img/bg/Fundo.png" alt="slider-image" />
                    <div class="kenburns_061_slide kenburns_061_slide_center" data-animation="animated fadeInLeft">
                        <h1>Crie seu Currículo</h1>
                        <h3>Nossa plataforma auxilia você na criação do seu currículo...</h3>
                        <div class="hero-buttons-container">
                            <a href="perfil_egresso.php" class="btn-hero-dark">Criar Currículo</a>
                        </div>
                    </div>
                </div>

                <!-- Third Slide -->
                <div class="carousel-item">
                    <img src="assets/img/bg/Fundo.png" alt="slider-image" />
                    <div class="kenburns_061_slide kenburns_061_slide_center" data-animation="animated fadeInDown">
                        <h1>Encontre Oportunidades</h1>
                        <h3>Acesse vagas exclusivas de empresas parceiras comprometidas com a reinserção social...</h3>
                        <div class="hero-buttons-container">
                            <a href="trabalhista.php" class="btn-hero-dark">Ver Vagas</a>
                        </div>
                    </div>
                </div>

                <!-- Fourth Slide -->
                <div class="carousel-item">
                    <img src="assets/img/bg/Fundo.png" alt="slider-image" />
                    <div class="kenburns_061_slide kenburns_061_slide_center" data-animation="animated fadeInDown">
                        <h1>Qualifique-se</h1>
                        <h3>Acesse cursos gratuitos e certificados que vão ampliar suas competências...</h3>
                        <div class="hero-buttons-container">
                            <a href="formacao.php" class="btn-hero-dark">Ver Cursos</a>
                        </div>
                    </div>
                </div>
            </div><!-- End of Wrapper For Slides -->

            <!-- Controles do Carrossel -->
            <button class="carousel-control-prev" type="button" data-bs-target="#kenburns_061" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#kenburns_061" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>       
        </div>
        <!-- END HOME -->

        <!-- FEATURES - O QUE SIGNIFICA 3R (ISOLADO E REESTILIZADO) -->
        <section class="secao-3r-custom">
            <div class="container"> 
                <div class="row align-items-center">
                    
                    <!-- LADO ESQUERDO: Caixinha de texto totalmente estilizada -->
                    <div class="col-lg-5 col-md-12 mb-5 mb-lg-0 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.1s">
                        <div class="caixinha-texto-3r">    
                            <h2>O que significa 3R?</h2>
                            <div class="divisor-linha"></div>
                            
                            <p class="p-principal">
                                3R é mais do que um nome — é uma filosofia. Acreditamos que toda pessoa merece uma segunda chance, e que a tecnologia pode ser a ponte entre o passado e um futuro com oportunidades reais. 
                            </p>
                            
                            <p class="p-secundario">
                                Esta plataforma foi desenvolvida como Trabalho de Conclusão de Curso no IFPR Pinhais para demonstrar como soluções digitais podem contribuir com políticas públicas de reinserção social.
                            </p>
                        </div>
                    </div>
                    
                    <!-- LADO DIREITO: Os 3 pilares numerados -->
                    <div class="col-lg-7 col-md-12 wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                        <div class="row">
                            
                            <!-- Item 01 - Recomeçar -->
                            <div class="col-md-12 mb-4">
                                <div class="pilar-3r-item pilar-amarelo">
                                    <div class="pilar-number">01</div>
                                    <div class="pilar-text">
                                        <h4>Recomeçar</h4>
                                        <p>Dar o primeiro passo com apoio real: emprego, qualificação e documentação para iniciar uma nova jornada.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Item 02 - Reconstruir -->
                            <div class="col-md-12 mb-4">
                                <div class="pilar-3r-item pilar-laranja">
                                    <div class="pilar-number">02</div>
                                    <div class="pilar-text">
                                        <h4>Reconstruir</h4>
                                        <p>Construir uma vida estável, com trabalho digno, vínculos familiares fortalecidos e participação na comunidade.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Item 03 - Renascer -->
                            <div class="col-md-12">
                                <div class="pilar-3r-item pilar-azul">
                                    <div class="pilar-number">03</div>
                                    <div class="pilar-text">
                                        <h4>Renascer</h4>
                                        <p>Reconhecer que o passado não define o futuro e que cada pessoa tem a capacidade de se transformar.</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>              
            </div>
        </section>

        <!-- FEATURES - DIREITOS DOS EGRESSOS --> 
        <section class="feature_area section-padding">
            <div class="container"> 
                <div class="row feature_bg">
                    <div class="section-title text-center">    
                        <h2>Direitos dos Egressos</h2>
                        <p>Conheça o que a lei garante para quem cumpriu sua pena e busca recomeçar.</p>
                    </div>                  
                    <div class="col-lg-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s" data-wow-offset="0">
                        <div class="single_feature Card1">
                            <h6>Assistência ao Egresso</h6>
                            <h4>Orientação e Apoio por até 1 Ano</h4>
                            <p>O egresso tem direito à orientação e apoio para sua reintegração à vida em liberdade por até 1 ano após deixar o sistema prisional.</p>
                            <p class="artigo Card">Art. 25 a 27 — LEP</p>
                        </div>
                    </div>              
                    <div class="col-lg-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s" data-wow-offset="0">
                        <div class="single_feature Card2">
                            <h6>Proteção ao Trabalho</h6>
                            <h4>Igualdade de Direitos</h4>
                            <p>A Constituição protege a igualdade de direitos e combate discriminações ilegais, inclusive no acesso ao trabalho, conforme a legislação.</p>
                            <p class="artigo Card">CF/88 — Art. 5º, caput e XLI</p>
                        </div>
                    </div>              
                    <div class="col-lg-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s" data-wow-offset="0">
                        <div class="single_feature Card3">
                            <h6>Reabilitação Criminal</h6>
                            <h4>Sigilo da Condenação</h4>
                            <p>Após 2 anos da extinção da pena, o egresso pode solicitar a reabilitação criminal, garantindo o sigilo da condenação nos termos da lei.</p>
                            <p class="artigo Card">Código Penal — Art. 93 a 95</p>
                        </div>
                    </div>  
                    <div class="col-lg-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s" data-wow-offset="0">
                        <div class="single_feature Card4">
                            <h6>Sistema Prisional</h6>
                            <h4>Remição de Pena por Estudo e Trabalho</h4>
                            <p>Pessoas privadas de liberdade podem reduzir parte da pena por meio do estudo ou do trabalho, conforme os critérios previstos em lei.</p>
                            <p class="artigo Card">LEP — Art. 126 a 130</p>
                        </div>
                    </div>      
                </div>              
            </div>
        </section>      

   <!-- SKILLS - PERFIL DA POPULAÇÃO (VERSÃO PREMIUM) -->
        <section class="skills_area section-padding">
            <div class="container">
                <div class="row align-items-center">
                    
                    <!-- LADO ESQUERDO: Estatísticas e Barras Modernas -->
                    <div class="col-lg-6 col-md-6 col-sm-12 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.1s">
                        <div class="estatisticas-premium-conteudo">
                            <!-- Tag decorativa de dados -->
                            <span class="badge-dados">Dados Nacionais</span>
                            
                            <h2>Perfil da população privada de liberdade no Brasil</h2>
                            <p>De acordo com o levantamento do Sisdepen de 2024, a população carcerária é composta majoritariamente por homens jovens, com baixa escolaridade e de cor preta ou parda.</p>
                        </div>

                        <!-- Painel das Barras Modernas -->
                        <div class="painel-barras-premium">
                            
                            <!-- Barra 1 -->
                            <div class="item-barra-premium">
                                <div class="info-barra-premium">
                                    <span class="label-barra">Homens</span>
                                    <span class="porcentagem-barra p-amarela">94%</span>
                                </div>
                                <div class="track-barra-premium">
                                    <div class="fill-barra-premium bg-amarelo" data-percent="94" style="width: 94%;"></div>
                                </div>
                            </div>

                            <!-- Barra 2 -->
                            <div class="item-barra-premium">
                                <div class="info-barra-premium">
                                    <span class="label-barra">Pessoas negras e com baixa escolaridade</span>
                                    <span class="porcentagem-barra p-laranja">69%</span>
                                </div>
                                <div class="track-barra-premium">
                                    <div class="fill-barra-premium bg-laranja" data-percent="69" style="width: 69%;"></div>
                                </div>
                            </div>

                            <!-- Barra 3 -->
                            <div class="item-barra-premium">
                                <div class="info-barra-premium">
                                    <span class="label-barra">Jovens até 34 anos</span>
                                    <span class="porcentagem-barra p-azul">60%</span>
                                </div>
                                <div class="track-barra-premium">
                                    <div class="fill-barra-premium bg-azul" data-percent="60" style="width: 60%;"></div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- LADO DIREITO: Logo com efeito de Luz de Fundo (Spotlight) -->
                    <div class="col-lg-6 col-md-6 col-sm-12 text-center wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.2s">
                        <div class="logo-spotlight-wrapper">
                            <img src="assets/img/Logo 3R .png" alt="Logo 3R" class="img-fluid logo-premium-img">
                        </div>
                    </div>

                </div>
            </div>
        </section>
        
      <!-- SEÇÃO FALE CONOSCO -->
        <section class="contact_area">
            <div class="container">
                <div class="contact-premium-wrapper wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                    <div class="row g-0"> <!-- g-0 impede espaçamentos vazios entre os dois lados -->
                        
                        <!-- LADO ESQUERDO: Bloco Informativo em Preto Grafite Matte -->
                        <div class="col-lg-5 col-md-12 painel-info-contato">
                            <div class="info-contato-content">
                                <span class="tag-contato">Fale Conosco</span>
                                <h2 class="titulo-contato">Sua opinião faz a diferença!</h2>
                                <p class="texto-contato">
                                    Se você encontrou algum problema na plataforma, identificou uma informação desatualizada, um link que não está funcionando ou tem alguma sugestão de melhoria, entre em contato conosco.
                                </p>
                                <div class="linha-decorativa-contato"></div>
                                <p class="subtexto-contato">
                                    Estamos trabalhando constantemente para tornar o 3R mais acessível, útil e acolhedor para todos.
                                </p>
                            </div>
                        </div>
                        
                        <!-- LADO DIREITO: O Formulário Elegante -->
                        <div class="col-lg-7 col-md-12 painel-form-contato">
                            <form action="php/contact.php" method="post" class="form-custom-3r">
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="label-custom">Seu Nome</label>
                                        <input type="text" name="name" class="form-control-custom" placeholder="Ex: João Silva" required>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="label-custom">E-mail Corporativo ou Pessoal</label>
                                        <input type="email" name="email" class="form-control-custom" placeholder="Ex: joao@email.com" required>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label class="label-custom">Assunto</label>
                                        <input type="text" name="subject" class="form-control-custom" placeholder="Sobre o que você quer falar?" required>
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label class="label-custom">Mensagem ou Sugestão</label>
                                        <textarea name="message" class="form-control-custom" rows="4" placeholder="Digite aqui os detalhes..." required></textarea>
                                    </div>
                                    <div class="col-md-12 text-end">
                                        <button type="submit" name='submit' class="btn-custom-3r">Enviar Mensagem</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        
        <?php include 'footer.php';?>

        <!-- Latest jQuery -->
        <script src="assets/js/jquery-1.12.4.min.js"></script>
        <!-- Latest compiled and minified Bootstrap -->
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- modernizer JS -->      
        <script src="assets/js/modernizr-2.8.3.min.js"></script>                                                                                
        <!-- owl-carousel min js  -->
        <script src="assets/owlcarousel/js/owl.carousel.min.js"></script>                   
        <!-- magnific-popup js -->               
        <script src="assets/js/jquery.magnific-popup.min.js"></script>          
        <!-- jquery mixitup js -->   
        <script src="assets/js/jquery.mixitup.js"></script>         
        <!-- jquery appear js -->
        <script src="assets/js/jquery.appear.js"></script>                          
        <!-- countTo js -->
        <script src="assets/js/jquery.inview.min.js"></script>
        <!-- jquery touchSwipe min JS -->
        <script src="assets/js/jquery.touchSwipe.min.js"></script>                  
        <!-- stellar js -->
        <script src="assets/js/jquery.stellar.min.js"></script>         
        <!-- WOW - Reveal Animations When You Scroll -->
        <script src="assets/js/wow.min.js"></script>    
        <!-- form contact js -->                                                                                        
        <script src="assets/js/form-contact.js"></script>               
        <!-- scrolltopcontrol js -->
        <script src="assets/js/menu.js"></script>                                                                                               
        <script src="assets/js/jquery.sticky.js"></script>                                                                                                      
        <script src="assets/js/scrolltopcontrol.js"></script>                                                                                                   
        <!-- scripts js -->
        <script src="assets/js/scripts.js"></script>        
    </body>
</html>