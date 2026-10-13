<?php

require_once __DIR__ . "/config/config.php";

/* Recebe o e-mail */
$email = trim($_POST["email"] ?? '');

if (empty($email)) {
    echo "E-mail não informado.";
    exit();
}

/* Verifica se o e-mail pertence a um egresso */
$stmt = $conn->prepare("SELECT cpf FROM egresso WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 1) {

    $tipoUsuario = "egresso";

} else {

    /* Verifica se o e-mail pertence a uma empresa */
    $stmt = $conn->prepare("SELECT cnpj FROM empresa WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {

        $tipoUsuario = "empresa";

    } else {

        echo "E-mail não encontrado.";
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Redefinir Senha - Plataforma 3R</title>
    <base href="../">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600">

    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/themify-icons.css">

    <link rel="stylesheet" href="assets/owlcarousel/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/owlcarousel/css/owl.theme.css">

    <link rel="stylesheet" href="assets/css/fonts.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/venobox.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/menu.css">
    <link rel="stylesheet" href="assets/css/slider.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/login.css">

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
    <?php include '../nav-bar.php'; ?>
    <!-- END NAVBAR -->


    <section class="secao-cadastro-3r">

        <div class="container-cadastro">

            <div id="telaRecuperacao">

                <div class="header-form">

                    <img
                        src="assets/img/Logo 3R (5).png"
                        alt="Logo Plataforma 3R"
                        class="logo-cadastro"
                    >

                    <h2>Redefinir Senha</h2>

                    <p>
                        Crie uma nova senha para acessar sua conta.
                    </p>

                </div>


                <form action="php/salvar_nova_senha.php" method="POST">

                    <input
                        type="hidden"
                        name="email"
                        value="<?= htmlspecialchars($email) ?>"
                    >


                    <div class="form-group">

                        <label>Nova senha</label>

                        <input
                            type="password"
                            name="senha"
                            placeholder="Digite sua nova senha"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>Confirmar nova senha</label>

                        <input
                            type="password"
                            name="confirmar_senha"
                            placeholder="Digite novamente sua nova senha"
                            required
                        >

                    </div>


                    <button type="submit" class="btn-submit">
                        Alterar Senha
                    </button>


                    <div class="footer-form">

                        Lembrou a senha?

                        <a href="../login.php">
                            Voltar para o login
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </section>


    <!-- START FOOTER -->
    <?php include '../footer.php'; ?>
    <!-- END FOOTER -->


    <!-- SCRIPTS -->

    <script src="assets/js/jquery-1.12.4.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/modernizr-2.8.3.min.js"></script>
    <script src="assets/owlcarousel/js/owl.carousel.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/jquery.mixitup.js"></script>
    <script src="assets/js/jquery.appear.js"></script>
    <script src="assets/js/jquery.inview.min.js"></script>
    <script src="assets/js/jquery.stellar.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/menu.js"></script>
    <script src="assets/js/jquery.sticky.js"></script>
    <script src="assets/js/scrolltopcontrol.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="assets/js/login.js"></script>

</body>

</html>