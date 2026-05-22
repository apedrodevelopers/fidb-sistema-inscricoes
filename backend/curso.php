<?php

require "config.php";

if (isset($_GET["action"])) {

    if ($_GET["action"] === "INSERT") {
        try {
            $emoji = $_POST["emoji"];
            $nome = $_POST["nome"];
            $estado = $_POST["estado"];
            $subtitulo = $_POST["subtitulo"];
            $area = $_POST["area"];
            $duracao = $_POST["duracao"];
            $modalidade = $_POST["modalidade"];
            $vagas = $_POST["vagas"];
            $preco = $_POST["preco"];
            $inicio = $_POST["inicio"];
            $horario = $_POST["horario"];

            inserir($emoji, $nome, $subtitulo, $area, $duracao, $vagas, $estado, $inicio, $horario, $preco, $modalidade);

            header("Location: ../admin/cursos/listar.php");
            exit;
        } catch (Exception $ex) {
            header("Location: ../admin/cursos/criar.php");
            exit;
        }
    }

    if ($_GET["action"] === "DELETE") {
        try {
            $idCurso = $_GET["id"];

            deletar($idCurso);

            header("Location: ../admin/cursos/listar.php");
            exit;
        } catch (Exception $ex) {
            header("Location: ../admin/cursos/listar.php");
            exit;
        }
    }
}

if (isset($_POST["action"])) {
    if ($_POST["action"] === "UPDATE") {
        try {
            $emoji = $_POST["emoji"];
            $nome = $_POST["nome"];
            $estado = $_POST["estado"];
            $subtitulo = $_POST["subtitulo"];
            $area = $_POST["area"];
            $duracao = $_POST["duracao"];
            $modalidade = $_POST["modalidade"];
            $vagas = $_POST["vagas"];
            $preco = $_POST["preco"];
            $inicio = $_POST["inicio"];
            $horario = $_POST["horario"];

            $idCurso = $_POST["id"];

            atualizar($emoji, $nome, $subtitulo, $area, $duracao, $vagas, $estado, $inicio, $horario, $preco, $modalidade, $idCurso);

            header("Location: ../admin/cursos/listar.php");
            exit;
        } catch (Exception $ex) {
            header("Location: ../admin/cursos/editar.php?id=" . $_POST["id"]);
            exit;
        }
    }
}

function deletar(int $idCurso): void
{
    $conexao = estabelecerConexaoComBanco();

    $stmt = $conexao->prepare("DELETE FROM cursos WHERE id = :id");

    $stmt->bindParam(":id", $idCurso);

    $stmt->execute();
}

function inserir(
    string $emoji,
    string $nome,
    string $subtitulo,
    string $area,
    string $duracao,
    int $vagas,
    string $estado,
    string $inicio,
    string $horario,
    float $preco,
    string $modalidade
): void {
    $conexao = estabelecerConexaoComBanco();

    $stmt = $conexao->prepare("
        INSERT INTO cursos (
            emoji, nome, subtitulo, area, duracao, modalidade, vagas, estado, inicio, horario, preco
        ) 
        VALUES (
            :emoji, :nome, :subtitulo, :area, :duracao, :modalidade, :vagas, :estado, :inicio, :horario, :preco
        )
    ");

    $stmt->bindParam(":emoji", $emoji);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":subtitulo", $subtitulo);
    $stmt->bindParam(":area", $area);
    $stmt->bindParam(":duracao", $duracao);
    $stmt->bindParam(":modalidade", $modalidade);
    $stmt->bindParam(":vagas", $vagas);
    $stmt->bindParam(":estado", $estado);
    $stmt->bindParam(":inicio", $inicio);
    $stmt->bindParam(":horario", $horario);
    $stmt->bindParam(":preco", $preco);

    $stmt->execute();
}

function atualizar(
    string $emoji,
    string $nome,
    string $subtitulo,
    string $area,
    string $duracao,
    int $vagas,
    string $estado,
    string $inicio,
    string $horario,
    float $preco,
    string $modalidade,
    int $idCurso
): void {
    $conexao = estabelecerConexaoComBanco();

    $stmt = $conexao->prepare("
        UPDATE cursos SET
            emoji = :emoji, 
            nome = :nome, 
            subtitulo = :subtitulo, 
            area = :area, 
            duracao = :duracao, 
            modalidade = :modalidade, 
            vagas = :vagas, 
            estado = :estado, 
            inicio = :inicio, 
            horario = :horario, 
            preco = :preco
        WHERE id = :id
    ");

    $stmt->bindParam(":emoji", $emoji);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":subtitulo", $subtitulo);
    $stmt->bindParam(":area", $area);
    $stmt->bindParam(":duracao", $duracao);
    $stmt->bindParam(":modalidade", $modalidade);
    $stmt->bindParam(":vagas", $vagas);
    $stmt->bindParam(":estado", $estado);
    $stmt->bindParam(":inicio", $inicio);
    $stmt->bindParam(":horario", $horario);
    $stmt->bindParam(":preco", $preco);
    $stmt->bindParam(":id", $idCurso);

    $stmt->execute();
}

function buscarCursos(): array
{
    $conexao = estabelecerConexaoComBanco();

    $stmt = $conexao->query("SELECT * FROM cursos ORDER BY nome");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function buscarCursoPorId(int $idCurso): array
{
    $conexao = estabelecerConexaoComBanco();

    $stmt = $conexao->prepare("SELECT * FROM cursos WHERE id = :id ORDER BY nome");
    $stmt->execute([":id" => $idCurso]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
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
