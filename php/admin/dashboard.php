<?php
session_start();

/* ==========================================================
   PROTEÇÃO DO DASHBOARD
   Apenas administradores podem acessar esta página.
========================================================== */

if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] !== "administrador") {
    header("Location: ../login.html");
    exit();
}

$usuario = $_SESSION["usuario"];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Administrador | Plataforma 3R</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">

    <!-- Google Fonts -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800">

    <!-- CSS do projeto -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">

    <style>

        body {
            background: #f5f6f8;
            font-family: 'Poppins', sans-serif;
        }

        /* ==================================================
           NAVBAR
        ================================================== */

        .admin-navbar {
            background: #ffffff;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .admin-logo img {
            max-height: 55px;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-user i {
            font-size: 28px;
            color: #F76B1C;
        }

        .admin-user-info {
            line-height: 1.3;
        }

        .admin-user-info strong {
            display: block;
            color: #333;
        }

        .admin-user-info span {
            font-size: 12px;
            color: #888;
        }

        .btn-sair {
            margin-left: 20px;
            border: 1px solid #F76B1C;
            color: #F76B1C;
            padding: 8px 18px;
            border-radius: 5px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-sair:hover {
            background: #F76B1C;
            color: #fff;
            text-decoration: none;
        }

        /* ==================================================
           DASHBOARD
        ================================================== */

        .dashboard-container {
            padding: 60px 0;
        }

        .dashboard-header {
            margin-bottom: 40px;
        }

        .dashboard-header .subtitulo {
            color: #F76B1C;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .dashboard-header h1 {
            font-size: 36px;
            font-weight: 700;
            color: #222;
            margin-top: 8px;
            margin-bottom: 10px;
        }

        .dashboard-header p {
            color: #777;
            font-size: 15px;
        }

        /* ==================================================
           CARDS
        ================================================== */

        .dashboard-card {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: 0.3s;
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.10);
        }

        .dashboard-icon {
            width: 65px;
            height: 65px;
            border-radius: 12px;
            background: rgba(247,107,28,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .dashboard-icon i {
            font-size: 28px;
            color: #F76B1C;
        }

        .dashboard-card h3 {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .dashboard-card p {
            color: #777;
            font-size: 14px;
            min-height: 45px;
        }

        .btn-dashboard {
            display: inline-block;
            margin-top: 15px;
            background: #F76B1C;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-dashboard:hover {
            background: #d9570d;
            color: #fff;
            text-decoration: none;
        }

        .btn-dashboard-secondary {
            background: #333;
        }

        .btn-dashboard-secondary:hover {
            background: #222;
        }

        /* ==================================================
           ÁREA DE DESTAQUE
        ================================================== */

        .welcome-box {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            border-left: 5px solid #F76B1C;
        }

        .welcome-box h2 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .welcome-box p {
            margin: 0;
            color: #777;
            font-size: 14px;
        }

        /* ==================================================
           RESPONSIVO
        ================================================== */

        @media (max-width: 768px) {

            .dashboard-header h1 {
                font-size: 28px;
            }

            .admin-user {
                margin-top: 15px;
            }

            .btn-sair {
                margin-left: 10px;
            }

        }

    </style>

</head>


<body>


<!-- ======================================================
     NAVBAR DO ADMINISTRADOR
====================================================== -->

<header class="admin-navbar">

    <div class="container">

        <div class="row align-items-center">

            <!-- LOGO -->
            <div class="col-md-6">

                <a href="../index.html" class="admin-logo">

                    <img src="../assets/img/Logo 3R (5).png"
                         alt="Plataforma 3R">

                </a>

            </div>


            <!-- USUÁRIO -->
            <div class="col-md-6">

                <div class="admin-user justify-content-md-end">

                    <i class="fa fa-user-circle"></i>

                    <div class="admin-user-info">

                        <strong>
                            <?php echo htmlspecialchars($usuario); ?>
                        </strong>

                        <span>
                            Administrador
                        </span>

                    </div>

                    <a href="../php/logout.php" class="btn-sair">
                        <i class="fa fa-sign-out"></i>
                        Sair
                    </a>

                </div>

            </div>

        </div>

    </div>

</header>



<!-- ======================================================
     CONTEÚDO DO DASHBOARD
====================================================== -->

<section class="dashboard-container">

    <div class="container">


        <!-- CABEÇALHO -->

        <div class="dashboard-header">

            <span class="subtitulo">
                Painel administrativo
            </span>

            <h1>
                Dashboard
            </h1>

            <p>
                Gerencie os conteúdos e usuários da Plataforma 3R.
            </p>

        </div>



        <!-- MENSAGEM DE BOAS-VINDAS -->

        <div class="welcome-box">

            <h2>
                Olá, <?php echo htmlspecialchars($usuario); ?>! 👋
            </h2>

            <p>
                Bem-vindo ao painel administrativo da Plataforma 3R.
                Aqui você poderá gerenciar formações, empresas e egressos.
            </p>

        </div>



        <!-- ==================================================
             CARDS
        ================================================== -->

        <div class="row">


            <!-- ==============================================
                 FORMAÇÕES
            ============================================== -->

            <div class="col-lg-4 col-md-6">

                <div class="dashboard-card">

                    <div class="dashboard-icon">

                        <i class="fa fa-graduation-cap"></i>

                    </div>

                    <h3>
                        Formações
                    </h3>

                    <p>
                        Publique, edite e exclua cursos e
                        formações disponíveis na Plataforma 3R.
                    </p>

                    <a href="/tcc-1/formacao.php"
                       class="btn-dashboard">

                        Gerenciar formações

                    </a>

                </div>

            </div>



            <!-- ==============================================
                 PUBLICAR FORMAÇÃO
            ============================================== -->

            <div class="col-lg-4 col-md-6">

                <div class="dashboard-card">

                    <div class="dashboard-icon">

                        <i class="fa fa-plus"></i>

                    </div>

                    <h3>
                        Publicar Formação
                    </h3>

                    <p>
                        Cadastre uma nova formação para que ela
                        fique disponível no site.
                    </p>

                    <a href="../formacao.html#modalCurso"
                       class="btn-dashboard">

                        Publicar formação

                    </a>

                </div>

            </div>



            <!-- ==============================================
                 EMPRESAS
            ============================================== -->

            <div class="col-lg-4 col-md-6">

                <div class="dashboard-card">

                    <div class="dashboard-icon">

                        <i class="fa fa-building"></i>

                    </div>

                    <h3>
                        Empresas
                    </h3>

                    <p>
                        Consulte e gerencie as empresas cadastradas
                        na Plataforma 3R.
                    </p>

                    <a href="#"
                       class="btn-dashboard btn-dashboard-secondary">

                        Gerenciar empresas

                    </a>

                </div>

            </div>



            <!-- ==============================================
                 EGRESSOS
            ============================================== -->

            <div class="col-lg-4 col-md-6">

                <div class="dashboard-card">

                    <div class="dashboard-icon">

                        <i class="fa fa-users"></i>

                    </div>

                    <h3>
                        Egressos
                    </h3>

                    <p>
                        Consulte os usuários egressos cadastrados
                        na plataforma.
                    </p>

                    <a href="#"
                       class="btn-dashboard btn-dashboard-secondary">

                        Gerenciar egressos

                    </a>

                </div>

            </div>



            <!-- ==============================================
                 VAGAS
            ============================================== -->

            <div class="col-lg-4 col-md-6">

                <div class="dashboard-card">

                    <div class="dashboard-icon">

                        <i class="fa fa-briefcase"></i>

                    </div>

                    <h3>
                        Vagas de emprego
                    </h3>

                    <p>
                        Acompanhe as oportunidades de trabalho
                        cadastradas pelas empresas.
                    </p>

                    <a href="#"
                       class="btn-dashboard btn-dashboard-secondary">

                        Gerenciar vagas

                    </a>

                </div>

            </div>



            <!-- ==============================================
                 CONFIGURAÇÕES
            ============================================== -->

            <div class="col-lg-4 col-md-6">

                <div class="dashboard-card">

                    <div class="dashboard-icon">

                        <i class="fa fa-cog"></i>

                    </div>

                    <h3>
                        Configurações
                    </h3>

                    <p>
                        Gerencie as configurações da área
                        administrativa da plataforma.
                    </p>

                    <a href="#"
                       class="btn-dashboard btn-dashboard-secondary">

                        Configurações

                    </a>

                </div>

            </div>


        </div>

    </div>

</section>



<!-- ======================================================
     FOOTER
====================================================== -->

<footer class="footer">

    <div class="container">

        <div class="row">

            <div class="col-lg-12 text-center">

                <div class="footer_copyright">

                    <p>
                        &copy; 2026 Plataforma 3R -
                        Recomeçar, Reconstruir e Renascer.
                        <br>
                        Todos os direitos reservados.
                    </p>

                </div>

            </div>

        </div>

    </div>

</footer>



<!-- ======================================================
     JAVASCRIPT
====================================================== -->

<script src="../assets/js/jquery-1.12.4.min.js"></script>

<script src="../assets/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>