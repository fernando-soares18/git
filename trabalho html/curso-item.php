<?php

declare(strict_types=1);

$cursos_file = __DIR__ . '/admin/cursos.json';
$cursos = [];

if (file_exists($cursos_file)) {
    $json = file_get_contents($cursos_file);
    $json = preg_replace('/^\xEF\xBB\xBF/', '', (string) $json);
    $data = json_decode((string) $json, true);
    if (is_array($data)) {
        foreach ($data as $c) {
            if (isset($c['id'])) {
                $cursos[$c['id']] = $c;
            }
        }
    }
}

$id = isset($_GET['id']) ? (string) $_GET['id'] : '';

if (!isset($cursos[$id])) {
    header('Location: curso-saude-10.php');
    exit;
}

$curso = $cursos[$id];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars((string) ($curso['titulo'] ?? 'Curso'), ENT_QUOTES, 'UTF-8') ?> | Dr. Charles Genehr</title>
    <link rel="stylesheet" href="/style.css">
    <script defer src="script.js"></script>
    <style>
        .article-hero {
            background: linear-gradient(135deg, var(--green-dark) 0%, var(--green-strong) 100%);
            color: var(--white);
            padding: 80px 0 60px;
            margin-top: 80px;
        }

        .article-hero h1 {
            font-size: clamp(2rem, 5vw, 3rem);
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .article-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            margin-top: 18px;
        }

        .article-meta span {
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 12px;
            padding: 10px 12px;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.95);
        }

        .article-container { max-width: 800px; margin: 0 auto; }

        .article-body {
            padding: 60px 0;
            font-size: 1.05rem;
            line-height: 1.8;
            color: var(--text);
        }

        .article-image-box,
        .article-content-box,
        .article-nav-box {
            background: #fff;
            border: 1px solid rgba(31, 107, 117, 0.12);
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(31, 107, 117, 0.08);
        }

        .article-image-box { padding: 14px; margin-bottom: 26px; }
        .article-content-box { padding: 30px; }
        .article-nav-box { margin-top: 24px; padding: 22px; text-align: center; }

        .article-body h2 { font-size: 1.8rem; color: var(--green-dark); margin: 40px 0 20px; }
        .article-body h3 { font-size: 1.4rem; color: var(--green-strong); margin: 30px 0 15px; }
        .article-body p { margin-bottom: 18px; text-align: justify; }
        .article-body ul { list-style: none; padding: 0; margin: 20px 0; }
        .article-body ul li { padding-left: 30px; margin-bottom: 12px; position: relative; }
        .article-body ul li:before { content: "✓"; position: absolute; left: 0; color: var(--green-dark); font-weight: bold; }
        .article-body strong { color: var(--green-dark); font-weight: 600; }

        .article-back {
            display: inline-block;
            margin-bottom: 40px;
            color: var(--white);
            text-decoration: none;
            font-weight: 600;
            opacity: 0.9;
        }

        .article-back:hover { opacity: 1; text-decoration: underline; }

        .article-cta {
            background: var(--green-soft);
            border-left: 5px solid var(--green-dark);
            padding: 40px;
            border-radius: 12px;
            margin-top: 60px;
            text-align: center;
        }

        .article-cta h3 { margin-top: 0; color: var(--green-dark); }

        @media (max-width: 768px) {
            .article-hero { padding: 60px 0 40px; margin-top: 70px; }
            .article-hero h1 { font-size: 1.8rem; }
            .article-body { padding: 40px 0; font-size: 1rem; }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="container nav-bar">
            <a class="logo" href="/">
                <img src="assets/logo-dr-charles-12.png" alt="Logo Dr. Charles Genehr" class="header-logo">
                <span>Dr. Charles Genehr</span>
            </a>
            <nav id="menu" class="nav-links">
                <a href="/#home">Início</a>
                <a href="/#sobre">Sobre</a>
                <a href="/#especialidades">Especialidades</a>
                <a href="/#artigos">Artigos</a>
                <a href="/#depoimentos">Depoimentos</a>
                <a href="/#contato">Contato</a>
            </nav>
            <button class="hamburguer" id="hamburguer" aria-label="Abrir menu">☰</button>
        </div>
    </header>

    <main>
        <section class="article-hero">
            <div class="container">
                <a href="curso-saude-10.php" class="article-back">← Voltar ao Curso Saúde 10</a>
                <h1><?= htmlspecialchars((string) ($curso['titulo'] ?? ''), ENT_QUOTES, 'UTF-8') ?></h1>
                <div class="article-meta">
                    <span><strong>Categoria:</strong> Curso Saúde 10</span>
                    <span><strong>Data:</strong> <?= htmlspecialchars(date('d/m/Y', strtotime((string) ($curso['data_publicacao'] ?? 'now'))), ENT_QUOTES, 'UTF-8') ?></span>
                    <span><strong>Autor:</strong> <?= htmlspecialchars((string) ($curso['autor'] ?? 'Dr. Charles Genehr'), ENT_QUOTES, 'UTF-8') ?></span>
                </div>
            </div>
        </section>

        <article class="article-body">
            <div class="container article-container">
                <?php if (!empty($curso['imagem_capa'])): ?>
                    <div class="article-image-box">
                        <img src="<?= htmlspecialchars((string) $curso['imagem_capa'], ENT_QUOTES, 'UTF-8') ?>" alt="Imagem do conteúdo" style="width:100%; height:auto; border-radius:12px; object-fit:cover;">
                    </div>
                <?php endif; ?>

                <div class="article-content-box">
                    <?= $curso['conteudo'] ?>

                    <div class="article-cta">
                        <h3>Pronto para transformar sua saúde?</h3>
                        <p>Agende uma consulta com o Dr. Charles para um plano personalizado alinhado com seus objetivos de bem-estar.</p>
                        <a href="/#contato" class="btn">Agendar Consulta</a>
                    </div>
                </div>

                <div class="article-nav-box">
                    <a href="curso-saude-10.php" class="btn" style="background:#1f6b75; color:#fff; padding:14px 32px; border-radius:30px; text-decoration:none; font-weight:600; font-size:1rem;">← Voltar ao Curso Saúde 10</a>
                </div>
            </div>
        </article>
    </main>

    <footer style="background:#f0f0f0; padding:40px 0; text-align:center; color:#666; margin-top:80px;">
        <div class="container">
            <p>&copy; <?= date('Y') ?> Dr. Charles Genehr. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>
