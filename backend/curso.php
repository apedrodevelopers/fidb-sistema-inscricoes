<?php
require "config.php";

function buscarCursos(): array
{
    $conexao = estabelecerConexaoComBanco();

    $stmt = $conexao->query("SELECT * FROM cursos ORDER BY nome");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
