<?php

require_once "../config/config.php";

if (!isset($_SESSION["usuario"])) {

    header("Location: /tcc-1/login.html");
    exit();

}

?>