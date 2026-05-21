<?php

session_start();

require "usuario.php";

$usuario = $_POST["utilizador"] ?? "";
$senha = $_POST["senha"] ?? "";

$resultado = login($usuario, $senha);

if (empty($resultado)) {
    header("Location: ../admin/entrar.php");
    exit;
}

$_SESSION["usuario-logado"] = [
    "nome" => $resultado["nome"],
    "email" => $resultado["email"],
    "cargo" => $resultado["cargo"],
    "perfil" => $resultado["perfil"],
];

header("Location: ../admin/dashboard.php");
