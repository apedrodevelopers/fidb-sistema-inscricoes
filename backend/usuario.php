<?php

require "config.php";

function login(string $usuario, string $senha): array
{
    $conexao = estabelecerConexaoComBanco();

    $stmt = $conexao->prepare("SELECT * FROM utilizadores WHERE nome_utilizador = :utilizador AND senha_hash = :senha");
    $stmt->execute([
        ":utilizador" => $usuario,
        ":senha" => $senha
    ]);

    $resultado =  $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado === false) {
        return [];
    } else {
        return $resultado;
    }
}
