<?php

declare(strict_types=1);

$ebooks_file = __DIR__ . '/admin/ebooks.json';
$ebooks = [];

if (file_exists($ebooks_file)) {
    $ebooks_json = file_get_contents($ebooks_file);
    $ebooks_json = preg_replace('/^\xEF\xBB\xBF/', '', (string) $ebooks_json);
    $ebooks_data = json_decode((string) $ebooks_json, true);

    if (is_array($ebooks_data)) {
        $ebooks = $ebooks_data;
    }
}

if (empty($ebooks)) {
    $ebooks = [
        [
            'titulo' => 'Saúde da pele e bem-estar',
            'descricao' => 'Um guia prático sobre cuidados com a pele, nutrição e hábitos que favorecem a saúde integral.',
            'link' => 'https://www.amazon.com.br/dp/B0FG8HV69F'
        ],
        [
            'titulo' => 'Nutrição para viver melhor',
            'descricao' => 'Conteúdo sobre alimentação funcional, metabolismo e escolhas que promovem energia e equilíbrio.',
            'link' => 'https://www.amazon.com.br/dp/B0FG87D936'
        ],
        [
            'titulo' => 'Equilíbrio e medicina integrativa',
            'descricao' => 'Uma visão completa sobre prevenção, autocuidado e o papel da medicina integrativa na saúde duradoura.',
            'link' => 'https://www.amazon.com.br/dp/B073V816YN'
        ]
    ];
}

$por_pagina = 12;
$total_ebooks = count($ebooks);
$total_paginas = max(1, (int) ceil($total_ebooks / $por_pagina));
$pagina_atual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$pagina_atual = max(1, min($pagina_atual, $total_paginas));
$offset = ($pagina_atual - 1) * $por_pagina;
$ebooks_paginados = array_slice($ebooks, $offset, $por_pagina);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>eBooks | Dr. Charles Genehr</title>
<link rel="stylesheet" href="/style.css">
<style>
    .ebooks-hero {
        margin-top: 84px;
        padding: 60px 0 30px;
        background: linear-gradient(135deg, #1f6b75 0%, #2c8b80 100%);
        color: #fff;
    }

    .ebooks-hero p {
        max-width: 760px;
        color: rgba(255, 255, 255, 0.9);
    }

    .ebooks-list {
        padding: 50px 0 80px;
    }

    .ebooks-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .ebook-capa {
        width: 100%;
        border-radius: 8px;
        margin-bottom: 14px;
        object-fit: cover;
        max-height: 220px;
        display: block;
    }

    .ebook-capa-placeholder {
        width: 100%;
        height: 200px;
        border-radius: 8px;
        margin-bottom: 14px;
        background: linear-gradient(135deg, #1f6b75 0%, #2c8b80 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        color: #fff;
    }

    .ebook-capa-placeholder svg { opacity: 0.9; }
    .ebook-capa-placeholder span { font-size: 0.75rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; opacity: 0.85; }

    .ebooks-pagination {
        margin-top: 28px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .ebooks-pagination a,
    .ebooks-pagination span {
        min-width: 42px;
        height: 42px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 14px;
        border: 1px solid #d7e7e2;
        color: #1f6b75;
        text-decoration: none;
        background: #fff;
        font-weight: 600;
    }

    .ebooks-pagination a:hover {
        background: #eaf5f2;
    }

    .ebooks-pagination .active {
        background: #2c8b80;
        border-color: #2c8b80;
        color: #fff;
    }

    .ebooks-back {
        margin-top: 18px;
        display: inline-flex;
        align-items: center;
        padding: 12px 24px;
        border-radius: 999px;
        border: 2px solid rgba(255, 255, 255, 0.8);
        background: #2c8b80;
        color: #ffffff;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 0 0 0 rgba(44, 139, 128, 0.65);
        animation: pulseBackButton 1.8s ease-out infinite;
    }

    .ebooks-back:hover {
        background: #26766d;
        color: #ffffff;
    }

    @keyframes pulseBackButton {
        0% {
            box-shadow: 0 0 0 0 rgba(44, 139, 128, 0.65);
        }
        70% {
            box-shadow: 0 0 0 14px rgba(44, 139, 128, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(44, 139, 128, 0);
        }
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
    <section class="ebooks-hero">
        <div class="container">
            <p class="eyebrow" style="color:#d5f0e8;">eBooks</p>
            <h1>Biblioteca rica em materiais para sua saúde</h1>
            <p>Aqui estão todos os eBooks cadastrados.</p>
            <a class="btn ebooks-back" href="/#home">Voltar ao site</a>
        </div>
    </section>

    <section class="ebooks-list">
        <div class="container">
            <div class="ebooks-grid">
                <?php foreach ($ebooks_paginados as $ebook): ?>
                    <article class="card ebook-card">
                        <?php if (!empty($ebook['capa'])): ?>
                            <img
                                src="<?= htmlspecialchars((string) $ebook['capa'], ENT_QUOTES, 'UTF-8') ?>"
                                alt="Capa do eBook"
                                class="ebook-capa"
                            >
                        <?php else: ?>
                            <div class="ebook-capa-placeholder">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                <span>PDF Clínico</span>
                            </div>
                        <?php endif; ?>
                        <h3><?= htmlspecialchars((string) ($ebook['titulo'] ?? 'eBook'), ENT_QUOTES, 'UTF-8') ?></h3>
                        <p><?= htmlspecialchars((string) ($ebook['descricao'] ?? 'Conteúdo em breve.'), ENT_QUOTES, 'UTF-8') ?></p>
                        <?php if (!empty($ebook['download'])): ?>
                            <a href="<?= htmlspecialchars((string) ($ebook['link'] ?? '#'), ENT_QUOTES, 'UTF-8') ?>" download class="text-link">⬇️ Baixar PDF</a>
                        <?php else: ?>
                            <a href="<?= htmlspecialchars((string) ($ebook['link'] ?? '#'), ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener" class="text-link">Acessar eBook</a>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php if ($total_paginas > 1): ?>
                <nav class="ebooks-pagination" aria-label="Paginação de eBooks">
                    <?php if ($pagina_atual > 1): ?>
                        <a href="?pagina=<?= $pagina_atual - 1 ?>" aria-label="Página anterior">&laquo;</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <?php if ($i === $pagina_atual): ?>
                            <span class="active" aria-current="page"><?= $i ?></span>
                        <?php else: ?>
                            <a href="?pagina=<?= $i ?>"><?= $i ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($pagina_atual < $total_paginas): ?>
                        <a href="?pagina=<?= $pagina_atual + 1 ?>" aria-label="Próxima página">&raquo;</a>
                    <?php endif; ?>
                </nav>
            <?php endif; ?>
        </div>
    </section>
</main>

<script defer src="script.js"></script>
</body>
</html>
