<?php

session_start();

if (
  !isset($_SESSION["usuario-logado"])
) {
  header("Location: ../admin/entrar.php");
}

$usuario = $_SESSION["usuario-logado"]["nome"];
$cargo = $_SESSION["usuario-logado"]["cargo"];

require "../backend/curso.php";
require "../backend/dashboard.php";

$resumo = exibirResumoInscricoes();

$recentes = exibirInscricoesRecentes();

$cursos = buscarCursosComDetalhesDeVagas();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — Capacita CFTI</title>
  <link rel="stylesheet" href="css/admin.css">
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
        <div class="nav-utilizador-nome"> <?= $usuario ?> </div>
        <div class="nav-utilizador-cargo"> <?= $cargo ?> </div>
      </div>
    </div>
    <div class="nav-corpo">
      <div class="nav-grupo">
        <div class="nav-grupo-titulo">Principal</div>
        <a href="dashboard.php" class="nav-item activo"><span class="nav-item-icone">📊</span> Dashboard</a>
      </div>
      <div class="nav-grupo">
        <div class="nav-grupo-titulo">Gestão</div>
        <a href="cursos/listar.php" class="nav-item"><span class="nav-item-icone">🎓</span> Cursos</a>
        <a href="formandos/listar.php" class="nav-item"><span class="nav-item-icone">👥</span> Formandos</a>
        <a href="usuarios/listar.php" class="nav-item"><span class="nav-item-icone">🔑</span> Utilizadores</a>
      </div>
      <div class="nav-grupo">
        <div class="nav-grupo-titulo">Sistema</div>
        <a href="../inicio.php" class="nav-item"><span class="nav-item-icone">🌐</span> Site público</a>
      </div>
    </div>
    <div class="nav-rodape">
      <a href="../backend/logout.php" class="nav-sair"><span>🚪</span> Sair</a>
    </div>
  </nav>

  <div class="area-principal">
    <header class="barra-topo">
      <div>
        <div class="barra-topo-titulo">Dashboard</div>
        <div class="barra-topo-sub">Visão geral do sistema</div>
      </div>
    </header>

    <main class="conteudo">

      <!-- MÉTRICAS -->
      <div class="grelha-metricas">
        <div class="metrica animar">
          <div class="metrica-icone azul">📝</div>
          <div>
            <div class="metrica-rotulo">Total de inscrições</div>
            <div class="metrica-valor"> <?= $resumo["total"] ?> </div>
          </div>
        </div>
        <div class="metrica animar" style="animation-delay:.06s">
          <div class="metrica-icone verde">✅</div>
          <div>
            <div class="metrica-rotulo">Aprovados</div>
            <div class="metrica-valor"><?= $resumo["aprovados"] ?></div>
          </div>
        </div>
        <div class="metrica animar" style="animation-delay:.12s">
          <div class="metrica-icone aviso">⏳</div>
          <div>
            <div class="metrica-rotulo">Pendentes</div>
            <div class="metrica-valor"><?= $resumo["pendentes"] ?></div>
          </div>
        </div>
      </div>

      <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

        <!-- Últimas inscrições -->
        <div class="cartao animar" style="animation-delay:.18s">
          <div class="cartao-cab">
            <div>
              <div class="cartao-titulo">Últimas inscrições</div>
              <div class="cartao-sub">5 mais recentes</div>
            </div>
            <a href="formandos/listar.html" class="btn btn-secundario btn-sm">Ver todos</a>
          </div>
          <div class="tabela-envolvedor">
            <table class="tabela">
              <thead>
                <tr>
                  <th>Formando</th>
                  <th>Curso</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>

                <?php
                foreach ($recentes as $inscricao) {
                ?>
                  <tr>
                    <td>
                      <div class="celula-pessoa">
                        <div class="avatar azul">AM</div>
                        <div class="celula-pessoa-nome"> <?= $inscricao["formando"] ?> </div>
                      </div>
                    </td>
                    <td style="font-size:12px;color:var(--texto-mudo);"> <?= $inscricao["curso"] ?> </td>
                    <td><span class="etiqueta etiqueta-sucesso"><span class="ponto"></span> <?= ucfirst($inscricao["estado"]) ?> </span></td>
                  </tr>

                <?php
                }
                ?>

              </tbody>
            </table>
          </div>
        </div>

        <!-- Resumo de cursos -->
        <div class="cartao animar" style="animation-delay:.24s">
          <div class="cartao-cab">
            <div>
              <div class="cartao-titulo">Ocupação por curso</div>
              <div class="cartao-sub">Inscritos vs vagas</div>
            </div>
            <a href="cursos/listar.html" class="btn btn-secundario btn-sm">Gerir</a>
          </div>
          <div class="cartao-corpo">
            <table class="tabela">
              <thead>
                <tr>
                  <th>Curso</th>
                  <th>Inscritos</th>
                  <th>Vagas</th>
                  <th>Livres</th>
                </tr>
              </thead>
              <tbody>

                <?php
                foreach ($cursos as $curso) {
                ?>
                  <tr>
                    <td> <?= EMOJIS[$curso["emoji"]] ?> <?= $curso["nome"] ?></td>
                    <td style="font-weight:600;"><?= $curso["total_inscritos"] ?></td>
                    <td style="color:var(--texto-mudo);"><?= $curso["vagas"] ?></td>
                    <td><span class="etiqueta etiqueta-aviso"> <?= $curso["vagas"] - $curso["total_inscritos"] ?> </span></td>
                  </tr>

                <?php
                }
                ?>

              </tbody>
            </table>
          </div>
        </div>

      </div>
    </main>
  </div>

</body>

</html>