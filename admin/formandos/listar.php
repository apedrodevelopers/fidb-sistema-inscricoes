<?php

session_start();

if (
  !isset($_SESSION["usuario-logado"])
) {
  header("Location: ../admin/entrar.php");
}

$usuario = $_SESSION["usuario-logado"]["nome"];
$cargo = $_SESSION["usuario-logado"]["cargo"];

require "../../backend/curso.php";
require "../../backend/dashboard.php";
require "../../backend/inscricao.php";

$resumo = exibirResumoInscricoes();

$inscricoes = buscarInscricoes();

// $cursos = buscarCursosComDetalhesDeVagas();
?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formandos — Capacita CFTI</title>
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
        <div class="nav-utilizador-nome"> <?= $usuario ?> </div>
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
        <a href="../cursos/listar.php" class="nav-item"><span class="nav-item-icone">🎓</span> Cursos</a>
        <a href="listar.php" class="nav-item activo"><span class="nav-item-icone">👥</span> Formandos</a>
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
        <div class="barra-topo-titulo">Formandos</div>
        <div class="barra-topo-sub">Gestão de inscrições</div>
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
            <div class="metrica-valor"> <?= $resumo["aprovados"] ?> </div>
          </div>
        </div>
        <div class="metrica animar" style="animation-delay:.12s">
          <div class="metrica-icone aviso">⏳</div>
          <div>
            <div class="metrica-rotulo">Pendentes</div>
            <div class="metrica-valor"> <?= $resumo["pendentes"] ?> </div>
          </div>
        </div>
      </div>

      <!-- FILTROS — links simples prontos para integrar com ?estado= no PHP -->
      <div class="barra-filtros">
        <a href="listar.html" class="btn-filtro activo">Todos (10)</a>
        <a href="listar.html?estado=aprovado" class="btn-filtro">✅ Aprovados</a>
        <a href="listar.html?estado=pendente" class="btn-filtro">⏳ Pendentes</a>
        <a href="listar.html?estado=rejeitado" class="btn-filtro">❌ Rejeitados</a>
        <!-- Filtro por curso via form GET — a integrar com PHP -->
        <form method="GET" action="listar.html" style="margin-left:auto; display:flex; gap:6px;">
          <select name="curso" style="font-size:12px; padding:6px 10px; max-width:200px;">
            <option value="">Todos os cursos</option>
            <option value="1">Web Frontend</option>
            <option value="2">Backend</option>
            <option value="3">Base de Dados</option>
            <option value="4">UI/UX Design</option>
            <option value="5">Redes</option>
            <option value="6">Cibersegurança</option>
          </select>
          <button type="submit" class="btn btn-secundario btn-sm">Filtrar</button>
        </form>
      </div>

      <!-- TABELA -->
      <div class="cartao animar" style="animation-delay:.18s">
        <div class="cartao-cab">
          <div class="cartao-titulo">Lista de formandos</div>
          <div class="cartao-sub">10 resultado(s)</div>
        </div>
        <div class="tabela-envolvedor">
          <table class="tabela">
            <thead>
              <tr>
                <th>Formando</th>
                <th>Nº Inscrição</th>
                <th>Curso</th>
                <th>Data</th>
                <th>Estado</th>
                <th>Acções</th>
              </tr>
            </thead>
            <tbody>

              <?php
              foreach ($inscricoes as $inscricao) {
                // echo "<pre>";
                // print_r($inscricao);
                // echo "</pre>";
              ?>
                <tr>
                  <td>
                    <div class="celula-pessoa">
                      <div class="avatar azul">AM</div>
                      <div>
                        <div class="celula-pessoa-nome"> <?= $inscricao["formando"] ?> </div>
                        <div class="celula-pessoa-email"><?= $inscricao["email"] ?></div>
                      </div>
                    </div>
                  </td>
                  <td><code style="font-size:11px;background:var(--fundo);padding:2px 7px;border-radius:5px;color:var(--azul-medio);"> <?= $inscricao["numero_inscricao"] ?> </code></td>
                  <td style="font-size:12px;color:var(--texto-mudo);"><?= $inscricao["curso"] ?></td>
                  <td style="font-size:12px;color:var(--texto-mudo);white-space:nowrap;"><?= explode(" ", $inscricao["criado_em"])[0] ?></td>
                  <td><span class="etiqueta etiqueta-sucesso"><span class="ponto"></span> <?= ucfirst($inscricao["estado"]) ?> </span></td>
                  <td>
                    <div class="acoes-tabela">
                      <!-- Ver — navega para página de detalhes -->
                      <a href="ver.php?id=<?= $inscricao['id_inscricao'] ?>" class="btn btn-secundario btn-sm">👁 Ver</a>
                      <!-- Aprovar — link directo para acção PHP: href="actualizar_estado.php?id=1&estado=aprovado" -->
                      <a href="actualizar_estado.php?id=<?= $inscricao['id_inscricao'] ?>&estado=aprovado" class="btn btn-sucesso btn-sm">✅ Aprovar</a>
                      <!-- Rejeitar — link directo para acção PHP: href="actualizar_estado.php?id=1&estado=rejeitado" -->
                      <a href="actualizar_estado.php?id=<?= $inscricao['id_inscricao'] ?>&estado=rejeitado" class="btn btn-perigo btn-sm">❌ Rejeitar</a>
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