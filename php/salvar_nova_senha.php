<?php

require_once __DIR__ . "/config/config.php";

$email = trim($_POST["email"] ?? '');
$senha = $_POST["senha"] ?? '';
$confirmarSenha = $_POST["confirmar_senha"] ?? '';

if (empty($email) || empty($senha) || empty($confirmarSenha)) {
    echo "Preencha todos os campos.";
    exit();
}

if ($senha !== $confirmarSenha) {
    echo "As senhas não são iguais.";
    exit();
}

/* Cria o hash da nova senha */
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

/* Tenta atualizar a senha do egresso */
$stmt = $conn->prepare("UPDATE egresso SET senha = ? WHERE email = ?");
$stmt->bind_param("ss", $senhaHash, $email);
$stmt->execute();

if ($stmt->affected_rows > 0) {

    $senhaAlterada = true;

} else {

    /* Se não for egresso, tenta atualizar a senha da empresa */
    $stmt = $conn->prepare("UPDATE empresa SET senha = ? WHERE email = ?");
    $stmt->bind_param("ss", $senhaHash, $email);
    $stmt->execute();

    $senhaAlterada = $stmt->affected_rows > 0;
}

if (!$senhaAlterada) {
    echo "Não foi possível alterar a senha.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <!-- Meta -->
    <meta charset="utf-8">
    <base href="../">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Senha alterada - Plataforma 3R</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/themify-icons.css">

    <!-- CSS do projeto -->
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

            <div id="telaSucesso" style="text-align: center; padding: 20px 0;">

                <!-- Ícone de sucesso -->
                <svg
                    width="100"
                    height="100"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="#EDB064"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    style="margin-bottom: 20px;"
                >
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>


                <h2 style="
                    color: #222;
                    font-size: 28px;
                    font-weight: 700;
                    margin-bottom: 20px;
                ">
                    Senha alterada com sucesso!
                </h2>


                <p style="
                    color: #444;
                    font-size: 16px;
                    line-height: 1.6;
                    margin-bottom: 30px;
                ">
                    Sua senha foi atualizada com sucesso.<br>
                    Agora você já pode acessar sua conta com a nova senha.
                </p>


                <a
                    href="login.php"
                    class="btn-submit"
                    style="
                        display: inline-block;
                        text-decoration: none;
                    "
                >
                    Voltar para o login
                </a>

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