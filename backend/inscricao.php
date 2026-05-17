<?php
require "config.php";

if (isset($_GET["action"])) {
    if ($_GET["action"] === "INSERT") {
        $idFormando = cadastrarFormando($_POST);
        $idInscricao = inscrever($_POST["curso"], $idFormando);

        header("Location: ../paginas/comprovativo.php?id=$idInscricao");
    }
}

function recuperarInscricaoPorId(int $id): array
{

    $conexao = estabelecerConexaoComBanco();

    $stmt =   $conexao->prepare(
        "
            SELECT 
                i.id,
                i.numero_inscricao,
                i.estado,
                i.criado_em,
                f.nome AS formando,
                f.email,
                f.telefone,
                f.documento,
                c.nome AS curso,
                c.duracao
            FROM inscricoes i
            INNER JOIN formandos f ON f.id = i.formando_id
            INNER JOIN cursos c ON c.id = i.curso_id
            WHERE i.id = :id
        "
    );

    $stmt->bindParam(":id", $id);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}



function inscrever(int $cursoId, int $formandoId): int
{
    $conexao = estabelecerConexaoComBanco();

    $numeroInscricao = "INS-" . date("Y") . "-" . random_int(9999, 99999999);

    $stmt =    $conexao->prepare(
        "
        INSERT INTO inscricoes(
            numero_inscricao, formando_id, curso_id
        )
        VALUES(
            :numero_inscricao, :formando_id, :curso_id
        )"
    );

    $stmt->bindParam(":numero_inscricao", $numeroInscricao);
    $stmt->bindParam(":formando_id", $formandoId);
    $stmt->bindParam(":curso_id", $cursoId);

    $stmt->execute();

    return $conexao->lastInsertId();
}

function cadastrarFormando(array $dados): int
{
    $conexao = estabelecerConexaoComBanco();

    $stmt =    $conexao->prepare(
        "
        INSERT INTO formandos(
            nome, email, telefone, documento, data_nascimento, escolaridade, morada
        )
        VALUES(
            :nome, :email, :telefone, :documento, :data_nascimento, :escolaridade, :morada
        )"
    );

    $stmt->bindParam(":nome", $dados["nome"],);
    $stmt->bindParam(":email", $dados["email"]);
    $stmt->bindParam(":telefone", $dados["telefone"]);
    $stmt->bindParam(":documento", $dados["documento"]);
    $stmt->bindParam(":data_nascimento", $dados["data_nascimento"]);
    $stmt->bindParam(":escolaridade", $dados["escolaridade"]);
    $stmt->bindParam(":morada", $dados["morada"]);

    $stmt->execute();

    return $conexao->lastInsertId();
}
