<!DOCTYPE html>
<html lang="en">

	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="Monoline - Design Agency HTML Template">
		<meta name="keywords" content="agency, business, corporate, creative, html5, modern, multipurpose, One Page, parallax, startup ">		
		<!-- SITE TITLE -->
		<title>Tela de Login - Plataforma 3R</title>			
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
		<link rel="stylesheet" href="assets/css/login.css">			
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	
    <body data-spy="scroll" data-offset="80">
   
		<!-- START NAVBAR -->
		<?php include 'nav-bar.php' ?>
	   <!-- END NAVBAR-->		

		<!-- START PRELOADER -->
		<div class="preloader">
			<div class="spinner">
				<div class="double-bounce1"></div>
				<div class="double-bounce2"></div>
			</div>
		</div>
		<!-- END PRELOADER -->		

				
		
	<!-- Seção de Login - Reutilizando as classes do Cadastro -->
<section class="secao-cadastro-3r">
    <div class="container-cadastro">
        <div class="header-form">
            <img src="assets/img/Logo 3R (5).png" alt="Logo Plataforma 3R" class="logo-cadastro">
            <span class="subtitulo">Bem-vindo de volta</span>
            <h2>Acesse sua conta</h2>
            <p>Continue sua jornada de recomeço e reconstrução com a Família 3R.</p>
        </div>

        <form action="php/validar_login.php" method="POST">
            <!-- Campo de E-mail -->
            <div class="form-group">
                <label>Usuário ou E-mail</label>
                <input type="text" id="inputLogin" name="email"placeholder="Usuário ou e-mail" required>
            </div>

            <!-- Campo de Senha -->
            <div class="form-group">
                <label>Senha</label>
                <div class="password-container">
                    <input type="password" id="inputSenhaLogin" name="senha" placeholder="Digite sua senha" required>
                    <span class="toggle-password" onclick="mostrarSenha('inputSenhaLogin', this)">Mostrar</span>
                </div>
                
                <!-- Link de Esqueci a Senha -->
                <div style="text-align: right; margin-top: 8px;">
                    <a href="esqueciasenha.php" style="font-size: 13px; color: #F76B1C; text-decoration: none; font-weight: 600;">Esqueceu a senha?</a>
                </div>
            </div>

            <!-- Botão Entrar -->
            <button type="submit" class="btn-submit">Entrar</button>

            <!-- Rodapé do Formulário (Ir para Cadastro) -->
            <div class="footer-form">
                Não possui uma conta? <a href="cadastro.php">Cadastre-se</a>
            </div>
        </form>
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
		<!-- stellar js -->
			<script src="assets/js/jquery.stellar.min.js"></script>			
		<!-- WOW - Reveal Animations When You Scroll -->
			<script src="assets/js/wow.min.js"></script>	
		<!-- Menu js -->
			<script src="assets/js/menu.js"></script>																				
			<script src="assets/js/jquery.sticky.js"></script>			
		<!-- scrolltopcontrol js -->																				
			<script src="assets/js/scrolltopcontrol.js"></script>																				
		<!-- scripts js -->
			<script src="assets/js/scripts.js"></script>		
			<script src="assets/js/login.js"></script>	
    </body>
</html>