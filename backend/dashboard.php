<?php
require "config.php";
function exibirResumoInscricoes(): array
{

    $conexao = estabelecerConexaoComBanco();

    $stmt = $conexao->query("
        SELECT
	        (SELECT COUNT(id) FROM inscricoes) AS total,
            (SELECT COUNT(id) FROM inscricoes WHERE estado = 'aprovado') AS aprovados,
	        (SELECT COUNT(id) FROM inscricoes WHERE estado = 'pendente') AS pendentes
    ");

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    return $resultado;
}

function exibirInscricoesRecentes(): array
{

    $conexao = estabelecerConexaoComBanco();

    $stmt = $conexao->query("
        SELECT
            f.nome AS formando,
            c.nome AS curso,
            i.estado
        FROM 
            inscricoes i
            INNER JOIN formandos f ON i.formando_id = f.id
            INNER JOIN cursos c ON i.curso_id = c.id
        ORDER BY i.id DESC LIMIT 5
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
