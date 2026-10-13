<?php
require_once __DIR__ . "/php/config/config.php";
?> 
<!DOCTYPE html>
<html lang="pt-br">

	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="Monoline - Design Agency HTML Template">
		<meta name="keywords" content="agency, business, corporate, creative, html5, modern, multipurpose, One Page, parallax, startup ">		
		<!-- SITE TITLE -->
		<title>Esqueci a senha - Plataforma 3R</title>			
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

		<!-- START PRELOADER -->
		<div class="preloader">
			<div class="spinner">
				<div class="double-bounce1"></div>
				<div class="double-bounce2"></div>
			</div>
		</div>
		<!-- END PRELOADER -->		

		<!-- START NAVBAR -->
		<?php include 'nav-bar.php' ?>
	   <!-- END NAVBAR-->					
		
	<section class="secao-cadastro-3r">
    <div class="container-cadastro">
        
        <!-- ==========================================
             TELA 1: FORMULÁRIO DE RECUPERAÇÃO
        =========================================== -->
        <div id="telaRecuperacao">
            <div class="header-form">
                <img src="assets/img/Logo 3R (5).png" alt="Logo Plataforma 3R" class="logo-cadastro">
                <h2>Redefinir Senha</h2>
                <p>Digite seu e-mail para receber as instruções de redefinição.</p>
            </div>

            <form action="php/recuperar_senha.php" method="POST">
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" id="inputEmailRecuperacao" placeholder="seu@email.com" required>
                </div>

                <button type="submit" class="btn-submit">Enviar Instruções</button>

                <div class="footer-form">
                    Lembrou a senha? <a href="login.php">Voltar para o login</a>
                </div>
            </form>
        </div>

        <!-- ==========================================
             TELA 2: MENSAGEM DE SUCESSO (Oculta por padrão)
        =========================================== -->
        <div id="telaSucesso" style="display: none; text-align: center; padding: 20px 0;">
            <!-- Ícone de Check Verde (SVG igual ao do protótipo) -->
            <svg width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="#00b341" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 20px;">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>

            <h2 style="color: #222; font-size: 28px; font-weight: 700; margin-bottom: 20px;">E-mail Enviado!</h2>
            
            <p style="color: #444; font-size: 16px; line-height: 1.6; margin-bottom: 30px;">
                Enviamos instruções para redefinir sua senha para o e-mail:<br>
                <strong id="emailConfirmadoTexto" style="color: #1A1A1A; font-size: 15px;"></strong>
            </p>

            <p style="color: #666; font-size: 14px;">
                Redirecionando para o login...
            </p>
        </div>

    </div>
</section>
		
			<!-- START FOOTER -->
		<?php include 'footer.php' ?>
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
            <script>
    
</script>
    </body>
</html>