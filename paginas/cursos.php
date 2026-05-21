<?php

require "../backend/curso.php";

$cursos = buscarCursosComDetalhesDeVagas()

?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cursos — Capacita CFTI</title>
  <link rel="stylesheet" href="../css/global.css">
  <style>
    .grelha-cursos {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }

    .cartao-curso {
      background: var(--branco);
      border: 1px solid var(--borda);
      border-radius: var(--raio-lg);
      overflow: hidden;
      box-shadow: var(--sombra);
      display: flex;
      flex-direction: column;
    }

    .curso-topo {
      background: var(--azul);
      padding: 28px 24px;
      position: relative;
      overflow: hidden;
    }

    .curso-topo::before {
      content: '';
      position: absolute;
      top: -30px;
      right: -30px;
      width: 130px;
      height: 130px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(201, 168, 76, 0.1) 0%, transparent 70%);
    }

    .curso-emoji {
      font-size: 34px;
      display: block;
      margin-bottom: 12px;
      position: relative;
      z-index: 1;
    }

    .curso-nome {
      font-family: 'Playfair Display', serif;
      font-size: 17px;
      color: #FFF;
      margin-bottom: 4px;
      position: relative;
      z-index: 1;
    }

    .curso-subtitulo {
      font-size: 12px;
      color: rgba(255, 255, 255, 0.4);
      position: relative;
      z-index: 1;
    }

    .curso-corpo {
      padding: 20px 24px;
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .curso-descricao {
      font-size: 13px;
      color: var(--texto-sub);
      line-height: 1.65;
      margin-bottom: 18px;
      flex: 1;
    }

    .curso-info {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      margin-bottom: 18px;
    }

    .info-item {
      background: var(--creme);
      border-radius: 7px;
      padding: 9px 12px;
    }

    .info-chave {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.07em;
      color: var(--texto-mudo);
      margin-bottom: 2px;
    }

    .info-valor {
      font-size: 13px;
      font-weight: 600;
      color: var(--texto);
    }

    .curso-tags {
      display: flex;
      gap: 6px;
      flex-wrap: wrap;
      margin-bottom: 16px;
    }

    .curso-vagas {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 12px;
      color: var(--texto-mudo);
      padding-top: 14px;
      border-top: 1px solid #EAF0F7;
    }

    .curso-vagas strong {
      color: var(--texto);
    }

    .btn-inscrever {
      display: block;
      text-align: center;
      margin-top: 14px;
      padding: 12px;
      background: var(--azul);
      color: #FFF;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      font-size: 14px;
      transition: all 0.18s;
    }

    .btn-inscrever:hover {
      background: var(--azul-medio);
    }

    @media (max-width: 768px) {
      .grelha-cursos {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>

  <nav class="navbar">
    <div class="navbar-interior">
      <a href="../inicio.php" class="navbar-marca">
        <div class="navbar-marca-icone">🎓</div>
        <div>
          <div class="navbar-marca-nome">Capacita CFTI</div>
          <div class="navbar-marca-sub">Centro de Formação em TI</div>
        </div>
      </a>
      <div class="navbar-links">
        <a href="../inicio.php" class="navbar-link">Início</a>
        <a href="cursos.php" class="navbar-link activo">Cursos</a>
        <a href="inscricao.php" class="navbar-link">Inscrição</a>
        <a href="contacto.html" class="navbar-link">Contacto</a>
      </div>
      <div class="navbar-cta"><a href="inscricao.php" class="btn-nav">Inscrever-me</a></div>
    </div>
  </nav>

  <div class="cab-pagina">
    <div class="cab-pagina-interior">
      <div class="cab-pagina-label">
        <div class="cab-pagina-label-linha"></div><span>Turma Janeiro 2025</span>
      </div>
      <h1>Oferta <em>Formativa</em></h1>
      <p class="cab-pagina-desc">Formação prática, certificada e alinhada com as necessidades do mercado de trabalho actual.</p>
    </div>
  </div>

  <div class="contentor">
    <div class="grelha-cursos">

      <?php
      foreach ($cursos as $curso) {
      ?>

        <div class="cartao-curso animar">
          <div class="curso-topo">
            <span class="curso-emoji"> <?= EMOJIS[$curso["emoji"]] ?> </span>
            <div class="curso-nome"> <?= $curso["nome"] ?> </div>
            <div class="curso-subtitulo"> <?= $curso["subtitulo"] ?> </div>
          </div>
          <div class="curso-corpo">
            <p class="curso-descricao">Aprenda a criar interfaces web modernas, responsivas e interativas. Domine as tecnologias mais exigidas pelo mercado, incluindo React e frameworks actuais.</p>
            <div class="curso-info">
              <div class="info-item">
                <div class="info-chave">Duração</div>
                <div class="info-valor"> <?= $curso["duracao"] ?> </div>
              </div>
              <div class="info-item">
                <div class="info-chave">Modalidade</div>
                <div class="info-valor"><?= $curso["modalidade"] ?></div>
              </div>
              <div class="info-item">
                <div class="info-chave">Início</div>
                <div class="info-valor"><?= $curso["inicio"] ?></div>
              </div>
              <div class="info-item">
                <div class="info-chave">Horário</div>
                <div class="info-valor"> <?= $curso["horario"] ?> </div>
              </div>
            </div>
            <div class="curso-tags">
              <span class="etiqueta etiqueta-azul"> <?= $curso["duracao"] ?> </span>
              <span class="etiqueta etiqueta-verde"> <?= $curso["modalidade"] ?> </span>
              <span class="etiqueta etiqueta-ouro">Certificado</span>
            </div>
            <div class="curso-vagas"><span><?= $curso["total_inscritos"] ?> Inscritos</span><span><?= $curso["vagas"] ?> vagas — <strong><?= $curso["vagas"] - $curso["total_inscritos"] ?> restantes</strong></span></div>
            <a href="inscricao.php" class="btn-inscrever">Inscrever-me neste curso</a>
          </div>
        </div>

      <?php
      }
      ?>

    </div>
  </div>

  <footer class="rodape">
    <div class="rodape-interior">
      <div>
        <div class="rodape-marca">Capacita CFTI</div>
        <div class="rodape-sub">Centro de Formação em Tecnologias de Informação</div>
      </div>
      <div class="rodape-links">
        <a href="../inicio.php">Início</a>
        <a href="cursos.php">Cursos</a>
        <a href="inscricao.php">Inscrição</a>
        <a href="contacto.html">Contacto</a>
      </div>
    </div>
    <div class="rodape-direitos">© 2025 Capacita CFTI — Laboratório 2, Módulo 6</div>
  </footer>

</body>

</html>