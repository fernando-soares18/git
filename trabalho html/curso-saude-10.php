<?php

declare(strict_types=1);

$cursos_file = __DIR__ . '/admin/cursos.json';
$cursos = [];

if (file_exists($cursos_file)) {
    $json = file_get_contents($cursos_file);
    $json = preg_replace('/^\xEF\xBB\xBF/', '', (string) $json);
    $data = json_decode((string) $json, true);
    if (is_array($data)) {
        $cursos = $data;
    }
}

usort($cursos, static function (array $a, array $b): int {
    $da = strtotime((string) ($a['data_publicacao'] ?? '1970-01-01'));
    $db = strtotime((string) ($b['data_publicacao'] ?? '1970-01-01'));
    return $db <=> $da;
});

function resumo_curso(string $html, int $max = 220): string
{
    $texto = trim(strip_tags($html));
    if ($texto === '') return 'Resumo indisponível.';
    if (function_exists('mb_strlen') && mb_strlen($texto) <= $max) return $texto;
    if (strlen($texto) <= $max) return $texto;
    return rtrim(mb_substr($texto, 0, $max - 1)) . '...';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso Saúde 10 | Dr. Charles Genehr</title>
    <link rel="stylesheet" href="/style.css">
    <style>
        .cat-hero {
            margin-top: 84px;
            padding: 60px 0 30px;
            background: linear-gradient(135deg, #1f6b75 0%, #2c8b80 100%);
            color: #fff;
        }

        .cat-hero h1 {
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            margin-bottom: 12px;
        }

        .cat-hero p {
            max-width: 780px;
            color: rgba(255, 255, 255, 0.9);
        }

        .cat-back {
            margin-top: 18px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 12px 24px;
            border-radius: 999px;
            border: 2px solid rgba(255, 255, 255, 0.8);
            background: #2c8b80;
            color: #ffffff;
            font-weight: 700;
            letter-spacing: 0.2px;
            text-decoration: none;
            box-shadow: 0 0 0 0 rgba(44, 139, 128, 0.65);
            animation: pulseBackButton 1.8s ease-out infinite;
            transition: transform 0.25s ease, background-color 0.25s ease;
        }

        .cat-back:hover {
            background: #26766d;
            color: #ffffff;
            transform: translateY(-1px);
        }

        @keyframes pulseBackButton {
            0%   { box-shadow: 0 0 0 0 rgba(44, 139, 128, 0.65); }
            70%  { box-shadow: 0 0 0 14px rgba(44, 139, 128, 0); }
            100% { box-shadow: 0 0 0 0 rgba(44, 139, 128, 0); }
        }

        .cat-list {
            padding: 50px 0 80px;
        }

        .cat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
            gap: 22px;
        }

        .cat-card {
            background: #fff;
            border: 1px solid rgba(31, 107, 117, 0.14);
            border-radius: 14px;
            box-shadow: 0 8px 22px rgba(31, 107, 117, 0.09);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .cat-card img {
            width: 100%;
            height: 185px;
            object-fit: cover;
        }

        .cat-card-body {
            padding: 18px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            height: 100%;
        }

        .cat-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            color: #5f6f6a;
            font-size: 0.85rem;
        }

        .cat-card h2 {
            font-size: 1.12rem;
            line-height: 1.35;
            color: #1f6b75;
        }

        .cat-card p {
            color: #4f605b;
            font-size: 0.95rem;
            line-height: 1.55;
        }

        .cat-card a {
            margin-top: auto;
            width: fit-content;
        }

        .cat-empty {
            background: #fff;
            border: 1px solid #dcebe6;
            border-radius: 14px;
            padding: 40px;
            color: #5f6f6a;
            text-align: center;
        }

        .cat-empty p { font-size: 1.05rem; margin: 0; }
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
    <section class="cat-hero">
        <div class="container">
            <p class="eyebrow" style="color:#d5f0e8;">Curso Saúde 10</p>
            <h1>Conteúdos do Curso Saúde 10</h1>
            <p>Materiais, aulas e conteúdos exclusivos para a sua saúde integral.</p>
            <a class="btn cat-back" href="/#curso">Voltar ao site</a>
        </div>
    </section>

    <section class="cat-list">
        <div class="container">
            <?php if (empty($cursos)): ?>
                <div class="cat-empty">
                    <p>📚 Em breve — novos conteúdos serão publicados aqui.</p>
                </div>
            <?php else: ?>
                <div class="cat-grid">
                    <?php foreach ($cursos as $curso): ?>
                        <article class="cat-card">
                            <?php if (!empty($curso['imagem_capa'])): ?>
                                <img src="<?= htmlspecialchars((string) $curso['imagem_capa'], ENT_QUOTES, 'UTF-8') ?>" alt="Capa do conteúdo">
                            <?php endif; ?>
                            <div class="cat-card-body">
                                <div class="cat-meta">
                                    <span><strong>Data:</strong> <?= htmlspecialchars(date('d/m/Y', strtotime((string) ($curso['data_publicacao'] ?? 'now'))), ENT_QUOTES, 'UTF-8') ?></span>
                                    <span><strong>Autor:</strong> <?= htmlspecialchars((string) ($curso['autor'] ?? 'Dr. Charles Genehr'), ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                                <h2><?= htmlspecialchars((string) ($curso['titulo'] ?? 'Sem título'), ENT_QUOTES, 'UTF-8') ?></h2>
                                <p><?= htmlspecialchars(resumo_curso((string) ($curso['conteudo'] ?? '')), ENT_QUOTES, 'UTF-8') ?></p>
                                <a class="btn" href="curso-item.php?id=<?= urlencode((string) ($curso['id'] ?? '')) ?>">Ver conteúdo completo</a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<script defer src="script.js"></script>
</body>
</html>
