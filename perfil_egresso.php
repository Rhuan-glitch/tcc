<!DOCTYPE html>
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
    </body>
</html>