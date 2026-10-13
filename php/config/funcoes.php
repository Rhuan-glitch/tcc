<?php

/**
 * Remove espaços no início e no fim do texto.
 */
function limparTexto($texto)
{
    return trim($texto);
}

/**
 * Redireciona para outra página.
 */
function redirecionar($pagina)
{
    header("Location: $pagina");
    exit();
}

/**
 * Verifica se um e-mail possui formato válido.
 */
function validarEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
/* ==========================================================
   FUNÇÕES DE AUTENTICAÇÃO E PROTEÇÃO
========================================================== */

/**
 * Verifica se existe um usuário logado.
 */
function usuarioLogado()
{
    return isset($_SESSION["usuario"]);
}

/**
 * Exige que o usuário esteja logado.
 */
function exigirLogin()
{
    if (!isset($_SESSION["usuario"])) {
        header("Location: /tcc-1/login.php");
        exit();
    }
}

/**
 * Exige que o usuário esteja logado
 * e possua o perfil especificado.
 */
function exigirPerfil($perfil)
{
    exigirLogin();

    if (!isset($_SESSION["tipo"]) || $_SESSION["tipo"] !== $perfil) {
        header("Location: /tcc-1/index.php");
        exit();
    }
}
function exigirPerfis($perfis)
{
    exigirLogin();

    if (!isset($_SESSION["tipo"]) || !in_array($_SESSION["tipo"], $perfis)) {
        header("Location: /tcc-1/index.php");
        exit();
    }
}
?>