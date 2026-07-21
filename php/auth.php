<?php

require_once "php/config/config.php";

if (!isset($_SESSION["usuario"])) {

    header("Location: /tcc-1/login.html");
    exit();

}

?>