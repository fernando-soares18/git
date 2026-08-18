<?php

declare(strict_types=1);

$artigosFile = __DIR__ . '/admin/artigos.json';
$artigos = [];

if (file_exists($artigosFile)) {
    $json = file_get_contents($artigosFile);
    $json = preg_replace('/^\xEF\xBB\xBF/', '', (string) $json);
    $data = json_decode((string) $json, true);
    if (is_array($data)) {
        foreach ($data as $item) {
            if (isset($item['id'])) {
                $artigos[(string) $item['id']] = $item;
            }
        }
    }
}

$id = (string) ($_GET['id'] ?? '');
if ($id === '' || !isset($artigos[$id])) {
    header('Location: index.php#artigos');
    exit;
}

$artigo = $artigos[$id];
$titulo = (string) ($artigo['titulo'] ?? 'Sem título');
$categoria = (string) ($artigo['categoria'] ?? 'Artigos');
$dataPublicacao = (string) ($artigo['data_publicacao'] ?? 'now');
$autor = (string) ($artigo['autor'] ?? 'Dr. Charles Genehr');
$imagem = (string) ($artigo['imagem_capa'] ?? '');
$conteudo = (string) ($artigo['conteudo'] ?? 'Conteúdo indisponível.');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?> | Dr. Charles Genehr</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .article-wrap { max-width: 900px; margin: 110px auto 60px; padding: 0 18px; }
        .article-meta { display: flex; gap: 10px; flex-wrap: wrap; margin: 12px 0 22px; }
        .article-meta span { background: #f0f7f5; color: #1f6b75; border-radius: 999px; padding: 6px 12px; font-size: 0.92rem; }
        .article-cover { width: 100%; border-radius: 14px; margin-bottom: 20px; max-height: 420px; object-fit: cover; }
        .article-box { background: #fff; border: 1px solid rgba(31,107,117,.15); border-radius: 14px; padding: 24px; }
        .article-box h2, .article-box h3 { color: #1f6b75; }
        .article-box p { line-height: 1.8; color: #33413d; }
    </style>
</head>
<body>
<header class="site-header">
    <div class="container nav-bar">
        <a class="logo" href="index.php"><img src="assets/logo-dr-charles-12.png" alt="Logo Dr. Charles Genehr" class="header-logo"><span>Dr. Charles Genehr</span></a>
        <nav id="menu" class="nav-links">
            <a href="index.php#home">Início</a>
            <a href="index.php#artigos">Artigos</a>
            <a href="ebooks.php">eBooks</a>
            <a href="index.php#contato">Contato</a>
        </nav>
        <button class="hamburguer" id="hamburguer" aria-label="Abrir menu">☰</button>
    </div>
</header>

<main class="article-wrap">
    <a class="btn" href="index.php#artigos" style="margin-bottom:18px;display:inline-block;">Voltar aos artigos</a>
    <h1><?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?></h1>
    <div class="article-meta">
        <span><?= htmlspecialchars($categoria, ENT_QUOTES, 'UTF-8') ?></span>
        <span><?= htmlspecialchars(date('d/m/Y', strtotime($dataPublicacao)), ENT_QUOTES, 'UTF-8') ?></span>
        <span><?= htmlspecialchars($autor, ENT_QUOTES, 'UTF-8') ?></span>
    </div>
    <?php if ($imagem !== ''): ?>
        <img class="article-cover" src="<?= htmlspecialchars($imagem, ENT_QUOTES, 'UTF-8') ?>" alt="Imagem do artigo">
    <?php endif; ?>
    <article class="article-box">
        <?= $conteudo ?>
    </article>
</main>

<script defer src="script.js"></script>
</body>
</html>
