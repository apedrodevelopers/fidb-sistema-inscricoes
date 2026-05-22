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

$idCurso = $_GET["id"] ?? "";

if ($idCurso === "") {

  header("Location: listar.php");
  exit;
}

$curso = buscarCursoPorId($idCurso);

// (
//     [id] => 10
//     [emoji] => computador
//     [nome] => teste
//     [subtitulo] => tste teste
//     [area] => Tecnologia Web
//     [duracao] => 4 meses
//     [modalidade] => Presencial
//     [vagas] => 60
//     [estado] => activo
//     [inicio] => 2026-05-30
//     [horario] => Manhã (08h–12h)
//     [preco] => 12000.00
//     [criado_em] => 2026-05-22 02:50:19
//     [actualizado_em] => 2026-05-22 02:50:19
?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Curso — Capacita CFTI</title>
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
        <div class="barra-topo-titulo">Editar Curso</div>
        <div class="barra-topo-sub">Desenvolvimento Web Frontend</div>
      </div>
    </header>

    <main class="conteudo">

      <div class="cab-secao">
        <div>
          <div class="cab-titulo">Editar curso</div>
          <div class="cab-sub">Altere os campos pretendidos e guarde</div>
        </div>
        <a href="listar.php" class="btn btn-secundario">← Voltar à lista</a>
      </div>

      <!-- action="editar.php?id=1" method="POST" — a implementar no backend -->
      <form action="../../backend/curso.php" method="POST">
        <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
        <input type="hidden" name="action" value="UPDATE">

        <div class="cartao animar">
          <div class="cartao-cab">
            <div class="cartao-titulo">Identificação do curso</div>
          </div>
          <div class="cartao-corpo">

            <div class="linha-2">
              <div class="grupo">
                <label class="rotulo" for="emoji">Emoji <span class="obg">*</span></label>
                <select id="emoji" name="emoji">
                  <?php
                  foreach (EMOJIS as $index => $emoji) {
                  ?>
                    <option value="<?= $index ?>" <?= $index === $curso["emoji"] ? "selected" : "" ?>><?= $emoji . " " . ucfirst($index) ?> </option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="grupo">
                <label class="rotulo" for="estado">Estado <span class="obg">*</span></label>
                <select id="estado" name="estado">
                  <option value="activo" <?= "activo" === $curso["estado"] ? "selected" : "" ?>>🟢 Activo</option>
                  <option value="em-breve" <?= "em-breve" === $curso["estado"] ? "selected" : "" ?>>🟡 Em breve</option>
                  <option value="inactivo" <?= "inativo" === $curso["estado"] ? "selected" : "" ?>>🔴 Inactivo</option>
                </select>
              </div>
            </div>

            <div class="grupo">
              <label class="rotulo" for="nome">Nome do curso <span class="obg">*</span></label>
              <input type="text" id="nome" name="nome" value="<?= $curso["nome"] ?>" required>
            </div>

            <div class="grupo">
              <label class="rotulo" for="subtitulo">Subtítulo / Tecnologias <span class="obg">*</span></label>
              <input type="text" id="subtitulo" name="subtitulo" value="<?= $curso["subtitulo"] ?>" required>
            </div>

            <div class="linha-2">
              <div class="grupo">
                <label class="rotulo" for="area">Área temática <span class="obg">*</span></label>
                <select id="area" name="area">
                  <option <?= "Tecnologia Web" === $curso["area"] ? "selected" : "" ?>>Tecnologia Web</option>
                  <option <?= "Dados" === $curso["area"] ? "selected" : "" ?>>Dados</option>
                  <option <?= "Design" === $curso["area"] ? "selected" : "" ?>>Design</option>
                  <option <?= "Infraestrutura" === $curso["area"] ? "selected" : "" ?>>Infraestrutura</option>
                  <option <?= "Segurança" === $curso["area"] ? "selected" : "" ?>>Segurança</option>
                  <option <?= "Mobile" === $curso["area"] ? "selected" : "" ?>>Mobile</option>
                  <option <?= "Cloud / DevOps" === $curso["area"] ? "selected" : "" ?>>Cloud / DevOps</option>
                  <option <?= "Inteligência Artificial" === $curso["area"] ? "selected" : "" ?>>Inteligência Artificial</option>
                </select>
              </div>
              <div class="grupo">
                <label class="rotulo" for="duracao">Duração <span class="obg">*</span></label>
                <select id="duracao" name="duracao">
                  <option <?= "1 mês" === $curso["duracao"] ? "selected" : "" ?>>1 mês</option>
                  <option <?= "2 meses" === $curso["duracao"] ? "selected" : "" ?>>2 meses</option>
                  <option <?= "3 meses" === $curso["duracao"] ? "selected" : "" ?>>3 meses</option>
                  <option <?= "4 meses" === $curso["duracao"] ? "selected" : "" ?>>4 meses</option>
                  <option <?= "5 meses" === $curso["duracao"] ? "selected" : "" ?>>5 meses</option>
                  <option <?= "6 meses" === $curso["duracao"] ? "selected" : "" ?>>6 meses</option>
                </select>
              </div>
            </div>

          </div>
        </div>

        <div class="cartao animar" style="animation-delay:.08s">
          <div class="cartao-cab">
            <div class="cartao-titulo">Detalhes e disponibilidade</div>
          </div>
          <div class="cartao-corpo">

            <div class="linha-3">
              <div class="grupo">
                <label class="rotulo" for="modalidade">Modalidade <span class="obg">*</span></label>
                <select id="modalidade" name="modalidade">
                  <option <?= "Presencial" === $curso["modalidade"] ? "selected" : "" ?>>Presencial</option>
                  <option <?= "Online" === $curso["modalidade"] ? "selected" : "" ?>>Online</option>
                  <option <?= "Híbrido" === $curso["modalidade"] ? "selected" : "" ?>>Híbrido</option>
                </select>
              </div>
              <div class="grupo">
                <label class="rotulo" for="vagas">Nº de vagas <span class="obg">*</span></label>
                <input type="number" id="vagas" name="vagas" min="1" value="<?= $curso["vagas"] ?>" required>
              </div>
              <div class="grupo">
                <label class="rotulo" for="preco">Propina (AOA)</label>
                <input type="number" id="preco" name="preco" min="0" step="500" value="<?= $curso["preco"] ?>">
              </div>
            </div>

            <div class="linha-2">
              <div class="grupo">
                <label class="rotulo" for="inicio">Data de início <span class="obg">*</span></label>
                <input type="date" id="inicio" name="inicio" required>
              </div>
              <div class="grupo">
                <label class="rotulo" for="horario">Horário <span class="obg">*</span></label>
                <select id="horario" name="horario">
                  <option <?= "Manhã (08h–12h)" === $curso["horario"] ? "selected" : "" ?>>Manhã (08h–12h)</option>
                  <option <?= "Tarde (14h–18h)" === $curso["horario"] ? "selected" : "" ?>>Tarde (14h–18h)</option>
                  <option <?= "Pós-laboral (18h–21h)" === $curso["horario"] ? "selected" : "" ?>>Pós-laboral (18h–21h)</option>
                  <option <?= "Sábados (08h–13h)" === $curso["horario"] ? "selected" : "" ?>>Sábados (08h–13h)</option>
                  <option <?= "Flexível" === $curso["horario"] ? "selected" : "" ?>>Flexível</option>
                </select>
              </div>
            </div>

          </div>
        </div>

        <div style="display:flex; gap:10px; justify-content:flex-end;">
          <a href="listar.php" class="btn btn-secundario">Cancelar</a>
          <button type="submit" class="btn btn-primario">✓ Guardar alterações</button>
        </div>

      </form>

    </main>
  </div>

</body>

</html>