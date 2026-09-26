<!DOCTYPE html>
<<<<<<< HEAD:perfil_egresso.php
<html lang="pt-BR">
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

// Busca a quantidade de cursos concluídos pelo egresso
$stmtCursos = $conn->prepare("
    SELECT COUNT(*) AS total_cursos
    FROM egresso_curso
    WHERE cpf_egresso = ?
    AND status_curso = 'Concluído'
");

$stmtCursos->bind_param("s", $cpf);
$stmtCursos->execute();

$resultadoCursos = $stmtCursos->get_result();
$totalCursosConcluidos = $resultadoCursos->fetch_assoc()['total_cursos'];
// Essa parte busca os cursos recomendados para a área de interesse do egresso
$stmtTrilha = $conn->prepare("
    SELECT 
        c.id_curso,
        c.nome_curso,
        c.carga_horaria,
        ec.status_curso
    FROM curso c
    LEFT JOIN egresso_curso ec
        ON c.id_curso = ec.id_curso
        AND ec.cpf_egresso = ?
    WHERE c.area = ?
    ORDER BY c.nome_curso
");

$stmtTrilha->bind_param("ss", $cpf, $egresso['area_interesse']);
$stmtTrilha->execute();

$resultadoTrilha = $stmtTrilha->get_result();

$cursosTrilha = [];

while ($curso = $resultadoTrilha->fetch_assoc()) {
    $cursosTrilha[] = $curso;
}


// Aqui faz o cálculo do progresso da trilha
$totalCursosTrilha = count($cursosTrilha);
$cursosTrilhaConcluidos = 0;

foreach ($cursosTrilha as $curso) {
    if ($curso['status_curso'] === 'Concluído') {
        $cursosTrilhaConcluidos++;
    }
}

if ($totalCursosTrilha > 0) {
    $progressoTrilha = round(($cursosTrilhaConcluidos / $totalCursosTrilha) * 100);
} else {
    $progressoTrilha = 0;
}
$stmtCurriculo = $conn->prepare("
    SELECT data_atualizacao
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
        "data_atualizacao" => null
    ];
}
?>
	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="Monoline - Design Agency HTML Template">
		<meta name="keywords" content="agency, business, corporate, creative, html5, modern, multipurpose, One Page, parallax, startup ">		
		<!-- SITE TITLE -->
		<title>Meu Perfil - Plataforma 3R </title>			
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
        <link rel="stylesheet" href="assets/css/perfil_egresso.css">		
        	

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	
    <body data-spy="scroll" data-offset="80">
			<?php include 'nav-bar.php'; ?>
		<!-- START PRELOADER -->
		<div class="preloader">
			<div class="spinner">
				<div class="double-bounce1"></div>
				<div class="double-bounce2"></div>
			</div>
		</div>
		<!-- END PRELOADER -->		
<section class="section-top perfil-banner" style="background-image:url(assets/img/bg/section-top.png);background-size:cover;background-position:center;">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center"></div>
		</div>
	</div>
</section>

<section class="perfil-egresso section-padding">
	<div class="container">

		<div class="section-title text-center">
			<h2>Meu Perfil</h2>
			<p>Mantenha suas informações atualizadas para aumentar suas oportunidades de trabalho e acompanhar sua evolução na Plataforma 3R.</p>
		</div>

		<div class="perfil-header">

			<div class="perfil-foto">
				<?php if (!empty($egresso['foto_perfil'])): ?>
        			<img src="<?= htmlspecialchars($egresso['foto_perfil']) ?>" alt="Foto de <?= htmlspecialchars($egresso['nome']) ?>">
    			<?php else: ?>
        			<img src="assets/img/team/team-one.jpg" alt="Foto do Usuário"><?php endif; ?>
			</div>

			<div class="perfil-info">
				<h2><?= htmlspecialchars($egresso['nome']) ?></h2>
				<span class="perfil-tipo">Egresso da Plataforma 3R</span>

				<p>Cada passo no aprendizado aproxima você de novas oportunidades.</p>

				<a href="editar_perfil_egresso.php" class="btn-editar-perfil">
    				<i class="fa fa-pencil"></i> Editar Perfil
				</a>
			</div>

			<div class="perfil-resumo">

				<div class="resumo-card">
					<h3><?= $totalCursosConcluidos ?></h3>
					<span>Cursos Concluídos</span>
				</div>

				<div class="resumo-card">
					<h3><?= $totalCandidaturas ?></h3>
					<span>Candidaturas</span>
				</div>

				<div class="resumo-card">
					<h3><?= htmlspecialchars($egresso['area_interesse']) ?></h3>
					<span>Área de Interesse</span>
				</div>

			</div>

		</div>

		<div class="row mt-5">

			<div class="col-lg-6">

				<div class="perfil-card">

					<h3>Dados Pessoais</h3>

					<div class="perfil-item">
						<strong>Nome</strong>
						<span><?= htmlspecialchars($egresso['nome']) ?></span>
					</div>

					<div class="perfil-item">
						<strong>CPF</strong>
						<span><?= htmlspecialchars($egresso['cpf']) ?></span>
					</div>

					<div class="perfil-item">
						<strong>E-mail</strong>
						<span><?= htmlspecialchars($egresso['email']) ?></span>
					</div>

					<div class="perfil-item">
						<strong>Telefone</strong>
						<span><?= htmlspecialchars($egresso['telefone']) ?></span>
					</div>

					<div class="perfil-item">
						<strong>Data de Nascimento</strong>
						<span> <?= date('d/m/Y', strtotime($egresso['data_nascimento'])) ?></span>
					</div>

					<div class="perfil-item">
						<strong>Cidade</strong>
						<span><?= htmlspecialchars($egresso['cidade']) ?></span>
					</div>

					<!-- <div class="perfil-item">
						<strong>Escolaridade</strong>
						<span>Ensino Médio Completo</span>
					</div> -->

					<!-- <button class="btn-atualizar mt-4">
						Atualizar Informações
					</button> -->

				</div>

			</div>

			<div class="col-lg-6">

				<div class="perfil-card">

					<h3>Área de Interesse</h3>

					<p>Selecione a área profissional que mais combina com seus objetivos. A plataforma recomendará cursos relacionados, mas você poderá realizar qualquer curso disponível.</p>

					<div class="row mt-4">

						<div class="col-md-6">
							<div class="interesse-card <?= $egresso['area_interesse'] === 'Tecnologia' ? 'active' : '' ?>">
								<i class="fa fa-desktop"></i>
								<h5>Tecnologia</h5>
							</div>
						</div>
						<div class="col-md-6">
							<div class="interesse-card <?= $egresso['area_interesse'] === 'Idiomas' ? 'active' : '' ?>">
								<i class="fa fa-desktop"></i>
								<h5>Idiomas</h5>
							</div>
						</div>
						<div class="col-md-6">
							<div class="interesse-card <?= $egresso['area_interesse'] === 'Administrativo' ? 'active' : '' ?>">
								<i class="fa fa-briefcase"></i>
								<h5>Administrativo</h5>
							</div>
						</div>

						<div class="col-md-6">
							<div class="interesse-card <?= $egresso['area_interesse'] === 'Logística' ? 'active' : '' ?>">
								<i class="fa fa-truck"></i>
								<h5>Logística</h5>
							</div>
						</div>

						<div class="col-md-6">
							<div class="interesse-card <?= $egresso['area_interesse'] === 'Comercial' ? 'active' : '' ?>">
								<i class="fa fa-shopping-cart"></i>
								<h5>Comercial</h5>
							</div>
						</div>
						<div class="col-md-6">
							<div class="interesse-card <?= $egresso['area_interesse'] === 'Negócios' ? 'active' : '' ?>">
								<i class="fa fa-desktop"></i>
								<h5>Negócios</h5>
							</div>
						</div>
						<div class="col-md-6">
							<div class="interesse-card <?= $egresso['area_interesse'] === 'Atendimento' ? 'active' : '' ?>">
								<i class="fa fa-users"></i>
								<h5>Atendimento</h5>
							</div>
						</div>
						<div class="col-md-6">
							<div class="interesse-card <?= $egresso['area_interesse'] === 'Desenvolvimento Pessoal' ? 'active' : '' ?>">
								<i class="fa fa-desktop"></i>
								<h5>Desenvolvimento Pessoal</h5>
							</div>
						</div>
						<div class="col-md-6">
							<div class="interesse-card <?= $egresso['area_interesse'] === 'Operacional' ? 'active' : '' ?>">
								<i class="fa fa-cogs"></i>
								<h5>Operacional</h5>
							</div>
						</div>

					</div>

					<!-- <button class="btn-atualizar mt-4">
						Salvar Área de Interesse
					</button> -->

				</div>

			</div>

		</div>

	</div>
</section>
		<div class="perfil-card mt-5">

			<div class="d-flex justify-content-between align-items-center mb-3">
				<h3>Trilha de Aprendizagem</h3>
				<span class="progresso-texto"><?= $progressoTrilha ?>% Concluído</span>
			</div>

			<p>
				Com base na sua área de interesse, recomendamos alguns cursos para fortalecer seu currículo. Essa trilha é apenas uma sugestão e você pode realizar qualquer curso disponível na plataforma.
			</p>

			<div class="barra-progresso">
				<div class="barra-preenchida" style="width:<?= $progressoTrilha ?>%;"></div>
			</div>

			<div class="row mt-5">

				<?php if (count($cursosTrilha) > 0): ?>

        <?php foreach ($cursosTrilha as $curso): ?>

            <?php if ($curso['status_curso'] === 'Concluído'): ?>

                <div class="col-lg-6 mb-4">
                    <div class="curso-card concluido">

                        <div class="curso-icon">
                            <i class="fa fa-check-circle"></i>
                        </div>

                        <div class="curso-info">

                            <h5>
                                <?= htmlspecialchars($curso['nome_curso']) ?>
                            </h5>

                            <span>
                                <?= htmlspecialchars($curso['carga_horaria']) ?> Horas • Concluído
                            </span>

                        </div>

                    </div>
                </div>

            <?php elseif ($curso['status_curso'] === 'Em Andamento'): ?>

                <div class="col-lg-6 mb-4">
                    <div class="curso-card">

                        <div class="curso-icon">
                            <i class="fa fa-clock-o"></i>
                        </div>

                        <div class="curso-info">

                            <h5>
                                <?= htmlspecialchars($curso['nome_curso']) ?>
                            </h5>

                            <span>
                                <?= htmlspecialchars($curso['carga_horaria']) ?> Horas • Em Andamento
                            </span>

                        </div>

                    </div>
                </div>

            <?php else: ?>

                <div class="col-lg-6 mb-4">
                    <div class="curso-card">

                        <div class="curso-icon">
                            <i class="fa fa-circle-o"></i>
                        </div>

                        <div class="curso-info">

                            <h5>
                                <?= htmlspecialchars($curso['nome_curso']) ?>
                            </h5>

                            <span>
                                <?= htmlspecialchars($curso['carga_horaria']) ?> Horas • Recomendado
                            </span>

                        </div>

                    </div>
                </div>

            <?php endif; ?>

        <?php endforeach; ?>

    <?php else: ?>

        <div class="col-lg-12">

            <p>
                Ainda não há cursos disponíveis para sua área de interesse.
            </p>

        </div>

    <?php endif; ?>


			</div>

		</div>

		<div class="row mt-5">

			<div class="col-lg-12">

				<div class="perfil-card">

					<div class="d-flex justify-content-between align-items-center">
						<h3>Meu Currículo</h3>

						<a href="editar_curriculo.php" class="btn-editar-perfil">
    						<i class="fa fa-pencil"></i> Editar Currículo
						</a>
					</div>

					<p class="mt-3">
						Mantenha seu currículo sempre atualizado para facilitar sua candidatura às vagas disponíveis na Plataforma 3R.
					</p>

					<div class="curriculo-box mt-4">

						<div class="curriculo-info">
							<h4>Currículo Profissional</h4>
							<span> Última atualização:
								<?php
    							if ($curriculo['data_atualizacao']) {
        							echo date("d/m/Y H:i", strtotime($curriculo['data_atualizacao']));
    							} else {
        							echo "Ainda não atualizado";
    							}
    							?>
							</span>
						</div>

						<div class="curriculo-acoes">

							<a href="visualizar_curriculo.php" class="btn-curriculo">
								<i class="fa fa-file-pdf-o"></i> Salvar como PDF
							</a>

							<!-- <button class="btn-curriculo">
								<i class="fa fa-google"></i> Abrir Modelo no Google Drive
							</button> -->

						</div>

					</div>

				</div>

			</div>

		</div>
        		<div class="row mt-5">

			<div class="col-lg-8">

				<div class="perfil-card">

					<h3>Minhas Candidaturas</h3>

					<p>Acompanhe o andamento das vagas para as quais você se candidatou.</p>

					<?php if (count($candidaturas) > 0): ?>
					<?php foreach ($candidaturas as $candidatura): ?>
        			<div class="candidatura-item">
            		<div class="candidatura-info">
                	<h4><?= htmlspecialchars($candidatura['titulo_vaga']) ?></h4>
                	<span>Empresa:<?= htmlspecialchars($candidatura['razao_social']) ?></span><br>
                	<span>Data da candidatura:<?= date('d/m/Y', strtotime($candidatura['data_candidatura'])) ?></span></div>
            		<div class="candidatura-status"><?= htmlspecialchars($candidatura['status_candidatura']) ?></div>
        			</div>
        			<hr>
    				<?php endforeach; ?>
					<?php else: ?>
					<p>Você ainda não se candidatou a nenhuma vaga.</p>
					<?php endif; ?>

				</div>

			</div>
   <div class="col-lg-4">

	<div class="perfil-card">

		<h3>Meu Desempenho</h3>

		<div class="desempenho-item">
			<i class="fa fa-graduation-cap"></i>
			<div>
				<h4><?= $totalCursosConcluidos ?> Curso<?= $totalCursosConcluidos != 1 ? 's' : '' ?> Concluído<?= $totalCursosConcluidos != 1 ? 's' : '' ?> </h4>
				<span>Continue aprendendo para ampliar suas oportunidades.</span>
			</div>
		</div>

		<hr>

		<div class="desempenho-item">
			<i class="fa fa-briefcase"></i>
			<div>
				<h4><?= $totalCandidaturas ?> Candidatura<?= $totalCandidaturas != 1 ? 's' : '' ?> Enviada<?= $totalCandidaturas != 1 ? 's' : '' ?></h4>
				<span>Acompanhe o andamento das suas oportunidades.</span>
			</div>
		</div>

		<hr>

		<div class="desempenho-item">
			<i class="fa fa-certificate"></i>
			<div>
				<h4> <?= $totalCursosConcluidos ?> Certificado<?= $totalCursosConcluidos != 1 ? 's' : '' ?></h4>
				<span>Disponíveis para download na área de cursos.</span>
			</div>
		</div>

		<hr>

		<div class="desempenho-item">
			<i class="fa fa-line-chart"></i>
			<div>
				<h4><?= $progressoTrilha ?>% da Trilha Concluída</h4>
				<span>Continue estudando para completar sua trilha recomendada.</span>
			</div>
		</div>

	</div>

</div>

<!-- START FOOTER -->
		<div class="footer" background-size:cover;">
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
					</div><!--- END COL -->						
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
					</div><!--- END COL -->	
					<div class="col-lg-3 col-sm-6 col-xs-1">
						<div class="single_footer">
							<h4>Company</h4>
							<ul>
								<li><a href="#">Licenses</a></li>
								<li><a href="#">market API</a></li>
								<li><a href="#">Careers and job</a></li>
								<li><a href="#">Emplois en France</a></li>
								<li><a href="#">Jobs in Deutschland	</a></li>						
							</ul>
						</div>
					</div><!--- END COL -->	
				</div><!--- END ROW -->		
				<div class="row">
					<div class="col-lg-12 text-center">
						<div class="footer_copyright">
							<p>&copy; 2026 Plataforma 3R - Recomeçar, Reconstruir e Renascer. <br>Todos os direitos reservados.</p>
						</div>
					</div>
				</div>				
			</div><!--- END CONTAINER -->
		</div>
		<!-- END FOOTER -->	

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
            <script src="assets/js/perfil_egresso.js"></script>		
=======
<html lang="pt-br">

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
                    <li class="nav-link"><a href="index.html" class="nav-link">Home</a></li>    
                    <li><a class="nav-link" href="trabalhista.html">Trabalhista</a></li>                 
                     <li><a class="nav-link" href="formacao.html">Formação</a></li>                                 
                        <li><a href="login.html" class="nav-link">Login</a></li>
                    </li>   
                  </ul>
                </nav>
              </div>
               <div class="col-6 d-inline-block d-xl-none ml-md-0 py-3" style="position: relative; top: 3px;">
               <a href="#" class="site-menu-toggle js-menu-toggle float-right"><span class="icon-menu h3"></span></a>
               </div>
            </div>
          </div>
        </header>
        <!-- END NAVBAR-->       
	
     
     <!-- SEÇÃO PRINCIPAL DO PERFIL -->
        <main class="perfil-main-wrapper">
          <div class="container">
            
            <!-- CABEÇALHO DO USUÁRIO -->
            <section class="perfil-hero-card">
              <div class="hero-avatar-wrapper">
                <img id="avatar-preview-main" src="assets/img/team/team-one.jpg" alt="Foto de Perfil" class="hero-avatar-img">
              </div>
              <div class="hero-info">
                <span class="badge-boas-vindas">Bem-vindo!</span>
                <h1 class="hero-nome" id="display-nome">Rhuan Felipe</h1>
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
                      <a href="https://docs.google.com/" target="_blank" rel="noopener" class="btn-3r-dark">
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
                      <span class="stat-value highlight" id="stat-cursos-concluidos">1</span>
                    </li>
                    <li class="stat-item">
                      <span class="stat-label">Em Andamento</span>
                      <span class="stat-value" id="stat-cursos-andamento">1</span>
                    </li>
                    <li class="stat-item">
                      <span class="stat-label">Vagas Candidatadas</span>
                      <span class="stat-value" id="stat-vagas-candidatadas">2</span>
                    </li>
                  </ul>
                </aside>

                <!-- CARD: OPORTUNIDADES -->
                <aside class="card-3r card-vagas">
                  <h3 class="side-title"><i class="fa fa-briefcase"></i> Oportunidades</h3>
                  <div class="vagas-wrapper" id="lista-candidaturas">
                    <div class="vaga-card">
                      <h4 class="vaga-titulo">Auxiliar Administrativo</h4>
                      <p class="vaga-empresa">Tech Solutions Ltda</p>
                      <span class="status-pill status-espera"><i class="fa fa-clock-o"></i> Em Análise</span>
                    </div>
                    <div class="vaga-card">
                      <h4 class="vaga-titulo">Atendente de Loja</h4>
                      <p class="vaga-empresa">Varejo Mais</p>
                      <span class="status-pill status-entrevista"><i class="fa fa-check-circle"></i> Entrevista Agendada</span>
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
              <form id="formEditarPerfil">
                <div class="modal-body">
                  <div class="foto-seletor-container mb-4">
                    <label class="d-block font-weight-bold mb-2">Foto de Perfil</label>
                    <div class="d-flex align-items-center gap-3">
                      <img id="modal-foto-preview" src="assets/img/team/team-one.jpg" alt="Preview Foto" class="seletor-preview-img">
                      <div class="flex-grow-1 ml-3">
                        <input type="file" id="input-foto-arquivo" accept="image/png, image/jpeg, image/webp" class="d-none">
                        <button type="button" class="btn-3r-outline mb-2" onclick="document.getElementById('input-foto-arquivo').click();">
                          <i class="fa fa-upload"></i> Escolher foto
                        </button>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label>Nome Completo</label>
                      <input type="text" class="custom-input" id="input-nome" name="nome" value="Rhuan Felipe" required>
                    </div>
                    <div class="col-md-6 form-group">
                      <label>CPF (Inalterável)</label>
                      <input type="text" class="custom-input disabled" name="cpf" value="000.000.000-00" readonly disabled>
                    </div>
                    <div class="col-md-6 form-group">
                      <label>Data de Nascimento</label>
                      <input type="date" class="custom-input" name="data_nascimento" value="2000-01-01" required>
                    </div>
                    <div class="col-md-6 form-group">
                      <label>E-mail</label>
                      <input type="email" class="custom-input" name="email" value="rhuan@email.com" required>
                    </div>
                    <div class="col-md-6 form-group">
                      <label>Telefone</label>
                      <input type="tel" class="custom-input" name="telefone" placeholder="(00) 00000-0000">
                    </div>
                    <div class="col-md-6 form-group">
                      <label>Cidade</label>
                      <input type="text" class="custom-input" name="cidade" placeholder="Sua cidade">
                    </div>
                    <div class="col-md-12 form-group">
                      <label>Área de Interesse</label>
                      <select class="custom-input" id="select-area-interesse" name="area_interesse">
                        <option value="Tecnologia" selected>Tecnologia / Informática</option>
                        <option value="Administração">Administração / Escritório</option>
                        <option value="Vendas">Vendas / Atendimento</option>
                        <option value="Serviços Gerais">Serviços Gerais</option>
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
              <form id="formCurriculo">
                <div class="modal-body">
                  <p class="small text-muted mb-3">Clique nas opções abaixo para montar seu perfil profissional sem precisar digitar textos longos:</p>
                  
                  <!-- 1. ESCOLARIDADE -->
                  <div class="form-group mb-4">
                    <label class="font-weight-bold d-block mb-1">1. Sua Escolaridade:</label>
                    <div class="tag-selector-grid">
                      <input type="radio" name="escolaridade" id="esc-1" value="Ensino Médio Incompleto" class="tag-checkbox">
                      <label for="esc-1" class="tag-label"><i class="fa fa-graduation-cap"></i> Ensino Médio Incompleto</label>

                      <input type="radio" name="escolaridade" id="esc-2" value="Ensino Médio Completo" class="tag-checkbox" checked>
                      <label for="esc-2" class="tag-label"><i class="fa fa-graduation-cap"></i> Ensino Médio Completo</label>

                      <input type="radio" name="escolaridade" id="esc-3" value="Curso Técnico" class="tag-checkbox">
                      <label for="esc-3" class="tag-label"><i class="fa fa-graduation-cap"></i> Curso Técnico</label>

                      <input type="radio" name="escolaridade" id="esc-4" value="Ensino Superior" class="tag-checkbox">
                      <label for="esc-4" class="tag-label"><i class="fa fa-graduation-cap"></i> Ensino Superior</label>
                    </div>
                  </div>

                  <!-- 2. EXPERIÊNCIA PREVIA -->
                  <div class="form-group mb-4">
                    <label class="font-weight-bold d-block mb-1">2. Áreas de Experiência (Marque as que já trabalhou):</label>
                    <div class="tag-selector-grid">
                      <input type="checkbox" id="exp-1" value="Em busca do Primeiro Emprego" class="tag-checkbox">
                      <label for="exp-1" class="tag-label"><i class="fa fa-star"></i> Primeiro Emprego</label>

                      <input type="checkbox" id="exp-2" value="Atendimento / Recepção" class="tag-checkbox">
                      <label for="exp-2" class="tag-label"><i class="fa fa-comments"></i> Atendimento / Recepção</label>

                      <input type="checkbox" id="exp-3" value="Vendas / Comércio" class="tag-checkbox">
                      <label for="exp-3" class="tag-label"><i class="fa fa-shopping-cart"></i> Vendas / Comércio</label>

                      <input type="checkbox" id="exp-4" value="Apoio Administrativo" class="tag-checkbox">
                      <label for="exp-4" class="tag-label"><i class="fa fa-folder"></i> Apoio Administrativo</label>

                      <input type="checkbox" id="exp-5" value="Serviços Gerais / Limpeza" class="tag-checkbox">
                      <label for="exp-5" class="tag-label"><i class="fa fa-wrench"></i> Serviços Gerais</label>

                      <input type="checkbox" id="exp-6" value="Estoque / Logística" class="tag-checkbox">
                      <label for="exp-6" class="tag-label"><i class="fa fa-archive"></i> Estoque / Logística</label>
                    </div>
                  </div>

                  <!-- 3. PRINCIPAIS HABILIDADES -->
                  <div class="form-group mb-4">
                    <label class="font-weight-bold d-block mb-1">3. Seus Pontos Fortes e Habilidades:</label>
                    <div class="tag-selector-grid">
                      <input type="checkbox" id="hab-1" value="Pontual e Responsável" class="tag-checkbox">
                      <label for="hab-1" class="tag-label"><i class="fa fa-clock-o"></i> Pontualidade</label>

                      <input type="checkbox" id="hab-2" value="Boa Comunicação" class="tag-checkbox">
                      <label for="hab-2" class="tag-label"><i class="fa fa-bullhorn"></i> Boa Comunicação</label>

                      <input type="checkbox" id="hab-3" value="Informática Básica" class="tag-checkbox">
                      <label for="hab-3" class="tag-label"><i class="fa fa-laptop"></i> Informática Básica</label>

                      <input type="checkbox" id="hab-4" value="Trabalho em Equipe" class="tag-checkbox">
                      <label for="hab-4" class="tag-label"><i class="fa fa-users"></i> Trabalho em Equipe</label>

                      <input type="checkbox" id="hab-5" value="Facilidade para Aprender" class="tag-checkbox">
                      <label for="hab-5" class="tag-label"><i class="fa fa-lightbulb-o"></i> Facilidade p/ Aprender</label>
                    </div>
                  </div>

                  <!-- 4. DISPONIBILIDADE -->
                  <div class="form-group mb-2">
                    <label class="font-weight-bold d-block mb-1">4. Disponibilidade para Trabalhar:</label>
                    <div class="tag-selector-grid">
                      <input type="checkbox" id="disp-1" value="Manhã" class="tag-checkbox">
                      <label for="disp-1" class="tag-label"><i class="fa fa-sun-o"></i> Turno Manhã</label>

                      <input type="checkbox" id="disp-2" value="Tarde" class="tag-checkbox">
                      <label for="disp-2" class="tag-label"><i class="fa fa-sun-o"></i> Turno Tarde</label>

                      <input type="checkbox" id="disp-3" value="Noite" class="tag-checkbox">
                      <label for="disp-3" class="tag-label"><i class="fa fa-moon-o"></i> Turno Noite</label>

                      <input type="checkbox" id="disp-4" value="Integral" class="tag-checkbox">
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
                  <span>Área Escolhida: <strong id="trilha-area-nome">Tecnologia / Informática</strong></span>
                </div>

                <div id="casa-detalhe-card" class="casa-detalhe-box mb-3 d-none">
                  <h6 id="casa-detalhe-titulo" class="font-weight-bold mb-1">Nome do Curso</h6>
                  <p id="casa-detalhe-desc" class="small text-muted mb-2">Descrição do módulo...</p>
                  <a id="btn-acao-casa" href="formacao.html" class="btn-3r-primary btn-sm">Acessar Curso</a>
                </div>

                <div class="tabuleiro-container">
                  <svg class="tabuleiro-path" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M 15 20 Q 50 20 50 40 T 85 60 Q 50 60 50 80 T 15 90" fill="transparent" stroke="#E2E8F0" stroke-width="3" stroke-dasharray="4" />
                  </svg>

                  <div class="casa-node node-done" style="top: 15%; left: 12%;" data-titulo="Informática Básica" data-desc="Módulo de introdução a computadores e navegação na web. Concluído!" data-status="concluido">
                    <div class="node-icon"><i class="fa fa-check"></i></div>
                    <span class="node-title">Informática Básica</span>
                  </div>

                  <div class="casa-node node-current" style="top: 55%; left: 80%;" data-titulo="Excel Fundamental" data-desc="Aprenda planilhas, fórmulas básicas e organização de dados." data-status="atual">
                    <div class="node-icon">
                      <i id="pino-jogador-trilha" class="fa fa-street-view pino-icon"></i>
                    </div>
                    <span class="node-title">Excel Fundamental</span>
                  </div>

                  <div class="casa-node node-locked" style="top: 85%; left: 12%;" data-titulo="Comunicação Assertiva" data-desc="Conclua os módulos anteriores para destravar este curso." data-status="bloqueado">
                    <div class="node-icon"><i class="fa fa-lock"></i></div>
                    <span class="node-title">Comunicação Assertiva</span>
                  </div>
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
>>>>>>> 3536684d31fd2a2409247dab0ad4d6b203144128:perfil_egresso.html
    </body>
</html>