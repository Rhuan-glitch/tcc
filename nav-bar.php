<?php



$logado = isset($_SESSION["usuario"]);
$tipo = $_SESSION["tipo"] ?? null;

?>

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

            <!-- LOGO -->
            <div class="col-6 col-xl-2">

                <h1 class="mb-0 site-logo">

                    <a href="index.php">

                        <img 
                            src="assets/img/Logo 3R .png" 
                            alt="Logo 3R"
                        >

                    </a>

                </h1>

            </div>


            <!-- NAVBAR DESKTOP -->
            <div class="col-12 col-md-10 d-none d-xl-block">

                <nav 
                    class="site-navigation position-relative text-right" 
                    role="navigation"
                >

                    <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">


                        <!-- ========================= -->
                        <!-- VISITANTE -->
                        <!-- ========================= -->

                        <?php if (!$logado): ?>

                            <li>
                                <a 
                                    href="index.php" 
                                    class="nav-link"
                                >
                                    Home
                                </a>
                            </li>

                            <li>
                                <a 
                                    href="login.php" 
                                    class="nav-link"
                                >
                                    Login
                                </a>
                            </li>

                            <li>
                                <a 
                                    href="cadastro.php" 
                                    class="nav-link"
                                >
                                    Cadastre-se
                                </a>
                            </li>


                        <!-- ========================= -->
                        <!-- ADMINISTRADOR -->
                        <!-- ========================= -->

                        <?php elseif ($tipo === "administrador"): ?>

                            <li>
                                <a 
                                    href="index.php" 
                                    class="nav-link"
                                >
                                    Home
                                </a>
                            </li>

                            <li>
                                <a 
                                    href="trabalhista.php" 
                                    class="nav-link"
                                >
                                    Trabalhista
                                </a>
                            </li>

                            <li>
                                <a 
                                    href="formacao.php" 
                                    class="nav-link"
                                >
                                    Formação
                                </a>
                            </li>

                            <li>
                                <a 
                                    href="php/logout.php" 
                                    class="nav-link"
                                >
                                    Sair
                                </a>
                            </li>


                        <!-- ========================= -->
                        <!-- EMPRESA -->
                        <!-- ========================= -->

                        <?php elseif ($tipo === "empresa"): ?>

                            <li>
                                <a 
                                    href="index.php" 
                                    class="nav-link"
                                >
                                    Home
                                </a>
                            </li>

                            <li>
                                <a 
                                    href="perfil_empresa.php" 
                                    class="nav-link"
                                >
                                    Perfil
                                </a>
                            </li>
                            <li>
                                <a 
                                    href="trabalhista.php" 
                                    class="nav-link"
                                >
                                    Trabalhista
                                </a>
                            </li>
                            <li>
                                <a 
                                    href="formacao.php" 
                                    class="nav-link"
                                >
                                    Formação
                                </a>
                            </li>
                            <li>
                                <a 
                                    href="php/logout.php" 
                                    class="nav-link"
                                >
                                    Sair
                                </a>
                            </li>


                        <!-- ========================= -->
                        <!-- EGRESSO -->
                        <!-- ========================= -->

                        <?php elseif ($tipo === "egresso"): ?>

                            <li>
                                <a 
                                    href="index.php" 
                                    class="nav-link"
                                >
                                    Home
                                </a>
                            </li>

                            <li>
                                <a 
                                    href="perfil_egresso.php" 
                                    class="nav-link"
                                >
                                    Perfil
                                </a>
                            </li>

                            <li>
                                <a 
                                    href="trabalhista.php" 
                                    class="nav-link"
                                >
                                    Trabalhista
                                </a>
                            </li>

                            <li>
                                <a 
                                    href="formacao.php" 
                                    class="nav-link"
                                >
                                    Formação
                                </a>
                            </li>

                            <li>
                                <a 
                                    href="php/logout.php" 
                                    class="nav-link"
                                >
                                    Sair
                                </a>
                            </li>

                        <?php endif; ?>

                    </ul>

                </nav>

            </div>


            <!-- MENU MOBILE -->

            <div class="col-6 d-inline-block d-xl-none ml-md-0 py-3">

                <a 
                    href="#" 
                    class="site-menu-toggle js-menu-toggle float-right"
                >
                    <span class="icon-menu h3"></span>
                </a>

            </div>

        </div>

    </div>

</header>

<!-- END NAVBAR -->