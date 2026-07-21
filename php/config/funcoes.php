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

?>