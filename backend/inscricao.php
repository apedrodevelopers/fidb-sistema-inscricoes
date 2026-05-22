<?php
require "config.php";
if (isset($_GET["action"])) {

    if ($_GET["action"] === "INSERT") {
        $idFormando = cadastrarFormando($_POST);
        $idInscricao = inscrever($_POST["curso"], $idFormando);

        header("Location: ../paginas/comprovativo.php?id=$idInscricao");
        exit;
    }

    if ($_GET["action"] === "ATUALIZAR_ESTADO") {
        $idInscricao = $_GET["id"];
        $novoEstado = $_GET["estado"];

        atualizarEstado($idInscricao, $novoEstado);

        header("Location: ../admin/formandos/listar.php");
        exit;
    }
}

function atualizarEstado(int $id, string $estado): void
{

    $conexao = estabelecerConexaoComBanco();

    $stmt =   $conexao->prepare("UPDATE inscricoes SET estado=:estado WHERE id = :id");

    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":estado", $estado);

    $stmt->execute();
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
                f.escolaridade,
                f.morada,
                c.nome AS curso,
                c.duracao,
                c.emoji
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

function buscarInscricoes(string $filtroDeEstado = ""): array
{

    if ($filtroDeEstado != "pendente" && $filtroDeEstado != "aprovado" && $filtroDeEstado != "rejeitado") {
        $filtroDeEstado = "%";
    }

    $conexao = estabelecerConexaoComBanco();

    $sql = "
        SELECT
            f.nome AS formando,
            f.email,
            c.nome AS curso,
            i.estado,
            i.criado_em,
            i.numero_inscricao,
            i.id AS id_inscricao
        FROM 
            inscricoes i
            INNER JOIN formandos f ON i.formando_id = f.id
            INNER JOIN cursos c ON i.curso_id = c.id
        WHERE i.estado LIKE :estado
        ORDER BY i.id DESC
    ";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":estado", $filtroDeEstado);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function buscarInscricoesPorCurso(int $idCurso): array
{

    $conexao = estabelecerConexaoComBanco();

    $sql = "
        SELECT
            f.nome AS formando,
            f.email,
            c.nome AS curso,
            i.estado,
            i.criado_em,
            i.numero_inscricao,
            i.id AS id_inscricao
        FROM 
            inscricoes i
            INNER JOIN formandos f ON i.formando_id = f.id
            INNER JOIN cursos c ON i.curso_id = c.id
        WHERE c.id = :id_curso
        ORDER BY i.id DESC
    ";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(":id_curso", $idCurso);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
