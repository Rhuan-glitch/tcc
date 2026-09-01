<?php
session_start();
session_unset();
session_destroy();

header("Location: /tcc-1/index.php");
exit;