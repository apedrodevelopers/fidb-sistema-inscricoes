<?php

session_start();

if (
  !isset($_SESSION["usuario-logado"])
) {
  header("Location: ../entrar.php");
}

$usuario = $_SESSION["usuario-logado"]["nome"];
$cargo = $_SESSION["usuario-logado"]["cargo"];

require "../../backend/inscricao.php";

$inscricao = recuperarInscricaoPorId($_GET["id"]);

?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalhes do Formando — Capacita CFTI</title>
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
        <a href="../cursos/listar.php" class="nav-item"><span class="nav-item-icone">🎓</span> Cursos</a>
        <a href="listar.php" class="nav-item activo"><span class="nav-item-icone">👥</span> Formandos</a>
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
        <div class="barra-topo-titulo">Detalhes do Formando</div>
        <div class="barra-topo-sub"><?= $inscricao["formando"] ?></div>
      </div>
    </header>

    <main class="conteudo">

      <div class="cab-secao">
        <div>
          <div class="cab-titulo"><?= $inscricao["formando"] ?></div>
          <div class="cab-sub"><?= $inscricao["numero_inscricao"] ?></div>
        </div>
        <a href="listar.php" class="btn btn-secundario">← Voltar à lista</a>
      </div>

      <div style="display:grid; grid-template-columns:1fr 320px; gap:16px; align-items:start;">

        <!-- Dados do formando -->
        <div class="cartao animar">
          <div class="cartao-cab">
            <div class="cartao-titulo">Dados pessoais</div>
            <span class="etiqueta etiqueta-sucesso"><span class="ponto"></span> <?= ucfirst($inscricao["estado"]) ?> </span>
          </div>
          <div class="cartao-corpo">

            <div class="linha-detalhe">
              <div class="detalhe-chave">Nome completo</div>
              <div class="detalhe-valor"><?= $inscricao["formando"] ?></div>
            </div>
            <div class="linha-detalhe">
              <div class="detalhe-chave">Nº BI / Passaporte</div>
              <div class="detalhe-valor"><code style="font-size:12px;"><?= $inscricao["documento"] ?></code></div>
            </div>
            <div class="linha-detalhe">
              <div class="detalhe-chave">Email</div>
              <div class="detalhe-valor"><a href="mailto:ana.monteiro@email.com" style="color:var(--azul-medio);"><?= $inscricao["email"] ?></a></div>
            </div>
            <div class="linha-detalhe">
              <div class="detalhe-chave">Telefone</div>
              <div class="detalhe-valor"><?= $inscricao["telefone"] ?></div>
            </div>
            <div class="linha-detalhe">
              <div class="detalhe-chave">Escolaridade</div>
              <div class="detalhe-valor"><?= $inscricao["escolaridade"] ?></div>
            </div>
            <div class="linha-detalhe">
              <div class="detalhe-chave">Morada</div>
              <div class="detalhe-valor"><?= $inscricao["morada"] ?></div>
            </div>
            <div class="linha-detalhe">
              <div class="detalhe-chave">Curso inscrito</div>
              <div class="detalhe-valor" style="font-weight:700;"> <?= EMOJIS[$inscricao["emoji"]]  ?> <?= $inscricao["curso"] ?></div>
            </div>
            <div class="linha-detalhe">
              <div class="detalhe-chave">Data de inscrição</div>
              <div class="detalhe-valor"><?= $inscricao["criado_em"] ?></div>
            </div>
            <div class="linha-detalhe">
              <div class="detalhe-chave">Nº de inscrição</div>
              <div class="detalhe-valor">
                <code style="font-size:13px;background:var(--fundo);padding:3px 8px;border-radius:5px;color:var(--azul-medio);"><?= $inscricao["numero_inscricao"] ?></code>
              </div>
            </div>

          </div>
        </div>

        <!-- Coluna de acções -->
        <div>

          <!-- Formulário de alteração de estado -->
          <!-- action="actualizar_estado.php" method="POST" — a implementar no backend -->
          <div class="cartao animar" style="animation-delay:.1s">
            <div class="cartao-cab">
              <div class="cartao-titulo">Alterar estado</div>
            </div>
            <div class="cartao-corpo">
              <form action="../../backend/inscricao.php" method="GET">
                <input type="hidden" name="action" value="ATUALIZAR_ESTADO">
                <input type="hidden" name="id" value="<?= $inscricao["id"] ?>">
                <div class="grupo">
                  <label class="rotulo" for="estado">Estado da inscrição</label>
                  <select id="estado" name="estado">
                    <option value="aprovado" <?= $inscricao["estado"] === "aprovado" ? "selected" : "" ?>>✅ Aprovado</option>
                    <option value="pendente" <?= $inscricao["estado"] === "pendente" ? "selected" : "" ?>>⏳ Pendente</option>
                    <option value="rejeitado" <?= $inscricao["estado"] === "rejeitado" ? "selected" : "" ?>>❌ Rejeitado</option>
                  </select>
                </div>
                <button type="submit" class="btn btn-primario" style="width:100%;justify-content:center;">
                  ✓ Guardar estado
                </button>
              </form>
            </div>
          </div>

          <!-- Acções rápidas directas — links prontos para integrar com PHP -->
          <div class="cartao animar" style="animation-delay:.18s">
            <div class="cartao-cab">
              <div class="cartao-titulo">Acções rápidas</div>
            </div>
            <div class="cartao-corpo" style="display:flex;flex-direction:column;gap:8px;">

              <!-- href="actualizar_estado.php?id=1&estado=aprovado&voltar=ver.php?id=1" — backend -->
              <a href="../../backend/inscricao.php?action=ATUALIZAR_ESTADO&id=<?= $inscricao['id'] ?>&estado=aprovado"
                class="btn btn-sucesso" style="justify-content:center;">
                ✅ Aprovar inscrição
              </a>

              <!-- href="actualizar_estado.php?id=1&estado=rejeitado&voltar=ver.php?id=1" — backend -->
              <a href="../../backend/inscricao.php?action=ATUALIZAR_ESTADO&id=<?= $inscricao['id'] ?>&estado=rejeitado"
                class="btn btn-perigo" style="justify-content:center;">
                ❌ Rejeitar inscrição
              </a>

              <!-- href="actualizar_estado.php?id=1&estado=pendente&voltar=ver.php?id=1" — backend -->
              <a href="../../backend/inscricao.php?action=ATUALIZAR_ESTADO&id=<?= $inscricao['id'] ?>&estado=pendente"
                class="btn btn-aviso" style="justify-content:center;">
                ⏳ Colocar como pendente
              </a>

            </div>
          </div>

        </div>
      </div>

    </main>
  </div>

</body>

</html>