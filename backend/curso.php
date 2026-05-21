<?php
require "config.php";

function buscarCursos(): array
{
    $conexao = estabelecerConexaoComBanco();

    $stmt = $conexao->query("SELECT * FROM cursos ORDER BY nome");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function buscarCursosComDetalhesDeVagas(): array
{
    $conexao = estabelecerConexaoComBanco();

    $stmt = $conexao->query("
        SELECT 
            c.*,
            (
                SELECT 
                    COUNT(i.id) 
                FROM 
                    inscricoes i 
                WHERE 
                    i.curso_id = c.id
            ) as total_inscritos
        FROM cursos c;
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
