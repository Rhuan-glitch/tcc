<?php

require_once "config/config.php";

if(validarEmail("teste@gmail.com"))
{
    echo "Email válido";
}
else
{
    echo "Email inválido";
}

?>