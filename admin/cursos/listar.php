<?php

session_start();

if (
  !isset($_SESSION["usuario-logado"])
) {
  header("Location: ../entrar.php");
}

$usuario = $_SESSION["usuario-logado"]["nome"];
$cargo = $_SESSION["usuario-logado"]["cargo"];

require "../../backend/config.php";
require "../../backend/curso.php";

$cursos = buscarCursosComDetalhesDeVagas();


?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cursos — Capacita CFTI</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>

<body>

  <nav class="nav-lateral">
    <a href="" class="nav-marca">
      <div class="nav-marca-icone">🎓</div>
      <div>
        <div class="nav-marca-nome">Capacita CFTI</div>
        <div class="nav-marca-sub">Área Admin</div>
      </div>
    </a>
    <div class="nav-utilizador">
      <div class="nav-avatar">AD</div>
      <div>
        <div class="nav-utilizador-nome"><?= $usuario ?></div>
        <div class="nav-utilizador-cargo"><?= $cargo ?></div>
      </div>
    </div>
    <div class="nav-corpo">
      <div class="nav-grupo">
        <div class="nav-grupo-titulo">Principal</div>
        <a href="../dashboard.php" class="nav-item"><span class="nav-item-icone">📊</span> Dashboard</a>
      </div>
      <div class="nav-grupo">
        <div class="nav-grupo-titulo">Gestão</div>
        <a href="listar.php" class="nav-item activo"><span class="nav-item-icone">🎓</span> Cursos</a>
        <a href="../formandos/listar.php" class="nav-item"><span class="nav-item-icone">👥</span> Formandos</a>
        <a href="../usuarios/listar.php" class="nav-item"><span class="nav-item-icone">🔑</span> Utilizadores</a>
      </div>
      <div class="nav-grupo">
        <div class="nav-grupo-titulo">Sistema</div>
        <a href="../../inicio.php" class="nav-item"><span class="nav-item-icone">🌐</span> Site público</a>
      </div>
    </div>
    <div class="nav-rodape">
      <a href="../backend/logout.php" class="nav-sair"><span>🚪</span> Sair</a>
    </div>
  </nav>

  <div class="area-principal">
    <header class="barra-topo">
      <div>
        <div class="barra-topo-titulo">Cursos</div>
        <div class="barra-topo-sub">Cadastro e gestão da oferta formativa</div>
      </div>
    </header>

    <main class="conteudo">

      <div class="cab-secao">
        <div>
          <div class="cab-titulo">Lista de cursos</div>
          <div class="cab-sub"><?= count($cursos) ?> curso(s) registado(s)</div>
        </div>
        <a href="criar.php" class="btn btn-primario">+ Novo curso</a>
      </div>

      <div class="cartao animar">
        <div class="tabela-envolvedor">
          <table class="tabela">
            <thead>
              <tr>
                <th>Curso</th>
                <th>Área</th>
                <th>Duração</th>
                <th>Modalidade</th>
                <th>Início</th>
                <th>Vagas</th>
                <th>Propina</th>
                <th>Estado</th>
                <th>Acções</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($cursos as $curso) {
              ?>
                <tr>
                  <td>
                    <div style="display:flex;align-items:center;gap:9px;">
                      <span style="font-size:20px;"> <?= EMOJIS[$curso["emoji"]] ?> </span>
                      <div>
                        <div style="font-weight:600;font-size:13px;"> <?= $curso["nome"] ?> </div>
                        <div style="font-size:11px;color:var(--texto-mudo);"><?= $curso["subtitulo"] ?></div>
                      </div>
                    </div>
                  </td>
                  <td style="font-size:12px;color:var(--texto-mudo);"><?= $curso["area"] ?></td>
                  <td><?= $curso["duracao"] ?></td>
                  <td><span class="etiqueta etiqueta-sucesso"><?= $curso["modalidade"] ?></span></td>
                  <td style="font-size:12px;color:var(--texto-mudo);"><?= $curso["inicio"] ?></td>
                  <td><?= $curso["vagas"] - $curso["total_inscritos"] ?><span style="color:var(--texto-mudo);">/<?= $curso["vagas"] ?></span></td>
                  <td style="font-size:12px;"><?= $curso["preco"] ?> AOA</td>
                  <td><span class="etiqueta etiqueta-sucesso"><span class="ponto"></span><?= ucfirst($curso["estado"]) ?></span></td>
                  <td>
                    <div class="acoes-tabela">
                      <a href="editar.php?id=<?= $curso["id"] ?>" class="btn btn-secundario btn-sm">✏️ Editar</a>
                      <a href="../../backend/curso.php?action=DELETE&id=<?= $curso["id"] ?>" class="btn btn-perigo btn-sm">🗑</a>
                    </div>
                  </td>
                </tr>

              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>

    </main>
  </div>
</body>

</html>