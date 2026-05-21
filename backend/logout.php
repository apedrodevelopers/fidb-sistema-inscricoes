<?php

session_start();

unset($_SESSION["usuario-logado"]);

header("Location: ../admin/entrar.php");
